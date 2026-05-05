<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Categorie extends Model
{
    protected $table = 'categories';

    protected $fillable = ['nom', 'description', 'icone', 'image_url'];

    public function produits()
    {
        return $this->hasMany(Produit::class, 'categorie_id');
    }

    /**
     * Image pour cartes / méga-menu : base image_url si renseignée, sinon image adaptée au nom.
     */
    public function displayImageUrl(): string
    {
        $img = trim((string) ($this->image_url ?? ''));
        if ($img !== '') {
            return str_starts_with($img, 'http') ? $img : asset($img);
        }

        $nomNorm = mb_strtolower(Str::ascii($this->nom ?? ''));

        foreach (config('category_images.patterns', []) as $row) {
            foreach ($row['keywords'] ?? [] as $kw) {
                $k = mb_strtolower(Str::ascii((string) $kw));
                if ($k !== '' && str_contains($nomNorm, $k)) {
                    return $this->resolvePublicImage($row['image']);
                }
            }
        }

        return $this->resolvePublicImage(config('category_images.fallback'));
    }

    private function resolvePublicImage(?string $src): string
    {
        $src = (string) $src;
        if ($src === '') {
            return asset('images/shopping.png');
        }
        if (str_starts_with($src, 'http')) {
            return $src;
        }

        return asset($src);
    }
}
