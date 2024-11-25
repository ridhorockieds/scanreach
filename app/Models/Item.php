<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $primaryKey = 'uuid'; // Menetapkan uuid sebagai kunci utama
    public $incrementing = false;   // Karena UUID bukan auto-increment
    // protected $keyType = 'string';

    protected $table = 'items';

    // Kolom yang bisa diisi
    protected $fillable = [
        'uuid',
        'user_id',
        'name',
        'description',
        'image',
        'qr_code_path',
    ];

    /**
     * Event model untuk menghasilkan UUID secara otomatis saat membuat item baru.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            if (empty($item->uuid)) {
                $item->uuid = Str::uuid()->toString();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
