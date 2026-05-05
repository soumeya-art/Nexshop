<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlateformeTemoignage extends Model
{
    protected $table = 'plateforme_temoignages';

    protected $fillable = [
        'user_id',
        'note',
        'commentaire',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'note' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
