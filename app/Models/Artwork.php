<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', // Adicione este campo para representar a associação com o usuário
        'title',
        'description',
        'image_path', // Substitua pelo campo real que armazenará o caminho da imagem
    ];

    /**
     * Get the user that owns the artwork.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
