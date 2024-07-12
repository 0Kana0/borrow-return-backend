<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'borrow_number_id',
        'date',
        'employee_id',
        'employee_name',
        'employee_phone',
        'employee_rank',
        'employee_dept',
        'branch_name'
    ];
}
