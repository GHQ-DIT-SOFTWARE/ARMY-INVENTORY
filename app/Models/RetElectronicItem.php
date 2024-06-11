<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\User;
class RetElectronicItem extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $guarded = [];
    public function getFullNameAttribute()
    {
        return "{$this->surname} {$this->othernames}";
    }
    public function issueduser(){
        return $this->belongsTo(User::class,'created_by','id');
    }

}
