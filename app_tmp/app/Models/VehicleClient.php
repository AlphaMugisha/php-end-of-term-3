<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class VehicleClient extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehicle_client';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vehicle_id',
        'client_id',
        'plate_number',
        'linked_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'linked_at' => 'datetime',
    ];

    /**
     * The vehicle that owns this linkage.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * The client that owns this linkage.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Generate a unique plate number in the format "RAB 123 A".
     */
    public static function generatePlateNumber(): string
    {
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        do {
            $prefix = 'R'
                . $letters[random_int(0, 25)]
                . $letters[random_int(0, 25)];
            $digits = str_pad((string) random_int(0, 999), 3, '0', STR_PAD_LEFT);
            $suffix = $letters[random_int(0, 25)];

            $plate = sprintf('%s %s %s', $prefix, $digits, $suffix);
        } while (static::where('plate_number', $plate)->exists());

        return $plate;
    }
}
