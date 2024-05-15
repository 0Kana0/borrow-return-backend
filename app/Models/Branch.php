<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'branch_name'
    ];

    // Function สำหรับส่ง Id ไปยัง Database ที่ต้องการจะ Join
    public function borrows() {
        return $this->hasMany(Borrow::class, 'branch_id', 'id');
    }
}
