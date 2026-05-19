<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    // 1. Allow these fields to be saved to the database
    protected $fillable = [
        'user_id',
        'admission_number',
        'status',
        'admission_source',
        'first_name',
        'middle_name',
        'surname',
        'gender',
        'dob',
        'marital_status',
        'phone_number',
        'consent_given',
        'rejection_reason',
        'kcse_grade',
        'course_level',
        'course_name'
    ];

    // 2. Define Relationships
    
    // An application belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An application has many emergency contacts (parents, guardians, sponsors)
    public function emergencyContacts()
    {
        return $this->hasMany(EmergencyContact::class);
    }

    // An application has one set of address details
    public function address()
    {
        return $this->hasOne(StudentAddress::class);
    }

    // An application has many uploaded documents
    public function documents()
    {
        return $this->hasMany(UploadedDocument::class);
    }

}
