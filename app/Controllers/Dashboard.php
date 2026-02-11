<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Database;

class Dashboard extends BaseController
{
    public function index()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $db = Database::connect();
        
        // Fetch all required data
        $data['result'] = $db->query("SELECT services, count(*) as number FROM members GROUP BY services")->getResultArray() ?? [];
        $data['result3'] = $db->query("SELECT gender, count(*) as enumber FROM members GROUP BY gender")->getResultArray() ?? [];
        $data['result5'] = $db->query("SELECT designation, count(*) as snumber FROM staffs GROUP BY designation")->getResultArray() ?? [];
        $data['earningsResult'] = $db->query("SELECT SUM(amount) as numberone FROM members")->getRowArray() ?? ['numberone' => 0];
        $data['expensesResult'] = $db->query("SELECT SUM(amount) as numbert FROM equipment")->getRowArray() ?? ['numbert' => 0];
        $data['announcements'] = $db->query("SELECT * FROM announcements ORDER BY date DESC LIMIT 5")->getResultArray() ?? [];
        $data['todos'] = $db->query("SELECT * FROM todo LIMIT 5")->getResultArray() ?? [];

        return view('admin/index', $data);
    }
}
