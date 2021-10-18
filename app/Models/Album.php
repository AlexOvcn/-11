<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Album extends Model
{
    use HasFactory;

    protected $table = 'albums';

    protected $fillable = ['album_name', 'artist_id', 'genre_id', 'release_date', 'label', 'country', 'album_cover', 'confirmed'];

    public function artist()
	{
		return $this->belongsTo(Artist::class, 'artist_id', 'id', 'artists');
	}

    public function genre()
	{
		return $this->belongsTo(Genre::class, 'genre_id', 'id', 'genres');
	}

    public function songs()
	{
		return $this->belongsToMany(Song::class, 'album_song', 'album_id', 'song_id');
	}

    public function comments()
    {
        return $this->hasMany(Comment::class, 'album_id', 'id', 'comments');
    }

    // удаляем обложку альбома (картинку) с диска
    public function removeImage()
    {
        if ($this->album_cover) {
            Storage::disk('uploads')->delete($this->album_cover);
            $this->album_cover = null;
        }
    }
}
