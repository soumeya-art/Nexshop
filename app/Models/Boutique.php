<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Boutique extends Model
{
    protected $fillable = [
        'user_id',
        'nom',
        'description',
        'categorie',
        'logo',
        'banniere',
        'ville',
        'telephone_boutique',
        'instagram_url',
        'snapchat_url',
        'tiktok_url',
        'youtube_url',
        'est_active',
    ];

    protected function casts(): array
    {
        return [
            'est_active' => 'boolean',
        ];
    }

    public function vendeur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function logoUrl(): ?string
    {
        return self::publicUrlForPath($this->logo);
    }

    public function banniereUrl(): ?string
    {
        return self::publicUrlForPath($this->banniere);
    }

    /** Chemin sous public/, ex. images/boutiques/logos/uuid.webp */
    public static function storePublicImage(UploadedFile $file, string $subdir): string
    {
        $relativeDir = 'images/boutiques/'.$subdir;
        $absoluteDir = public_path($relativeDir);
        if (! is_dir($absoluteDir)) {
            mkdir($absoluteDir, 0755, true);
        }
        $extension = strtolower((string) ($file->extension() ?: pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION) ?: 'jpg'));
        $basename = Str::uuid()->toString().'.'.$extension;
        $file->move($absoluteDir, $basename);

        return $relativeDir.'/'.$basename;
    }

    public static function deleteStoredPath(?string $path): void
    {
        if (empty($path)) {
            return;
        }

        if (str_starts_with($path, 'images/')) {
            $full = public_path($path);
            if (is_file($full)) {
                unlink($full);
            }

            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private static function publicUrlForPath(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        return Storage::disk('public')->url($path);
    }
}
