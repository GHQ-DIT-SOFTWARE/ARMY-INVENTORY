<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Personnel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $guarded = [];
    public function rank(){
        return $this->belongsTo(rank::class,'rank_name','id');
    }
    public function getFullNameAttribute()
    {
        return "{$this->surname} {$this->othernames}";
    }
}
