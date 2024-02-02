<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FacilityKost extends Pivot
{
    protected $table = 'facility_kosts';
    protected $primaryKey = 'kost_id';
    protected $relatedKey = "facility_id";
    public $timestamps = true;

    public function usesTimestamps(): bool
    {
        return true;
    }

    public function kost(): BelongsTo
    {
        return $this->belongsTo(Kost::class, 'kost_id', 'id');
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'facility_id', 'id');
    }
}
