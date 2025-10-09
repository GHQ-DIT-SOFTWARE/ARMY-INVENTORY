<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\SaveToUpper;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleInventory extends Model
{
    use HasFactory;
    use UuidTrait;
    use SaveToUpper;

    protected $fillable = [
        'vehicle_id',
        'asset_number',
        'acquired_on',
        'status',
        'current_motor_pool_id',
        'last_serviced_at',
        'condition_notes',
    ];

    protected $casts = [
        'acquired_on' => 'date',
        'last_serviced_at' => 'datetime',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function motorPool()
    {
        return $this->belongsTo(MotorPool::class, 'current_motor_pool_id');
    }

    public function deployments()
    {
        return $this->hasMany(VehicleDeployment::class, 'vehicle_inventory_id');
    }
}
