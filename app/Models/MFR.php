<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MFR extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function cmms()
    {
        return $this->hasMany(CMM::class);
    }
}
