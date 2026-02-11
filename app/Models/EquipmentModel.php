<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipmentModel extends Model
{
    protected string $table = 'equipment';
    protected string $primaryKey = 'id';
    protected array $allowedFields = [
        'name','amount','quantity','vendor','description','address','contact','date'
    ];

    protected bool $useTimestamps = false;
}
?>
