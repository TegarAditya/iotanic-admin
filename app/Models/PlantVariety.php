<?php

namespace App\Models;

use Hidehalo\Nanoid\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlantVariety extends Model
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
        'name',
        'description',
        'image',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'plant_id' => 'integer',
        'public_id' => 'string',
        'name' => 'string',
        'description' => 'string',
    ];

    /**
     * Get the plant that owns the variety.
     */
    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }

    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }

    public function thresholds()
    {
        return $this->hasMany(Threshold::class);
    }

    protected static function boot()
    {
        parent::boot();

        $nanoid = new Client();

        PlantVariety::creating(function($model) use ($nanoid) {
            $model->public_id = $nanoid->formattedId($alphabet = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', $size = 15);
        });
    }
}
