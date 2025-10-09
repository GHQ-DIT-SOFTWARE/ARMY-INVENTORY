<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\SaveToUpper;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorPool extends Model
{
    use HasFactory;
    use UuidTrait;
    use SaveToUpper;

    protected $fillable = [
        'name',
        'code',
        'location',
        'fleet_manager',
        'contact_number',
        'email',
        'notes',
    ];

    public function vehicleInventories()
    {
        return $this->hasMany(VehicleInventory::class, 'current_motor_pool_id');
    }

    public function vehicleDeployments()
    {
        return $this->hasMany(VehicleDeployment::class);
    }
}
