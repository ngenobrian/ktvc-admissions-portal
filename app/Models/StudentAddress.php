<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'po_box',
        'town_city',
        'home_county',
        'sub_county',
        'location',
        'sub_location',
        'village',
        'chief_name',
        'chief_phone',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
