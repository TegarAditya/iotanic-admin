<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlantImage extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'plant_id',
        'public_id',
        'url',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'plant_id' => 'integer',
        'public_id' => 'string',
        'url' => 'string',
    ];

    /**
     * Get the plant that owns the image.
     */
    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }
}
