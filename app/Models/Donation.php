<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;


class Donation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'type', 'name', 'desc', 'status',
        'image',
        'orphanage_id', 
    ];

    protected $appends = [
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function orphanage(){
        return $this->hasOne(User::class, 'id', 'orphanage_id');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    public function getUpdatedAtAttribute($date){
        return Carbon::parse($date)->format('d/m/Y');
    }

    // public function toArray()
    // {
    //     $toArray = parent::toArray();
    //     $toArray['image'] = $this->image;
    //     return $toArray;
    // }

    // public function getImageAttribute(){
    //     return url('') . Storage::url($this->attributes['image']);
    // }
}
