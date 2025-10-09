<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\SaveToUpper;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleDeployment extends Model
{
    use HasFactory;
    use UuidTrait;
    use SaveToUpper;

    protected $fillable = [
        'vehicle_inventory_id',
        'motor_pool_id',
        'issued_by',
        'operator_id',
        'deployed_at',
        'expected_return_at',
        'returned_at',
        'status',
        'deployment_notes',
        'return_notes',
    ];

    protected $casts = [
        'deployed_at' => 'datetime',
        'expected_return_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function inventory()
    {
        return $this->belongsTo(VehicleInventory::class, 'vehicle_inventory_id');
    }

    public function motorPool()
    {
        return $this->belongsTo(MotorPool::class);
    }

    public function issuer()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function operator()
    {
        return $this->belongsTo(Personnel::class, 'operator_id');
    }
}

