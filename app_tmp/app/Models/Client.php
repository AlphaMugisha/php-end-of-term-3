<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'national_id',
        'telephone',
        'address',
    ];

    /**
     * The vehicles linked to this client (many-to-many through vehicle_client).
     */
    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'vehicle_client')
            ->using(VehicleClient::class)
            ->withPivot('plate_number', 'linked_at')
            ->withTimestamps();
    }

    /**
     * The linkage pivot records that belong to this client.
     */
    public function linkages()
    {
        return $this->hasMany(VehicleClient::class);
    }
}
