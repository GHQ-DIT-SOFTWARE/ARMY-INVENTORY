<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\SaveToUpper;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeaponIssueLog extends Model
{
    use HasFactory;
    use UuidTrait;
    use SaveToUpper;

    protected $fillable = [
        'weapon_inventory_id',
        'armory_id',
        'issued_by',
        'received_by',
        'issued_at',
        'expected_return_at',
        'returned_at',
        'status',
        'issue_notes',
        'return_notes',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'expected_return_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function inventory()
    {
        return $this->belongsTo(WeaponInventory::class, 'weapon_inventory_id');
    }

    public function armory()
    {
        return $this->belongsTo(Armory::class);
    }

    public function issuer()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }
}

