<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\SaveToUpper;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralItemIssuing extends Model
{
    use HasFactory;
    use UuidTrait;
    use SaveToUpper;

    protected $fillable = [
        'svcnumber',
        'surname',
        'othernames',
        'gender',
        'mobile',
        'rank_name',
        'email',
        'body_no',
        'product_name',
        'item_location',
        'category_name',
        'status',
        'created_by',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
