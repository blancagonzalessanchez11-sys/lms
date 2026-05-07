<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $primaryKey = 'attendance_id';

    protected $fillable = [
        'training_id',
        'student_id',
        'date',
        'status'
    ];

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id', 'training_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'user_id');
    }

    public function scopeForDate($query, $date)
    {
        return $query->where('date', $date);
    }
}