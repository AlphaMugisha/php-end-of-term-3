<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'chassis_number',
        'manufacture_company',
        'manufacture_year',
        'price',
        'model_name',
    ];

    /**
     * The clients linked to this vehicle (many-to-many through vehicle_client).
     */
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'vehicle_client')
            ->using(VehicleClient::class)
            ->withPivot('plate_number', 'linked_at')
            ->withTimestamps();
    }

    /**
     * The linkage pivot records that belong to this vehicle.
     */
    public function linkages()
    {
        return $this->hasMany(VehicleClient::class);
    }

    /**
     * Determine whether the vehicle is already linked to a client.
     */
    public function isLinked(): bool
    {
        return $this->linkages()->exists();
    }
}
