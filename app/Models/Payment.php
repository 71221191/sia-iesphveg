<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
    'person_id', 'concept', 'amount', 'operation_number', 'voucher_image_path', 'status'
    ];
}
