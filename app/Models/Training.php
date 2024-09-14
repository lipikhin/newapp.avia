<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'cmms_id',
        'date_training', 'form_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cmms()
    {
        return $this->belongsTo(CMM::class);
    }
}
