<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected string $table = 'members';
    protected string $primaryKey = 'user_id';
    protected array $allowedFields = [
        'fullname','username','password','gender','dor','services','amount','paid_date','p_year','plan','address','contact','status','attendance_count','ini_weight','curr_weight','ini_bodytype','curr_bodytype','progress_date','reminder','qr_code_path'
    ];

    protected bool $useTimestamps = false;
}
