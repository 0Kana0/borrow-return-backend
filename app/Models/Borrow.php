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
        'branch_id'
    ];

    // Function สำหรับสร้าง Id รองรับเพื่อ Join Database
    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
    
    // Function สำหรับส่ง Id ไปยัง Database ที่ต้องการจะ Join
    public function borrow_devices() {
        return $this->hasMany(BorrowDevice::class, 'borrow_id', 'id');
    }
}
