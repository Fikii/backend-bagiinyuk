<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GetDonate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'donation_id',
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function donation(){
        return $this->hasOne(Donation::class, 'id', 'donation_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }
}
