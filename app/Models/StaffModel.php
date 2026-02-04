<?php

namespace App\Models;

use CodeIgniter\Model;

class StaffModel extends Model
{
    protected $table = 'staffs';
    protected $primaryKey = 'user_id';
    protected $allowedFields = [
        'username','password','email','fullname','address','designation','gender','contact'
    ];

    protected $useTimestamps = false;
}
?>
