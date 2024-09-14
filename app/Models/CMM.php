<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMM extends Model
{
    use HasFactory;
    protected $fillable = [
        'number',
        'title',
        'img',
        'revision_date',
        'active',
        'units_pn',
        'units_tr',
        'lib',
        'aircrafts_id',
        'mfrs_id',
        'scopes_id',
    ];
    // Отношение с моделью AirCraft
    public function airCraft()
    {
        return $this->belongsTo(AirCraft::class);
    }

    // Отношение с моделью MFR
    public function mfr()
    {
        return $this->belongsTo(MFR::class);
    }

    // Отношение с моделью Scope
    public function scope()
    {
        return $this->belongsTo(Scope::class);
    }
    public function training()
    {
        return $this->hasMany(Training::class);
    }

}
