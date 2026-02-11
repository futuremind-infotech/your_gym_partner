<?php

namespace App\Models;

use CodeIgniter\Model;

class StaffModel extends Model
{
    protected string $table = 'staffs';
    protected string $primaryKey = 'user_id';
    protected array $allowedFields = [
        'username','password','email','fullname','address','designation','gender','contact'
    ];

    protected bool $useTimestamps = false;
}
?>
