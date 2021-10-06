<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GalleryAuto extends Model
{
    use HasFactory;

    protected $table = 'auto_images';

    public $image_path_array = [];

    protected $fillable = ['auto_id', 'image_path_1', 'image_path_2', 'image_path_3'];

    public function saveImage($file)
    {
        if (! $file) { return; }

        $ext = $file->extension();
        $filename = Str::random(6) . '.' . $ext;

        return $file->storeAs('images', $filename, 'uploads');
    }
}
