<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\SaveToUpper;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    use HasFactory;
    use UuidTrait;
    use SaveToUpper;

    protected $fillable = [
        'weapon_category_id',
        'name',
        'variant',
        'image_path',
        'caliber',
        'manufacturer',
        'country_of_origin',
        'barrel_length_mm',
        'overall_length_mm',
        'weight_kg',
        'muzzle_velocity_mps',
        'rate_of_fire_rpm',
        'effective_range_m',
        'maximum_range_m',
        'configuration',
        'sight_system',
        'ammunition_types',
        'notes',
    ];

    protected $casts = [
        'barrel_length_mm' => 'float',
        'overall_length_mm' => 'float',
        'weight_kg' => 'float',
        'muzzle_velocity_mps' => 'float',
        'rate_of_fire_rpm' => 'float',
        'effective_range_m' => 'float',
        'maximum_range_m' => 'float',
    ];

    public function category()
    {
        return $this->belongsTo(WeaponCategory::class, 'weapon_category_id');
    }

    public function inventory()
    {
        return $this->hasMany(WeaponInventory::class);
    }
}
