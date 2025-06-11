<?php

// app/Models/Cours.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    protected $table = 'courses'; // Spécifie explicitement le nom de la table
    
    protected $fillable = [
        'title', 
        'description',
        'teacher_id',
        'start_date',
        'end_date',
        'is_published'
    ];
    
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}