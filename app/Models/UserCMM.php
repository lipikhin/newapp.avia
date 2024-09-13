<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCMM extends Model
{
    use HasFactory;
    protected $table = 'user_c_m_m_s'; // Если название таблицы отличается от стандартного

    protected $fillable = ['user_id', 'c_m_m_s_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function c_m_m_s()
    {
        return $this->belongsTo(CMM::class);
    }
}
