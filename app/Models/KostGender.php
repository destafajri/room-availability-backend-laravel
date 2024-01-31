<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KostGender extends Model
{
    protected $tabel = 'kost_genders';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'gender_type'
    ];

    public function kosts(): HasMany
    {
        return $this->hasMany(Kost::class, 'kost_gender_id', 'id');
    }
}
