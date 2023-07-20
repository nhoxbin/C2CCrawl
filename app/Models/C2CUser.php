<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class C2CUser extends Model
{
    use HasFactory;

    public $table = 'c2c_users';

    protected $fillable = ['pw', 'fireBaseDeviceId'];

    function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
