<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description'
    ];

    /**
     * Get Ad by given id
     * @param integer $id
     * @return Advertisement
     */
    public static function getAd(int $id): Advertisement
    {
        return Advertisement::query()->where('id', $id)->firstOrFail();
    }

    /*
    * Relations
    */

    /**
     * Get the user that owns the Advertisement
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
