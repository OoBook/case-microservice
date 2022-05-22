<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HybridRelations;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'normalized_name', 'email','password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->normalized_name = preg_replace( '/\-/', ' ', Str::slug($model->name) );
        });

        self::deleting(function($model){
            // Bir user silindiğinde ona ait adresler de silinmelidir.
            $model->addresses()->delete();
        });
    }

    public function libraries()
    {
        return $this->belongsToMany( Library::class, "user_library");
    }

    public function addresses()
    {
        return $this->hasMany( Address::class, );
    }
}
