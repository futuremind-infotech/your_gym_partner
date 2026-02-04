<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipmentModel extends Model
{
    protected $table = 'equipment';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name','amount','quantity','vendor','description','address','contact','date'
    ];

    protected $useTimestamps = false;
}
?>
