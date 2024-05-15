<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'device_name',
        'serial_number',
        'return_status',
        'return_date',
        'borrow_id'
    ];

    // Function สำหรับสร้าง Id รองรับเพื่อ Join Database
    public function borrow() {
        return $this->belongsTo(Borrow::class, 'borrow_id', 'id');
    }
}
