<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\PasswordHelper;

class Admin extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $db = \Config\Database::connect();
        
        // Fetch all required data for dashboard
        $data['result'] = $db->query("SELECT services, count(*) as number FROM members GROUP BY services")->getResultArray() ?? [];
        $data['result3'] = $db->query("SELECT gender, count(*) as enumber FROM members GROUP BY gender")->getResultArray() ?? [];
        $data['result5'] = $db->query("SELECT designation, count(*) as snumber FROM staffs GROUP BY designation")->getResultArray() ?? [];
        $data['earningsResult'] = $db->query("SELECT SUM(amount) as numberone FROM members")->getRowArray() ?? ['numberone' => 0];
        $data['expensesResult'] = $db->query("SELECT SUM(amount) as numbert FROM equipment")->getRowArray() ?? ['numbert' => 0];
        $data['announcements'] = $db->query("SELECT * FROM announcements ORDER BY date DESC LIMIT 5")->getResultArray() ?? [];
        $data['todos'] = $db->query("SELECT * FROM todo LIMIT 5")->getResultArray() ?? [];
        $data['page'] = 'dashboard';

        return view('admin/index', $data);
    }

    // MEMBERS SECTION - FULL CRUD
    public function members()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $db = \Config\Database::connect();
        $data['members'] = $db->table('members')->orderBy('user_id', 'DESC')->get()->getResultArray();
        $data['page'] = 'members';

        return view('admin/members', $data);
    }

    public function memberEntry()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('admin/member-entry', ['page' => 'members-entry']);
    }

    // ✅ FIXED addMember - CLEAN SYNTAX + VALIDATION
    public function addMember()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        if ($this->request->is('post')) {
            $rules = [
                'fullname' => 'required|min_length[2]',
                'username' => 'required|min_length[3]|is_unique[members.username]',
                'password' => 'required|min_length[6]',
                'gender' => 'required',
                'services' => 'required',
                'amount' => 'required|numeric|greater_than[0]',
                'plan' => 'required|integer|greater_than[0]',
            ];

            if (!$this->validate($rules)) {
                return view('admin/member-entry', [
                    'page' => 'members-entry',
                    'validation' => $this->validator,
                ]);
            }

            // Validation passed - proceed with insertion
            $amount = (float) $this->request->getPost('amount');
            $plan = (int) $this->request->getPost('plan');
            $dor = $this->request->getPost('dor') ?? date('Y-m-d');

            $data = [
                'fullname' => $this->request->getPost('fullname'),
                'username' => $this->request->getPost('username'),
                'password' => PasswordHelper::legacyHash($this->request->getPost('password')),
                'dor' => $dor,
                'gender' => $this->request->getPost('gender'),
                'services' => $this->request->getPost('services'),
                'amount' => $amount * $plan,
                'p_year' => date('Y'),
                'paid_date' => date('Y-m-d'),
                'plan' => $plan,
                'email' => $this->request->getPost('email') ?? '',
                'address' => $this->request->getPost('address') ?? '',
                'contact' => $this->request->getPost('contact') ?? '',
                'attendance_count' => 0,
                'ini_bodytype' => $this->request->getPost('ini_bodytype') ?? '',
                'curr_bodytype' => $this->request->getPost('curr_bodytype') ?? '',
                'progress_date' => date('Y-m-d'),
                'status' => 'Active',
            ];

            try {
                $db = \Config\Database::connect();
                $db->table('members')->insert($data);
                session()->setFlashdata('success', '✅ New member added successfully!');
                return redirect()->to('admin/members');
            } catch (\Exception $e) {
                session()->setFlashdata('error', '❌ Error adding member: ' . $e->getMessage());
                return view('admin/member-entry', ['page' => 'members-entry']);
            }
        }

        return view('admin/member-entry', ['page' => 'members-entry']);
    }

    // ✅ FIXED editMember - LOADS FORM DATA
    public function editMember()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $member_id = $this->request->getGet('id');

        if (empty($member_id) || !is_numeric($member_id)) {
            session()->setFlashdata('error', 'Invalid member ID!');
            return redirect()->to('admin/members');
        }

        $db = \Config\Database::connect();
        $member = $db->table('members')
            ->where('user_id', (int) $member_id)
            ->limit(1)
            ->get()
            ->getRowArray();

        $data = [
            'page' => 'members-update',
            'member' => $member,
        ];

        return view('admin/edit-member', $data);
    }

    // ✅ FIXED addMemberReq - INSERT NEW MEMBER
    public function addMemberReq()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        if ($this->request->is('post')) {
            $amount = (float) $this->request->getPost('amount');
            $plan = (int) $this->request->getPost('plan');
            $dor = $this->request->getPost('dor') ?? date('Y-m-d');

            $data = [
                'fullname' => $this->request->getPost('fullname'),
                'username' => $this->request->getPost('username'),
                'password' => PasswordHelper::legacyHash($this->request->getPost('password')),
                'dor' => $dor,
                'gender' => $this->request->getPost('gender'),
                'services' => $this->request->getPost('services'),
                'amount' => $amount * $plan,
                'p_year' => date('Y'),
                'paid_date' => date('Y-m-d'),
                'plan' => $plan,
                'address' => $this->request->getPost('address') ?? '',
                'contact' => $this->request->getPost('contact') ?? '',
                'attendance_count' => 0,
                'ini_bodytype' => $this->request->getPost('ini_bodytype') ?? '',
                'curr_bodytype' => $this->request->getPost('curr_bodytype') ?? '',
                'progress_date' => date('Y-m-d'),
                'status' => 'Active',
            ];

            $db = \Config\Database::connect();
            $db->table('members')->insert($data);

            if ($db->affectedRows() > 0) {
                session()->setFlashdata('success', '✅ New member added successfully!');
            } else {
                session()->setFlashdata('error', '❌ Error adding member!');
            }

            return redirect()->to('admin/members');
        }

        return view('admin/member-entry', ['page' => 'members-entry']);
    }

    // ✅ FIXED editMemberReq - UPDATE MEMBER (SINGLE COPY)
    public function editMemberReq()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        if ($this->request->is('post')) {
            $user_id = $this->request->getPost('user_id');

            if (!$user_id) {
                session()->setFlashdata('error', '❌ Invalid member ID!');
                return redirect()->to('admin/members');
            }

            $rules = [
                'fullname' => 'required|min_length[2]',
                'username' => 'required|min_length[3]',
                'gender' => 'required',
                'amount' => 'required|numeric|greater_than[0]',
                'plan' => 'required|integer|greater_than[0]',
            ];

            if (!$this->validate($rules)) {
                $db = \Config\Database::connect();
                $member = $db->table('members')->where('user_id', $user_id)->get()->getRowArray();
                return view('admin/edit-member', [
                    'member' => $member,
                    'member_id' => $user_id,
                    'validation' => $this->validator,
                ]);
            }

            $data = [
                'fullname' => $this->request->getPost('fullname'),
                'username' => $this->request->getPost('username'),
                'gender' => $this->request->getPost('gender'),
                'email' => $this->request->getPost('email') ?? '',
                'contact' => $this->request->getPost('contact') ?? '',
                'address' => $this->request->getPost('address') ?? '',
                'amount' => $this->request->getPost('amount'),
                'services' => $this->request->getPost('services'),
                'plan' => $this->request->getPost('plan'),
            ];

            try {
                $db = \Config\Database::connect();
                $db->table('members')->where('user_id', $user_id)->update($data);

                if ($db->affectedRows() > 0) {
                    session()->setFlashdata('success', '✅ Member updated successfully!');
                } else {
                    session()->setFlashdata('error', '⚠️ No changes made!');
                }
                return redirect()->to('admin/members');
            } catch (\Exception $e) {
                session()->setFlashdata('error', '❌ Error updating member: ' . $e->getMessage());
                return redirect()->back();
            }
        }

        return view('admin/edit-member', ['page' => 'members-update']);
    }

    public function removeMember()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        $id = $this->request->getGet('id') ?? 0;
        if ($id) {
            $db = \Config\Database::connect();
            $db->query('DELETE FROM members WHERE user_id = ?', [$id]);
            session()->setFlashdata('success', 'Member deleted!');
        }
        return redirect()->to('admin/members');
    }

    public function updateProgress()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        if ($this->request->is('post')) {
            $member_id = $this->request->getPost('id');
            $ini_weight = (float) ($this->request->getPost('ini_weight') ?? 0);
            $curr_weight = (float) ($this->request->getPost('curr_weight') ?? 0);
            $ini_bodytype = $this->request->getPost('ini_bodytype') ?? '';
            $curr_bodytype = $this->request->getPost('curr_bodytype') ?? '';

            if (!$member_id) {
                session()->setFlashdata('error', '❌ Invalid member ID!');
                return redirect()->back();
            }

            try {
                $db = \Config\Database::connect();
                $db->table('members')->where('user_id', $member_id)->update([
                    'ini_weight' => $ini_weight,
                    'curr_weight' => $curr_weight,
                    'ini_bodytype' => $ini_bodytype,
                    'curr_bodytype' => $curr_bodytype,
                    'progress_date' => date('Y-m-d'),
                ]);

                session()->setFlashdata('success', '✅ Progress updated successfully!');
                return redirect()->to('admin/customer-progress');
            } catch (\Exception $e) {
                session()->setFlashdata('error', '❌ Error updating progress: ' . $e->getMessage());
                return redirect()->back();
            }
        }

        return redirect()->to('admin/customer-progress');
    }

    public function deleteMember()
    {
        return view('admin/actions/delete-member', ['page' => 'members-remove']);
    }

    public function memberStatus()
    {
        return view('admin/member-status', ['page' => 'member-status']);
    }

    // ✅ EQUIPMENT SECTION - FULL CRUD
    public function equipment()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        $db = \Config\Database::connect();
        $data['equipment'] = $db->table('equipment')->orderBy('id', 'DESC')->get()->getResultArray();
        $data['page'] = 'list-equip';
        
        return view('admin/equipment', $data);
    }

    public function equipmentEntry()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('admin/equipment-entry', ['page' => 'add-equip']);
    }

    // ✅ ADD EQUIPMENT - INSERT
    public function addEquipment()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        if (strtolower($this->request->getMethod()) === 'post') {
            $rules = [
                'ename' => 'required|min_length[2]',
                'description' => 'required|min_length[3]',
                'quantity' => 'required|numeric|greater_than[0]',
                'amount' => 'required|numeric|greater_than[0]',
                'vendor' => 'required|min_length[2]',
                'date' => 'required'
            ];
            
            if (! $this->validate($rules)) {
                return view('admin/equipment-entry', [
                    'page' => 'add-equip',
                    'validation' => $this->validator
                ]);
            }
            
            $quantity = intval($this->request->getPost('quantity'));
            $amount = floatval($this->request->getPost('amount'));
            $totalamount = $amount * $quantity;
            
            $data = [
                'name' => $this->request->getPost('ename'),
                'description' => $this->request->getPost('description'),
                'amount' => $totalamount,
                'quantity' => $quantity,
                'vendor' => $this->request->getPost('vendor'),
                'address' => $this->request->getPost('address') ?? '',
                'contact' => $this->request->getPost('contact') ?? '',
                'date' => $this->request->getPost('date')
            ];
            
            try {
                $db = \Config\Database::connect();
                $db->table('equipment')->insert($data);
                session()->setFlashdata('success', '✅ Equipment added successfully!');
                return redirect()->to('admin/equipment');
            } catch (\Exception $e) {
                session()->setFlashdata('error', '❌ Error adding equipment: ' . $e->getMessage());
                return view('admin/equipment-entry', ['page' => 'add-equip']);
            }
        }
        
        return view('admin/equipment-entry', ['page' => 'add-equip']);
    }

    public function editEquipment()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        $equip_id = $this->request->getGet('id');
        $data = ['page' => 'update-equip'];
        
        if ($equip_id) {
            $db = \Config\Database::connect();
            $equip = $db->table('equipment')
                        ->where('id', $equip_id)
                        ->get()
                        ->getRowArray();
            
            if ($equip) {
                $data['equipment'] = $equip;
                $data['equip_id'] = $equip_id;
            } else {
                session()->setFlashdata('error', '❌ Equipment not found!');
                return redirect()->to('admin/equipment');
            }
        } else {
            session()->setFlashdata('error', '❌ No equipment ID provided!');
            return redirect()->to('admin/equipment');
        }
        
        return view('admin/edit-equipment', $data);
    }

    public function editEquipmentReq()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        if (strtolower($this->request->getMethod()) === 'post') {
            $equip_id = $this->request->getPost('equip_id');
            
            if (!$equip_id) {
                session()->setFlashdata('error', '❌ Invalid equipment ID!');
                return redirect()->to('admin/equipment');
            }
            
            $rules = [
                'ename' => 'required|min_length[2]',
                'description' => 'required|min_length[3]',
                'quantity' => 'required|numeric|greater_than[0]',
                'amount' => 'required|numeric|greater_than[0]',
                'vendor' => 'required|min_length[2]'
            ];
            
            if (! $this->validate($rules)) {
                $db = \Config\Database::connect();
                $equip = $db->table('equipment')->where('id', $equip_id)->get()->getRowArray();
                return view('admin/edit-equipment', [
                    'equipment' => $equip,
                    'equip_id' => $equip_id,
                    'page' => 'update-equip',
                    'validation' => $this->validator
                ]);
            }
            
            $quantity = intval($this->request->getPost('quantity'));
            $amount = floatval($this->request->getPost('amount'));
            $totalamount = $amount * $quantity;
            
            $data = [
                'name' => $this->request->getPost('ename'),
                'description' => $this->request->getPost('description'),
                'amount' => $totalamount,
                'quantity' => $quantity,
                'vendor' => $this->request->getPost('vendor'),
                'address' => $this->request->getPost('address') ?? '',
                'contact' => $this->request->getPost('contact') ?? ''
            ];
            
            try {
                $db = \Config\Database::connect();
                $db->table('equipment')->where('id', $equip_id)->update($data);
                
                if ($db->affectedRows() > 0) {
                    session()->setFlashdata('success', '✅ Equipment updated successfully!');
                } else {
                    session()->setFlashdata('error', '⚠️ No changes made!');
                }
                return redirect()->to('admin/equipment');
            } catch (\Exception $e) {
                session()->setFlashdata('error', '❌ Error updating equipment: ' . $e->getMessage());
                return redirect()->back();
            }
        }
        
        return redirect()->to('admin/equipment');
    }

    public function removeEquipment()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        $id = $this->request->getGet('id') ?? 0;
        if ($id) {
            $db = \Config\Database::connect();
            $db->query("DELETE FROM equipment WHERE id = ?", [$id]);
            session()->setFlashdata('success', '✅ Equipment deleted successfully!');
        }
        return redirect()->to('admin/equipment');
    }

    public function deleteEquipment() { return view('admin/actions/delete-equipment', ['page' => 'remove-equip']); }
    
    // ✅ STUB METHODS (for backward compatibility)
    public function editEquipmentform() { return view('admin/edit-equipmentform', ['page' => 'update-equip']); }
    public function addedStaffs() { return view('admin/added-staffs', ['page' => 'staff-management']); }

    // ATTENDANCE SECTION
    public function attendance() 
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('admin/attendance', ['page' => 'attendance']); 
    }
    
    public function qr_scanner() { 
        return view('admin/qr_scanner', ['page' => 'attendance']); 
    }

    public function checkAttendance()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(site_url('admin'));
        }
        $id = $this->request->getGet('id');
        $clientTime = $this->request->getGet('time'); // Get time from client
        
        if (! $id) {
            return redirect()->to(site_url('admin/attendance'));
        }

        $db = \Config\Database::connect();
        date_default_timezone_set('Asia/Kathmandu');
        $curr_date = date('Y-m-d');
        // Use client time if provided, otherwise fall back to server time
        $curr_time = $clientTime ? $clientTime : date('H:i:s');

        // Ensure checkout_time column exists (backfill if DB is older)
        $col = $db->query("SHOW COLUMNS FROM attendance LIKE 'checkout_time'")->getRowArray();
        if (! $col) {
            try {
                $db->query("ALTER TABLE attendance ADD COLUMN checkout_time VARCHAR(10) NULL DEFAULT NULL");
                log_message('info', 'Added checkout_time column to attendance table');
            } catch (\Exception $e) {
                log_message('error', 'Failed to add checkout_time column: ' . $e->getMessage());
            }
        }

        $existing = $db->table('attendance')->where('curr_date', $curr_date)->where('user_id', $id)->get()->getRowArray();
        if (! $existing) {
            // First check-in of the day
            $db->table('attendance')->insert(['user_id' => $id, 'curr_date' => $curr_date, 'curr_time' => $curr_time, 'present' => 1]);
            $db->table('members')->where('user_id', $id)->increment('attendance_count');
            log_message('info', "Admin Check-in: User $id at $curr_time");
        } else {
            // If already checked in and no checkout recorded, record checkout time
            $hasCheckout = array_key_exists('checkout_time', $existing) && !empty($existing['checkout_time']);
            if (! $hasCheckout) {
                   $mysqli = mysqli_connect("localhost","root","","gymnsb");
                   $update_sql = "UPDATE attendance SET checkout_time = '" . mysqli_real_escape_string($mysqli, $curr_time) . "' WHERE id = " . intval($existing['id']);
                   $result = mysqli_query($mysqli, $update_sql);
                   if (!$result) {
                       error_log("Admin checkout update failed: " . mysqli_error($mysqli));
                   }
                   mysqli_close($mysqli);
            } else {
                log_message('info', "User $id already checked out at {$existing['checkout_time']}");
            }
        }

        return redirect()->to(site_url('admin/attendance'));
    }

    public function mark_qr_attendance()
    {
        if (!$this->request->isAJAX() && !session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not logged in']);
        }

        $member_id = $this->request->getPost('user_id');
        if (!$member_id || !is_numeric($member_id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid member ID: ' . $member_id]);
        }

        $db = \Config\Database::connect();
        $member = $db->query("SELECT fullname, username FROM members WHERE user_id = ?", [$member_id])->getRowArray();
        if (!$member) {
            return $this->response->setJSON(['success' => false, 'message' => 'Member not found ID: ' . $member_id]);
        }

        date_default_timezone_set('Asia/Kathmandu');
        $curr_date = date('Y-m-d');
        $curr_time = date('H:i:s');
        
        $existing = $db->query("SELECT * FROM attendance WHERE curr_date = ? AND user_id = ?", [$curr_date, $member_id])->getRowArray();
        // Ensure checkout_time column exists
        $col = $db->query("SHOW COLUMNS FROM attendance LIKE 'checkout_time'")->getRowArray();
        if (! $col) {
            try { $db->query("ALTER TABLE attendance ADD COLUMN checkout_time TEXT NULL"); } catch (\Exception $e) {}
        }

        if ($existing) {
            // If checked-in but no checkout recorded, set checkout
            if (empty($existing['checkout_time'])) {
                $db->query("UPDATE attendance SET checkout_time = ? WHERE id = ?", [$curr_time, $existing['id']]);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => '✅ Checkout recorded for ' . $member['fullname'],
                    'member_id' => $member_id,
                    'time' => $curr_time,
                    'member_name' => $member['fullname'],
                    'date' => $curr_date
                ]);
            }

            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Already marked and checked-out today for ' . $member['fullname'],
                'member_name' => $member['fullname']
            ]);
        }

        $db->query("INSERT INTO attendance (user_id, curr_date, curr_time, present) VALUES (?, ?, ?, 1)", 
            [$member_id, $curr_date, $curr_time]);
        $db->query("UPDATE members SET attendance_count = attendance_count + 1 WHERE user_id = ?", 
            [$member_id]);

        return $this->response->setJSON([
            'success' => true, 
            'message' => '✅ Attendance marked for ' . $member['fullname'] . ' (@' . $member['username'] . ')',
            'member_id' => $member_id,
            'time' => $curr_time,
            'member_name' => $member['fullname'],
            'date' => $curr_date
        ]);
    }

   public function generate_qr($member_id = null)
{
    if (! session()->get('isLoggedIn')) {
        return redirect()->to('/');
    }

    if (!$member_id || !is_numeric($member_id)) {
        return view('admin/error_qr');
    }

    $db = \Config\Database::connect();
    $member = $db->query(
        "SELECT fullname, username FROM members WHERE user_id = ?",
        [$member_id]
    )->getRowArray();

    if (!$member) {
        return view('admin/error_qr');
    }

    $qr_data = "GYM_ATTENDANCE:user_id=" . $member_id;
    $qr_url  = "https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=" . urlencode($qr_data);

    $db->query(
        "UPDATE members SET qr_code_path = ? WHERE user_id = ?",
        ['SIMPLE_QR:' . $member_id, $member_id]
    );

    return view('admin/qr_generated', [
        'qr_url'    => $qr_url,
        'member'    => $member,
        'qr_data'   => $qr_data,
        'member_id' => $member_id
    ]);
}


    public function old_qr($member_id)
    {
        $base_url = config('App')->baseURL;
        $qr_data = rtrim($base_url, '/') . '/admin/mark_qr_attendance?user_id=' . $member_id;
        $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=" . urlencode($qr_data);
        return redirect()->to($qr_url);
    }

    public function deleteAttendance()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(site_url('admin'));
        }
        $id = $this->request->getGet('id');
        if (! $id) {
            return redirect()->to(site_url('admin/attendance'));
        }

        $db = \Config\Database::connect();
        date_default_timezone_set('Asia/Kathmandu');
        $curr_date = date('Y-m-d');
        
        $db->table('attendance')->where('user_id', $id)->where('curr_date', $curr_date)->delete();
        // Decrement attendance_count but don't go below 0
        $member = $db->table('members')->where('user_id', $id)->get()->getRowArray();
        if ($member && $member['attendance_count'] > 0) {
            $db->table('members')->where('user_id', $id)->update(['attendance_count' => $member['attendance_count'] - 1]);
        }

        return redirect()->to(site_url('admin/attendance'));
    }
    
    public function viewAttendance() 
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('admin/view-attendance', ['page' => 'view-attendance']); 
    }

    // ALL OTHER METHODS - UNCHANGED
    public function reports() { return view('admin/reports', ['page' => 'chart']); }
    public function customerProgress() { return view('admin/customer-progress', ['page' => 'manage-customer-progress']); }
    public function progressReport() { return view('admin/progress-report', ['page' => 'c-p-r']); }
    public function viewProgressReport() { 
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(site_url('admin'));
        }
        $db = \Config\Database::connect();
        $member_id = $this->request->getGet('id');
        if (!$member_id) {
            return redirect()->to(site_url('admin/customer-progress'));
        }
        $member = $db->table('members')->where('user_id', $member_id)->get()->getRowArray();
        if (!$member) {
            return redirect()->to(site_url('admin/customer-progress'));
        }
        return view('admin/view-progress-report', ['member' => $member, 'page' => 'c-p-r']);
    }
    public function membersReport() { return view('admin/members-report', ['page' => 'member-repo']); }
    public function viewMemberReport() { 
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(site_url('admin'));
        }
        $db = \Config\Database::connect();
        $member_id = $this->request->getGet('id');
        if (!$member_id) {
            return redirect()->to(site_url('admin/members-report'));
        }
        $member = $db->table('members')->where('user_id', $member_id)->get()->getRowArray();
        if (!$member) {
            return redirect()->to(site_url('admin/members-report'));
        }
        return view('admin/view-member-report', ['member' => $member, 'page' => 'member-repo']);
    }
    
    public function servicesReport() { 
        $db = \Config\Database::connect();
        $services = $db->query("SELECT services, count(*) as number FROM members GROUP BY services")->getResultArray() ?? [];
        return view('admin/services-report', ['services' => $services, 'page' => 'service-repo']); 
    }

    public function payment() { return view('admin/payment', ['page' => 'payment']); }
    public function userPayment()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        // Get member ID from query string
        $member_id = $this->request->getGet('id');
        
        if (!$member_id) {
            return redirect()->to('admin/payment');
        }
        
        // Get member data from database
        $db = \Config\Database::connect();
        $member = $db->query("SELECT * FROM members WHERE user_id = ?", [$member_id])->getRowArray();
        
        if (!$member) {
            return redirect()->to('admin/payment');
        }
        
        return view('admin/user-payment', [
            'page' => 'payment',
            'member' => $member
        ]);
    }
    
    public function userpay()
    {
        // Handle POST request for payment processing
        if (strtolower($this->request->getMethod()) === 'post') {
            $db = \Config\Database::connect();
            
            $fullname = trim($this->request->getPost('fullname') ?? '');
            $services = trim($this->request->getPost('services') ?? '');
            $amount = intval($this->request->getPost('amount') ?? 0);
            $plan = intval($this->request->getPost('plan') ?? 1);
            $status = trim($this->request->getPost('status') ?? 'Active');
            $member_id = intval($this->request->getPost('id') ?? 0);
            
            // Set timezone to Asia/Kolkata
            date_default_timezone_set('Asia/Kolkata');
            $curr_date = date('Y-m-d');
            
            // Validate minimum requirements
            if (!empty($fullname) && $member_id > 0 && $amount > 0) {
                // Calculate payable amount
                $amountpayable = $amount * $plan;
                
                // Update member payment record
                try {
                    $db->query(
                        "UPDATE members SET amount = ?, plan = ?, status = ?, paid_date = ?, reminder = 0 WHERE user_id = ?",
                        [$amountpayable, $plan, $status, $curr_date, $member_id]
                    );
                    
                    // Success - pass data to receipt view
                    return view('admin/userpay', [
                        'page' => 'payment',
                        'fullname' => $fullname,
                        'services' => $services,
                        'amount' => $amount,
                        'plan' => $plan,
                        'status' => $status,
                        'amountpayable' => $amountpayable,
                        'paid_date' => $curr_date,
                        'success' => true
                    ]);
                } catch (\Exception $e) {
                    // Database error
                    return view('admin/userpay', [
                        'page' => 'payment',
                        'success' => false,
                        'error' => 'Database error: ' . $e->getMessage()
                    ]);
                }
            } else {
                // Validation failed - show what was missing
                return view('admin/userpay', [
                    'page' => 'payment',
                    'success' => false,
                    'error' => 'Missing required data: fullname=' . $fullname . ', member_id=' . $member_id . ', amount=' . $amount
                ]);
            }
        }
        
        // GET request - show form
        return view('admin/userpay', ['page' => 'payment', 'success' => false]);
    }
    
    public function searchResult() { return view('admin/search-result', ['page' => 'payment']); }
    public function sendReminder($member_id = null) {
        // Initialize database connection first
        $db = \Config\Database::connect();
        
        // Get member_id from URL segment first, then fallback to query/post
        if (!$member_id) {
            $member_id = $this->request->getGet('id') ?? $this->request->getPost('member_id');
        }
        
        log_message('info', '═══════════ sendReminder CALLED ═══════════');
        log_message('info', 'Method: ' . $this->request->getMethod());
        log_message('info', 'member_id parameter: ' . var_export($member_id, true));
        log_message('info', 'POST data: ' . json_encode($this->request->getPost()));
        
        // Handle POST request (send email or update email)
        if ($this->request->getMethod() === 'post') {
            log_message('info', '→ Processing POST request');
            $action = $this->request->getPost('action');
            log_message('info', '→ Action: ' . var_export($action, true));
            
            if (!$member_id) {
                log_message('error', '✗ POST: No valid member_id found');
                return redirect()->back()->with('error', 'Invalid member ID');
            }
            
            log_message('info', '→ Member ID validated: ' . intval($member_id));
            
            // If action is to add/update email
            if ($action === 'update_email') {
                $email = trim($this->request->getPost('email'));
                
                if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return redirect()->back()->with('error', 'Please enter a valid email address');
                }
                
                // Update email in database
                $db->query("UPDATE members SET email = ? WHERE user_id = ?", [$email, $member_id]);
                
                return redirect()->back()->with('success', 'Email updated successfully. Now you can send the reminder.');
            }
            
            // If action is to send reminder
            if ($action === 'send_reminder') {
                try {
                    log_message('info', '→ POST: Starting send_reminder action for member_id: ' . $member_id);
                    
                    $member = $db->query("SELECT * FROM members WHERE user_id = ?", [$member_id])->getRowArray();
                    
                    if (!$member) {
                        log_message('error', 'Member not found for ID: ' . $member_id);
                        return redirect()->back()->with('error', 'Member not found');
                    }
                    
                    if (empty($member['email'])) {
                        log_message('warning', 'No email for member ID: ' . $member_id);
                        return redirect()->back()->with('error', 'Email address is required. Please add email first.');
                    }
                    
                    log_message('info', '→ Member found: ' . $member['fullname'] . ' (' . $member['email'] . ')');
                    
                    // Update reminder flag in database FIRST (don't wait for email)
                    $db->query("UPDATE members SET reminder = 1 WHERE user_id = ?", [$member_id]);
                    log_message('info', '✓ Reminder flag updated in database for member ID: ' . $member_id);
                    
                    // Attempt to send email but don't block (use timeout and error suppression)
                    log_message('info', '→ Attempting to send email (non-blocking)...');
                    
                    try {
                        $emailService = \Config\Services::email();
                        $emailService->clear();
                        
                        $emailService->setFrom('noreply@yourgymspartner.com', 'Your Gym Partner');
                        $emailService->setTo(trim($member['email']));
                        $emailService->setReplyTo('noreply@yourgymspartner.com');
                        $emailService->setSubject('Payment Reminder - ' . $member['fullname']);
                        
                        $memberName = htmlspecialchars($member['fullname'], ENT_QUOTES, 'UTF-8');
                        $memberService = htmlspecialchars($member['services'], ENT_QUOTES, 'UTF-8');
                        $memberAmount = htmlspecialchars($member['amount'], ENT_QUOTES, 'UTF-8');
                        $memberPaidDate = htmlspecialchars($member['paid_date'], ENT_QUOTES, 'UTF-8');
                        
                        $emailBody = "
                        <html>
                        <head>
                            <style>
                                body { font-family: Arial, sans-serif; color: #333; }
                                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                                .header { background: #1f4e78; color: white; padding: 20px; border-radius: 5px 5px 0 0; }
                                .content { background: #f8f9fa; padding: 20px; }
                                .footer { background: #e9ecef; padding: 15px; text-align: center; font-size: 12px; }
                                .amount { color: #dc3545; font-size: 18px; font-weight: bold; }
                            </style>
                        </head>
                        <body>
                            <div class='container'>
                                <div class='header'>
                                    <h2>Payment Reminder Notice</h2>
                                </div>
                                <div class='content'>
                                    <p>Dear <strong>" . $memberName . "</strong>,</p>
                                    <p>This is a friendly reminder that your gym membership payment is due.</p>
                                    <p><strong>Payment Details:</strong></p>
                                    <ul>
                                        <li><strong>Service:</strong> " . $memberService . "</li>
                                        <li><strong>Amount Due:</strong> <span class='amount'>₹" . $memberAmount . "</span></li>
                                        <li><strong>Last Payment Date:</strong> " . $memberPaidDate . "</li>
                                    </ul>
                                    <p>Please complete your payment at your earliest convenience to avoid any interruption to your membership.</p>
                                    <p>If you have already made the payment, please disregard this message.</p>
                                    <p>Thank you for being a valued member of our gym!</p>
                                    <p>Best regards,<br><strong>Your Gym Partner Administration</strong></p>
                                </div>
                                <div class='footer'>
                                    <p>© 2026 Your Gym Partner. All rights reserved.</p>
                                </div>
                            </div>
                        </body>
                        </html>";
                        
                        $emailService->setMessage($emailBody);
                        $emailService->setMailType('html');
                        
                        // Try to send but suppress errors and don't wait
                        @$emailService->send(false);
                        log_message('info', 'Email send attempt completed for: ' . $member['email']);
                        
                    } catch (\Throwable $e) {
                        log_message('warning', 'Email send error (non-critical): ' . $e->getMessage());
                    }
                    
                    // ALWAYS redirect after updating database
                    log_message('info', '✓ Redirecting to admin/payment with success message');
                    return redirect()->to('admin/payment')->with('success', 'Reminder sent to ' . htmlspecialchars($member['email'], ENT_QUOTES, 'UTF-8'));
                    
                } catch (\Throwable $e) {
                    log_message('error', 'Send reminder fatal error: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
                }
            }
        }
        
        // Handle GET request (display form)
        log_message('info', '→ Displaying send reminder form for member ID: ' . intval($member_id));
        
        if (!$member_id || !is_numeric($member_id) || intval($member_id) <= 0) {
            log_message('warning', '✗ GET: Invalid member ID provided: ' . var_export($member_id, true));
            return redirect()->to('admin/payment')->with('error', 'Invalid member ID provided');
        }
        
        $member_id = intval($member_id);
        log_message('info', '→ Member ID validated as: ' . $member_id);
        
        $member = $db->query("SELECT * FROM members WHERE user_id = ?", [$member_id])->getRowArray();
        
        if (!$member) {
            log_message('warning', '✗ GET: Member not found with ID: ' . $member_id);
            return redirect()->to('admin/payment')->with('error', 'Member not found');
        }
        
        log_message('info', '✓ GET: Rendering form for member: ' . htmlspecialchars($member['fullname']));
        
        return view('admin/sendReminder', [
            'page' => 'payment',
            'member' => $member
        ]);
    }

    // ✅ SEND BULK REMINDERS TO ALL MEMBERS WITHOUT REMINDER
    public function sendBulkReminders() {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        if ($this->request->getMethod() === 'post') {
            try {
                $db = \Config\Database::connect();
                
                // Get all members who haven't received a reminder yet (reminder = 0) and have email
                $members = $db->query("SELECT * FROM members WHERE reminder = 0 AND email IS NOT NULL AND email != ''")->getResultArray();
                
                if (empty($members)) {
                    return redirect()->to('admin/payment')->with('info', 'No members need reminders at this time.');
                }
                
                $emailService = \Config\Services::email();
                $successCount = 0;
                $failedCount = 0;
                $failedEmails = [];
                
                foreach ($members as $member) {
                    try {
                        // Clear previous email configurations
                        $emailService->clear();
                        
                        // Set email configuration
                        $emailService->setFrom('noreply@yourgymspartner.com', 'Your Gym Partner');
                        $emailService->setTo(trim($member['email']));
                        $emailService->setReplyTo('noreply@yourgymspartner.com');
                        $emailService->setSubject('Payment Reminder - ' . $member['fullname']);
                        
                        // Prepare email body with proper escaping
                        $memberName = htmlspecialchars($member['fullname'], ENT_QUOTES, 'UTF-8');
                        $memberService = htmlspecialchars($member['services'], ENT_QUOTES, 'UTF-8');
                        $memberAmount = htmlspecialchars($member['amount'], ENT_QUOTES, 'UTF-8');
                        $memberPaidDate = htmlspecialchars($member['paid_date'], ENT_QUOTES, 'UTF-8');
                        
                        $emailBody = "
                        <html>
                        <head>
                            <style>
                                body { font-family: Arial, sans-serif; color: #333; }
                                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                                .header { background: #1f4e78; color: white; padding: 20px; border-radius: 5px 5px 0 0; }
                                .content { background: #f8f9fa; padding: 20px; }
                                .footer { background: #e9ecef; padding: 15px; text-align: center; font-size: 12px; }
                                .amount { color: #dc3545; font-size: 18px; font-weight: bold; }
                            </style>
                        </head>
                        <body>
                            <div class='container'>
                                <div class='header'>
                                    <h2>Payment Reminder Notice</h2>
                                </div>
                                <div class='content'>
                                    <p>Dear <strong>" . $memberName . "</strong>,</p>
                                    <p>This is a friendly reminder that your gym membership payment is due.</p>
                                    <p><strong>Payment Details:</strong></p>
                                    <ul>
                                        <li><strong>Service:</strong> " . $memberService . "</li>
                                        <li><strong>Amount Due:</strong> <span class='amount'>₹" . $memberAmount . "</span></li>
                                        <li><strong>Last Payment Date:</strong> " . $memberPaidDate . "</li>
                                    </ul>
                                    <p>Please complete your payment at your earliest convenience to avoid any interruption to your membership.</p>
                                    <p>If you have already made the payment, please disregard this message.</p>
                                    <p>Thank you for being a valued member of our gym!</p>
                                    <p>Best regards,<br><strong>Your Gym Partner Administration</strong></p>
                                </div>
                                <div class='footer'>
                                    <p>© 2026 Your Gym Partner. All rights reserved.</p>
                                </div>
                            </div>
                        </body>
                        </html>";
                        
                        $emailService->setMessage($emailBody);
                        $emailService->setMailType('html');
                        
                        // Attempt to send the email
                        if ($emailService->send(false)) {
                            $successCount++;
                            log_message('info', 'Bulk reminder sent to: ' . $member['email']);
                            // Mark reminder as sent
                            $db->query("UPDATE members SET reminder = 1 WHERE user_id = ?", [$member['user_id']]);
                        } else {
                            $failedCount++;
                            $failedEmails[] = $member['email'];
                            log_message('warning', 'Failed to send bulk reminder to: ' . $member['email']);
                        }
                    } catch (\Throwable $e) {
                        $failedCount++;
                        $failedEmails[] = $member['email'];
                        log_message('error', 'Bulk email exception for ' . $member['email'] . ': ' . $e->getMessage());
                    }
                }
                
                // Prepare success message
                $message = "Bulk reminders sent to $successCount member(s)";
                if ($failedCount > 0) {
                    $message .= ". Failed to send to $failedCount member(s)";
                }
                
                return redirect()->to('admin/payment')->with('success', $message);
                
            } catch (\Throwable $e) {
                log_message('error', 'Bulk send reminder fatal error: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Fatal error: ' . $e->getMessage());
            }
        }
        
        // Handle GET request (display confirmation page)
        $db = \Config\Database::connect();
        $pendingMembers = $db->query("SELECT * FROM members WHERE reminder = 0 AND email IS NOT NULL AND email != ''")->getResultArray();
        
        return view('admin/sendBulkReminders', [
            'page' => 'payment',
            'pendingMembers' => $pendingMembers,
            'count' => count($pendingMembers)
        ]);
    }
    
    public function searchResultProgress() { return view('admin/search-result-progress', ['page' => 'c-p-r']); }

    public function announcement() { return view('admin/announcement', ['page' => 'announcement']); }
    public function postAnnouncement() { return view('admin/post-announcement', ['page' => 'announcement']); }
    public function manageAnnouncement() { return view('admin/manage-announcement', ['page' => 'announcement']); }
    public function removeAnnouncement() { return view('admin/actions/remove-announcement', ['page' => 'announcement']); }

    // ✅ STAFF SECTION - FULL CRUD
    public function staffs()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        $db = \Config\Database::connect();
        $data['staffs'] = $db->table('staffs')->orderBy('user_id', 'DESC')->get()->getResultArray();
        $data['page'] = 'staff-management';
        
        return view('admin/staffs', $data);
    }

    public function staffsEntry()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('admin/staffs-entry', ['page' => 'staff-management']);
    }

    // ✅ ADD STAFF - INSERT
    public function addStaff()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        if (strtolower($this->request->getMethod()) === 'post') {
            $rules = [
                'fullname' => 'required|min_length[2]',
                'username' => 'required|min_length[3]|is_unique[staffs.username]',
                'password' => 'required|min_length[6]',
                'email' => 'required|valid_email',
                'gender' => 'required',
                'designation' => 'required|min_length[2]',
                'contact' => 'required|numeric'
            ];
            
            if (! $this->validate($rules)) {
                return view('admin/staffs-entry', [
                    'page' => 'staff-management',
                    'validation' => $this->validator
                ]);
            }
            
            $data = [
                'fullname' => $this->request->getPost('fullname'),
                'username' => $this->request->getPost('username'),
                'password' => md5($this->request->getPost('password')),
                'email' => $this->request->getPost('email'),
                'gender' => $this->request->getPost('gender'),
                'designation' => $this->request->getPost('designation'),
                'address' => $this->request->getPost('address') ?? '',
                'contact' => $this->request->getPost('contact')
            ];
            
            try {
                $db = \Config\Database::connect();
                $db->table('staffs')->insert($data);
                session()->setFlashdata('success', '✅ Staff member added successfully!');
                return redirect()->to('admin/staffs');
            } catch (\Exception $e) {
                session()->setFlashdata('error', '❌ Error adding staff: ' . $e->getMessage());
                return view('admin/staffs-entry', ['page' => 'staff-management']);
            }
        }
        
        return view('admin/staffs-entry', ['page' => 'staff-management']);
    }

    public function editStaffForm()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        $staff_id = $this->request->getGet('id');
        $data = ['page' => 'staff-management'];
        
        if ($staff_id) {
            $db = \Config\Database::connect();
            $staff = $db->table('staffs')
                        ->where('user_id', $staff_id)
                        ->get()
                        ->getRowArray();
            
            if ($staff) {
                $data['staff'] = $staff;
                $data['staff_id'] = $staff_id;
            } else {
                session()->setFlashdata('error', '❌ Staff member not found!');
                return redirect()->to('admin/staffs');
            }
        } else {
            session()->setFlashdata('error', '❌ No staff ID provided!');
            return redirect()->to('admin/staffs');
        }
        
        return view('admin/edit-staff-form', $data);
    }

    public function editStaffReq()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        if (strtolower($this->request->getMethod()) === 'post') {
            $staff_id = $this->request->getPost('staff_id');
            
            if (!$staff_id) {
                session()->setFlashdata('error', '❌ Invalid staff ID!');
                return redirect()->to('admin/staffs');
            }
            
            $rules = [
                'fullname' => 'required|min_length[2]',
                'username' => 'required|min_length[3]',
                'email' => 'required|valid_email',
                'gender' => 'required',
                'designation' => 'required|min_length[2]',
                'contact' => 'required|numeric'
            ];
            
            if (! $this->validate($rules)) {
                $db = \Config\Database::connect();
                $staff = $db->table('staffs')->where('user_id', $staff_id)->get()->getRowArray();
                return view('admin/edit-staff-form', [
                    'staff' => $staff,
                    'staff_id' => $staff_id,
                    'page' => 'staff-management',
                    'validation' => $this->validator
                ]);
            }
            
            $data = [
                'fullname' => $this->request->getPost('fullname'),
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'gender' => $this->request->getPost('gender'),
                'designation' => $this->request->getPost('designation'),
                'address' => $this->request->getPost('address') ?? '',
                'contact' => $this->request->getPost('contact')
            ];
            
            try {
                $db = \Config\Database::connect();
                $db->table('staffs')->where('user_id', $staff_id)->update($data);
                
                if ($db->affectedRows() > 0) {
                    session()->setFlashdata('success', '✅ Staff updated successfully!');
                } else {
                    session()->setFlashdata('error', '⚠️ No changes made!');
                }
                return redirect()->to('admin/staffs');
            } catch (\Exception $e) {
                session()->setFlashdata('error', '❌ Error updating staff: ' . $e->getMessage());
                return redirect()->back();
            }
        }
        
        return redirect()->to('admin/staffs');
    }

    public function removeStaff()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        $id = $this->request->getGet('id') ?? 0;
        if ($id) {
            $db = \Config\Database::connect();
            $db->query("DELETE FROM staffs WHERE user_id = ?", [$id]);
            session()->setFlashdata('success', '✅ Staff deleted successfully!');
        }
        return redirect()->to('admin/staffs');
    }
}
?>
