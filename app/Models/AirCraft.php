<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirCraft extends Model
{
    use HasFactory;
    protected $fillable = ['type'];

    public function cmms()
    {
        return $this->hasMany(CMM::class);
    }
}
