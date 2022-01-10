<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAccount extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'admin_email',
        'admin_password',
        'admin_name',
        'admin_phone',

    ];
    protected $primaryKey = 'admin_id';
    protected $table = 'tbl_admin';
}