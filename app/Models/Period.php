<?php

namespace App\Models;

use Hidehalo\Nanoid\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Period extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'public_id',
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'public_id' => 'string',
        'name' => 'string',
    ];

    public function thresholds()
    {
        return $this->hasMany(Threshold::class);
    }

    /**
     * The Period model.
     *
     * This model represents a period in the application.
     * It generates a unique public ID for each new period created.
     */
    protected static function boot()
    {
        parent::boot();

        $nanoid = new Client();

        Period::creating(function($model) use ($nanoid) {
            $model->public_id = $nanoid->formattedId($alphabet = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', $size = 15);
        });
    }
}
