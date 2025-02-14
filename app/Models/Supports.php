<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supports extends Model
{
    use HasFactory;

    protected $table = 'supports';

    protected $primaryKey = '_id';

    protected $fillable = [
        'userId',
        'subject',
        'message',
        'isreply',
        'status'
    ];
}
