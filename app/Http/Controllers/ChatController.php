<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Chat;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;

class ChatController extends Controller
{

    /**
     * Mengambil semua chat.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Chat', 'url' => route('chat.index')]
        ];

        if(auth()->user()->hasRole('admin')) {
            $chats = Chat::orderBy('created_at', 'desc')->get();
        } else {
            $chats = Chat::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        }
        return view('chat.index', compact('breadcrumbs', 'chats'));
    }

    public function show($id)
    {
        $breadcrumbs = [
            ['name' => 'Chat', 'url' => route('chat.index')],
            ['name' => 'Detail', 'url' => '']
        ];
        try {
            $chat = Chat::where('id', $id)->first();
            if (!$chat) {
                abort(404);
            }

            if($chat->user_id == auth()->user()->id ) {
                $chat->update([
                    'read' => 1,
                ]);
            }
            return view('chat.show', compact('chat','breadcrumbs'));
        } catch (\Throwable $th) {
            throw $th;
            abort(404);
        }
    }

    public function create($uuid)
    {
        try {
            $item = Item::where('uuid', $uuid)->first();
            if (!$item) {
                abort(404);
            }
            return view('chat.create', compact('item'));
        } catch (\Throwable $th) {
            throw $th;
            abort(404);
        }
    }

    /**
     * Mengirimkan pesan ke pengguna berdasarkan UUID.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'uuid' => 'required|exists:items,uuid',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
    
        // Cari chat terakhir dengan UUID
        $chat = Chat::where('uuid', $request->uuid)->latest()->first();
    
        if (!$chat || $chat->time_resend <= Carbon::now()) {
            if ($request->hasFile('image')) {
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

                // Simpan gambar di direktori storage
                $chatPath = "chats/{$filename}";
                Storage::put("public/{$chatPath}", (string) $image->encode());
                $request->image = $filename;
            }

            $this->createChat($request);
            return response()->json(['message' => 'Message sent successfully'], 200);
        } else {
            return response()->json(['message' => 'You can send a message every 5 minutes'], 400);
        }
    }
    
    /**
     * Membuat chat baru.
     *
     * @param Request $request
     */
    private function createChat(Request $request)
    {
        Chat::create([
            'user_id' => $request->user_id,
            'uuid' => $request->uuid,
            'subject' => $request->subject,
            'message' => $request->message,
            'image' => $request->image,
            'time_resend' => Carbon::now()->addMinutes(1),
        ]);
    }

    /*
     * Hapus Chat hanya untuk admin
     */
    public function destroy($id)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        Chat::where('id', $id)->delete();
        return redirect()->route('chat.index');
    }
}
