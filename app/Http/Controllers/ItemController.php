<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
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

        $items = Item::where('user_id', auth()->user()->id)->get();
        return view('items.index', compact('breadcrumbs', 'items'));
    }

    public function create()
    {
        $breadcrumbs = [
            ['name' => 'Items', 'url' => route('items.index')],
            ['name' => 'Create', 'url' => '']
        ];

        return view('items.create', compact('breadcrumbs'));
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
            'image' => 'required|image|mimes:jpeg,jpg,png|max:5000', // Max size 5MB
        ]);

        // Proses gambar
        $imageFile = $request->file('image');
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
        Storage::put("public/{$itemPath}", (string) $image->encode());

        // Generate QR code
        $uuid = Str::uuid();
        $qrCodePath = "{$uuid}.png";
        Storage::put("public/qrcodes/{$qrCodePath}", QrCode::format('png')->size(600)->margin(2)->generate($uuid));

        // Simpan data ke database (contoh model Item)
        Item::create([
            'uuid' => $uuid,
            'image' => $filename,
            'user_id' => auth()->id(),
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'qr_code_path' => $qrCodePath,
        ]);

        // Redirect dengan respon JSON
        return response()->json([
            'message' => 'Item created successfully',
            'redirect' => route('items.index')
        ], 200);
    }

    public function edit(Item $item)
    {
        $breadcrumbs = [
            ['name' => 'Items', 'url' => route('items.index')],
            ['name' => 'Edit', 'url' => '']
        ];

        return view('items.edit', compact('breadcrumbs', 'item'));
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
            Storage::put("public/{$itemPath}", (string) $image->encode());

            // Hapus gambar lama
            Storage::delete("public/items/{$item->image}");

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
        Storage::delete("public/items/{$item->image}");
        Storage::delete("public/qrcodes/{$item->qr_code_path}");
        $item->delete();

        // Redirect dengan respon JSON
        return response()->json([
            'message' => 'Item deleted successfully',
            'redirect' => route('items.index')
        ], 200);
    }
}
