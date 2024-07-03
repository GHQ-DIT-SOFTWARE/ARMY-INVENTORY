<?php
declare (strict_types = 1);
namespace App\Models;

use App\Models\Traits\SaveToUpper;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Personnel extends Model implements Auditable
{
    use HasFactory;
    use UuidTrait;
    use SaveToUpper;
    use \OwenIt\Auditing\Auditable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rank_id',
        'arm_of_service',
        'svcnumber',
        'surname',
        'othernames',
        'first_name',
        'service_category',
        'initial',
        'mobile_no',
        'email',
        'gender',
        'blood_group',
        'height',
        'unit_id',
        'virtual_mark',
        'personnel_image',
        'created_by',
    ];
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function rank()
    {
        return $this->belongsTo(rank::class, 'rank_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'arm_of_service', 'id');
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

    ];
}
