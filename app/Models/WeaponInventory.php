<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\SaveToUpper;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeaponInventory extends Model
{
    use HasFactory;
    use UuidTrait;
    use SaveToUpper;

    protected $fillable = [
        'weapon_id',
        'weapon_number',
        'acquired_on',
        'status',
        'current_armory_id',
        'last_audited_at',
        'condition_notes',
    ];

    protected $casts = [
        'acquired_on' => 'date',
        'last_audited_at' => 'datetime',
    ];

    public function weapon()
    {
        return $this->belongsTo(Weapon::class);
    }

    public function armory()
    {
        return $this->belongsTo(Armory::class, 'current_armory_id');
    }

    public function issueLogs()
    {
        return $this->hasMany(WeaponIssueLog::class);
    }
}
