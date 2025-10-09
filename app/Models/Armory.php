<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\SaveToUpper;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Armory extends Model
{
    use HasFactory;
    use UuidTrait;
    use SaveToUpper;

    protected $fillable = [
        'name',
        'code',
        'location',
        'commanding_officer',
        'contact_number',
        'email',
        'notes',
    ];

    public function weaponInventories()
    {
        return $this->hasMany(WeaponInventory::class, 'current_armory_id');
    }

    public function weaponIssues()
    {
        return $this->hasMany(WeaponIssueLog::class);
    }
}
