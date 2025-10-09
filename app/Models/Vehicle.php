<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\SaveToUpper;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    use UuidTrait;
    use SaveToUpper;

    protected $fillable = [
        'vehicle_category_id',
        'name',
        'variant',
        'image_path',
        'manufacturer',
        'country_of_origin',
        'engine_type',
        'engine_power_hp',
        'max_speed_kph',
        'range_km',
        'fuel_capacity_l',
        'weight_tons',
        'crew_capacity',
        'passenger_capacity',
        'armament',
        'armor',
        'communication_systems',
        'notes',
    ];

    protected $casts = [
        'engine_power_hp' => 'float',
        'max_speed_kph' => 'float',
        'range_km' => 'float',
        'fuel_capacity_l' => 'float',
        'weight_tons' => 'float',
        'crew_capacity' => 'integer',
        'passenger_capacity' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(VehicleCategory::class, 'vehicle_category_id');
    }

    public function inventory()
    {
        return $this->hasMany(VehicleInventory::class);
    }
}
