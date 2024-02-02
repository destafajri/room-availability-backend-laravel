<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Facility extends Model
{
    protected $table = 'facilities';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'facility_name'
    ];

    public function kosts(): BelongsToMany
    {
        return $this->belongsToMany(Kost::class, "facility_kosts", "facility_id", "kost_id")
            ->using(FacilityKost::class);
    }
}
