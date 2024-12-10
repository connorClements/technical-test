<?php

namespace App\Models;

use App\Models\Turbine;
use App\Models\Inspection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Component extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Blade, Nacelle, Hub, Tower
        'turbine_id', // foreign key to turbine
    ];

    /**
     * component belongs to turbine
     */
    public function turbine()
    {
        return $this->belongsTo(Turbine::class);
    }

    /**
     * component can have many inspections
     */
    public function inspections()
    {
        return $this->hasMany(Inspection::class);
    }
}
