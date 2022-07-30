<?php

namespace App\Models\Admin\User;

use App\Models\Admin\ACL\Permission;
use App\Models\Content\Post;
use App\Models\Ticket\Ticket;
use App\Models\Admin\ACL\Role;
use App\Models\Market\Payment;
use App\Models\Content\Comment;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Ticket\TicketAdmin;
use App\Permissions\HasPermissionsTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasPermissionsTrait;

    protected $searchable = [
        'first_name',
        'last_name',
        'email',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    public function role()
    {
       return $this->belongsTo(Role::class ,'role_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'author_id');
    }

    public function getShowAvatarNameAttribute()
    {
        if ($this->first_name !== null && $this->last_name !== null) {
           return "{$this->first_name} {$this->last_name}";
        } elseif ($this->mobile_verified_at !== null) {
           return $this->mobile;
        }elseif($this->email_verified_at !== null) {
            return $this->email;
        }
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'status',
        'user_type',
        'activation',
        'profile_photo_path',
        'password',
        'national_code',
        'mobile_verified_at',
        'email_verified_at',
        'role_id'
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
}
