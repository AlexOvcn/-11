<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Auto extends Model
{
    use HasFactory;

    protected $table = 'auto';

    protected $fillable = ['name', 'image_path', 'description', 'price'];

    static function saveImage($file)
    {
        if (! $file) { return; }

        $ext = $file->extension();
        $filename = Str::random(6) . '.' . $ext;

        return $file->storeAs('images', $filename, 'uploads');
    }
}
