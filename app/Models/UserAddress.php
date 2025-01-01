<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'user_addresses';
    protected $fillable = [
        'name',
        'phone',
        'prefecture',
        'city',
        'address',
        'etc_address',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
