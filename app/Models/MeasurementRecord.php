<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class MeasurementRecord extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'mqtt_data';
}
