<?php

namespace App\Models;

use App\Models\Component;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'component_id',  // foreign key to component
        'inspection_date',  // date of inspection
        'score',  // score from 1 to 5
    ];


    public function component()
    {
        return $this->belongsTo(Component::class);
    }
}
