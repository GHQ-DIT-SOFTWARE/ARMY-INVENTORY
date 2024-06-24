<?php
declare (strict_types = 1);
namespace App\Models;

use App\Models\Traits\SaveToUpper;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AggregatedIssueItem extends Model implements Auditable
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
        'invoice_no',
        'items',
        'status',
    ];

    public function setItemsAttribute($value)
    {
        $this->attributes['items'] = json_encode($value);
    }

    // Accessor to decode items from JSON when getting
    public function getItemsAttribute($value)
    {
        return json_decode($value, true);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'items' => 'array',
    ];
}
