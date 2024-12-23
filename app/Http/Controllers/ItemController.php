<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Image;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Typography\FontFactory;

class ItemController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Items', 'url' => route('items.index')]
        ];

        if (Auth::user()->hasRole('admin')) {
            $items = Item::all();
            return view('items.admin.index', compact('breadcrumbs', 'items'));
        } elseif (Auth::user()->hasRole('user')) {
            $items = Item::where('user_id', auth()->user()->id)->get();
            return view('items.user.index', compact('breadcrumbs', 'items'));
        } else {
            abort(404);
        }
    }

    public function create()
    {
        $breadcrumbs = [
            ['name' => 'Items', 'url' => route('items.index')],
            ['name' => 'Create', 'url' => '']
        ];

        // only user
        if (auth()->user()->hasRole('user')) {
            return view('items.user.create', compact('breadcrumbs'));
        }
        abort(403);
    }

    /**
     * Store a newly created item in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'image' => 'required|file|max:5000', // Validasi file tanpa image/mimes
        ]);

        // Proses gambar
        $imageFile = $request->file('image');
        $fileTmpPath = $imageFile->getRealPath();

        // Validasi MIME type menggunakan exif_imagetype
        $allowedTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG];
        if (!in_array(exif_imagetype($fileTmpPath), $allowedTypes)) {
            return response()->json([
                'message' => 'Invalid image type. Only JPEG and PNG are allowed.',
            ], 422);
        }

        // Buat nama file unik
        $filename = Str::random(20) . '.' . $imageFile->getClientOriginalExtension();

        // Buat instance gambar menggunakan Intervention Image
        $manager = new ImageManager(new Driver());

        // read image from filesystem
        $image = $manager->read($imageFile);
        // Buat instance gambar menggunakan Intervention Image
        // $image = Image::read($fileTmpPath);

        // Atur faktor resize berdasarkan ukuran file
        $imageSize = $imageFile->getSize();

        if ($imageSize > 5000000) { // > 5MB
            $resizeFactor = 0.5;
        } elseif ($imageSize > 1500000) { // > 1.5MB
            $resizeFactor = 0.7;
        } else {
            $resizeFactor = 1;
        }

        // Resize jika perlu
        if ($resizeFactor < 1) {
            $image->resize($image->width() * $resizeFactor, $image->height() * $resizeFactor, function ($constraint) {
                $constraint->aspectRatio(); // Pertahankan rasio aspek
            });
        }
        // // write text at a certain position
        // $image->text('Image by: ' . config('app.name'), 50, 100, function (FontFactory $font) {
        //     $font->file(public_path('assets/fonts/SourceSans3-BoldItalic.ttf'));
        //     $font->size(70);
        //     $font->color('#fff');
        //     $font->stroke('#000', 2);
        // });

        // Simpan gambar di direktori storage
        $itemPath = "items/{$filename}";
        // Storage::put("public/{$itemPath}", (string) $image->encode());
        $filePath = storage_path("app/public/{$itemPath}");
        // cek dan buat folder jika belum ada
        if(!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);        
        }
        
        file_put_contents($filePath, (string) $image->encode());


        // Generate QR code
        $uuid = Str::uuid();
        $urlQRCode = env('APP_URL') . '/c/' . $uuid;
        $qrCodePath = "{$uuid}.png";
        // Storage::put("public/qrcodes/{$qrCodePath}", QrCode::format('png')->size(600)->margin(2)->generate($urlQRCode));
        $qrCodeContent = QrCode::format('png')->size(500)->margin(2)->generate($urlQRCode);
        $relativePath = "qrcodes/{$qrCodePath}"; // Path relatif
        $absolutePath = storage_path("app/public/{$relativePath}"); // Path absolut

        // Tentukan path relatif dan absolut
        $relativePath = "qrcodes/{$qrCodePath}";
        $absolutePath = storage_path("app/public/{$relativePath}");

        // Cek dan buat folder jika belum ada
        $directory = dirname($absolutePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        // Simpan QR code menggunakan path absolut
        file_put_contents($absolutePath, $qrCodeContent);


        // Simpan data ke database
        $item = Item::create([
            'uuid' => $uuid,
            'image' => $filename,
            'user_id' => auth()->id(),
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'qr_code_path' => $qrCodePath,
        ]);

        // Redirect dengan respon JSON
        if($item){
            return response()->json([
                'message' => 'Item created successfully',
                'redirect' => route('items.index')
            ], 200);
        } else {
            return response()->json([
                'message' => 'Item creation failed',
            ], 500);
        }
    }


    public function edit(Item $item)
    {
        $breadcrumbs = [
            ['name' => 'Items', 'url' => route('items.index')],
            ['name' => 'Edit', 'url' => '']
        ];

        return view('items.user.edit', compact('breadcrumbs', 'item'));
    }

    public function update(Request $request, Item $item)
    {
        // Validasi input request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        // Proses gambar
        $imageFile = $request->file('image');
        if ($imageFile) {
            $filename = Str::random(20) . '.' . $imageFile->getClientOriginalExtension();

            // Buat instance gambar menggunakan Intervention Image
            $manager = new ImageManager(new Driver());

            // read image from filesystem
            $image = $manager->read($imageFile);

            $imageSize = $imageFile->getSize();

            if ($imageSize > 5000000) { // > 5MB
                $resizeFactor = 0.5;
            } elseif ($imageSize > 1500000) { // > 1.5MB
                $resizeFactor = 0.7;
            } else {
                $resizeFactor = 1;
            }

            // Resize jika perlu
            if ($resizeFactor < 1) {
                $image->resize($image->width() * $resizeFactor, null, function ($constraint) {
                    $constraint->aspectRatio(); // Pertahankan rasio aspek
                });
            }

            // Simpan gambar di direktori storage
            $itemPath = "items/{$filename}";
            // Storage::put("public/{$itemPath}", (string) $image->encode());
            $filePath = storage_path("app/public/{$itemPath}");
            
            file_put_contents($filePath, (string) $image->encode());

            // Hapus gambar lama
            // Storage::delete("public/items/{$item->image}");
            // hapus gambar lama dengan file_exists
            if (file_exists(storage_path("app/public/items/{$item->image}"))) {
                unlink(storage_path("app/public/items/{$item->image}"));
            }

            $item->image = $filename;
        }

        $item->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);

        // Redirect dengan respon JSON
        return response()->json([
            'message' => 'Item updated successfully',
            'redirect' => route('items.index')
        ], 200);
    }

    public function destroy(Item $item)
    {
        // delete files
        // Storage::delete("public/items/{$item->image}");
        // Storage::delete("public/qrcodes/{$item->qr_code_path}");
        // hapus gambar lama dengan file_exists
        if (file_exists(storage_path("app/public/items/{$item->image}"))) {
            unlink(storage_path("app/public/items/{$item->image}"));
        }
        if (file_exists(storage_path("app/public/qrcodes/{$item->qr_code_path}"))) {
            unlink(storage_path("app/public/qrcodes/{$item->qr_code_path}"));
        }

        $item->delete();

        // Redirect dengan respon JSON
        return response()->json([
            'message' => 'Item deleted successfully',
            'redirect' => route('items.index')
        ], 200);
    }
}
