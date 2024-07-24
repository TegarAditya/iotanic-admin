<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Threshold extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'public_id',
        'plant_variety_id',
        'period_id',
        'name',
        'natrium_min',
        'natrium_max',
        'kalium_min',
        'kalium_max',
        'ph_min',
        'ph_max',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'public_id' => 'string',
        'plant_variety_id' => 'integer',
        'period_id' => 'integer',
        'name' => 'string',
        'natrium_min' => 'float',
        'natrium_max' => 'float',
        'kalium_min' => 'float',
        'kalium_max' => 'float',
        'ph_min' => 'float',
        'ph_max' => 'float',
    ];

    /**
     * Get the plant variety associated with the treshold.
     */
    public function plantVariety()
    {
        return $this->belongsTo(PlantVariety::class);
    }

    /**
     * Get the period associated with the treshold.
     */
    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
