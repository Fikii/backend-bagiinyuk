<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Orphanage as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;


class Orphanage extends Model
{
    // use HasFactory;
    // use HasApiTokens;
    // use HasProfilePhoto;
    // use Notifiable;

    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var string[]
    //  */
    // protected $fillable = [
    //     'name', 'email', 'password',
    //     'address', 'phoneNumber', 'desc'
    // ];

    // /**
    //  * The attributes that should be hidden for serialization.
    //  *
    //  * @var array
    //  */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    // /**
    //  * The attributes that should be cast.
    //  *
    //  * @var array
    //  */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    // /**
    //  * The accessors to append to the model's array form.
    //  *
    //  * @var array
    //  */
    // protected $appends = [
    //     'picturePath',
    // ];

    // public function getCreatedAtAttribute($value)
    // {
    //     return Carbon::parse($value)->timestamp;
    // }

    // public function getUpdatedAtAttribute($value){
    //     return Carbon::parse($value)->timestamp;
    // }
}
