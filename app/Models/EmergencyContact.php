<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'contact_type',
        'is_alive',
        'full_name',
        'phone_number',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
