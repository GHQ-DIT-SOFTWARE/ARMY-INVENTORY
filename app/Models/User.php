<?php

namespace App\Models;

use App\Models\Traits\SaveToUpper;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use HasTeams;
    use Notifiable;
    use \OwenIt\Auditing\Auditable;
    use SaveToUpper;
    use TwoFactorAuthenticatable;
    use UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    public function generateAndSendOTP()
    {
        $otp = rand(100000, 999999);
        $this->otp_code = $otp;
        $this->save();
        // Send OTP via SMS
        $this->sendOTPViaSMS();
        return $otp; // Return the generated OTP
    }

    protected function sendOTPViaSMS()
    {
        // Implement SMS sending logic here using your chosen provider
        $message = "Your OTP code is: " . $this->otp_code;
        // Example with Twilio
        // \Twilio::message($this->phone_number, $message);
    }
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'current_team_id',
        'profile_photo_path',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public static function getpermissionGroups()
    {
        $permission_groups = DB::table('permissions')
            ->select('group_name as name')
            ->groupBy('group_name')
            ->get();

        return $permission_groups;
    }

    public static function getpermissionsByGroupName($group_name)
    {
        $permissions = DB::table('permissions')
            ->select('name', 'id')
            ->where('group_name', $group_name)
            ->get();

        return $permissions;
    }

    public static function roleHasPermissions($role, $permissions)
    {
        $hasPermission = true;
        foreach ($permissions as $permission) {
            if (!$role->hasPermissionTo($permission->name)) {
                $hasPermission = false;

                return $hasPermission;
            }
        }

        return $hasPermission;
    }
}
