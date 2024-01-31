<?php

namespace App\Models;

use App\Models\Scopes\IsActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kost extends Model
{
    protected $table = 'kosts';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'kost_name',
        'owner_id',
        'kost_gender_id',
        'area_id',
        'address',
        'description',
        'price',
        'room_total',
        'room_available',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'id');
    }


    public function kostGender(): BelongsTo
    {
        return $this->belongsTo(KostGender::class, 'kost_gender_id', 'id');
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, "facility_kosts", "kost_id", "facility_id")
            ->using(FacilityKost::class);
    }

    protected static function booted(): void
    {
        parent::booted();
        self::addGlobalScope(new IsActiveScope());
    }
}
