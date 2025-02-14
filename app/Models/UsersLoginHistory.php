<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersLoginHistory extends Model
{
    use HasFactory;

    protected $table = 'login_history';

    protected $primaryKey = '_id';

    protected $fillable = [
        'userId',
        'ip',
        'screen_name'
    ];
}
