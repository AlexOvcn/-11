<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = ['user_id', 'album_id', 'confirmed', 'comment'];

    public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id', 'users');
	}
}
