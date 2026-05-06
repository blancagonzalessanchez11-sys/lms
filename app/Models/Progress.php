<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $primaryKey = 'progress_id';

    public $timestamps = false;

    protected $fillable = [
        'enrollment_id',
        'content_id',
        'percentage',
        'activity_date',
        'status'
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class, 'enrollment_id', 'enrollment_id');
    }
}