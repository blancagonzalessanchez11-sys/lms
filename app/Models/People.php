<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    protected $table = 'people';
    protected $primaryKey = 'person_id';

    public $timestamps = false;

    protected $fillable = [
        'first_names',
        'last_names',
        'document_number',
        'email'
    ];
}