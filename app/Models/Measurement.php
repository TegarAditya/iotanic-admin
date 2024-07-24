<?php

namespace App\Models;

use Hidehalo\Nanoid\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Measurement extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'plant_variety_id',
        'period_id',
        'land_id',
        'public_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'plant_variety_id' => 'integer',
        'land_id' => 'integer',
        'public_id' => 'string',
    ];

    /**
     * Get the plant variety associated with the measurement.
     */
    public function plantVariety()
    {
        return $this->belongsTo(PlantVariety::class);
    }

    /**
     * Get the land associated with the measurement.
     */
    public function land()
    {
        return $this->belongsTo(Land::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    protected static function boot()
    {
        parent::boot();

        $nanoid = new Client();

        Measurement::creating(function($model) use ($nanoid) {
            $model->public_id = $nanoid->formattedId($alphabet = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', $size = 15);
        });
    }
}
