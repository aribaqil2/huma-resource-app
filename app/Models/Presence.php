<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\softDeletes;

class Presence extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'employee_id',
        'check_in',
        'check_out',
        'date',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
