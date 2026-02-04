<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    public function index()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('admin/index', ['page' => 'dashboard']);
    }

    // MEMBERS SECTION - FULL CRUD
    public function members()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        $db = \Config\Database::connect();
        $data['members'] = $db->table('members')->orderBy('user_id', 'DESC')->get()->getResultArray();
        $data['page'] = 'members';
        
        return view('admin/members', $data);
    }

    public function memberEntry()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('admin/member-entry', ['page' => 'members-entry']);
    }

    // ✅ FIXED addMember - CLEAN SYNTAX + VALIDATION
    public function addMember() 
    { 
            if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        if (strtolower($this->request->getMethod()) === 'post') {            $rules = [
                'fullname' => 'required|min_length[2]',
                'username' => 'required|min_length[3]|is_unique[members.username]',
                'password' => 'required|min_length[6]',
                'gender' => 'required',
                'services' => 'required',
                'amount' => 'required|numeric|greater_than[0]',
                'plan' => 'required|integer|greater_than[0]'
            ];
            
            if (! $this->validate($rules)) {
                return view('admin/member-entry', [
                    'page' => 'members-entry',
                    'validation' => $this->validator
                ]);
            }
            
            // Validation passed - proceed with insertion
            $data = [
                'fullname' => $this->request->getPost('fullname'),
                'username' => $this->request->getPost('username'),
                'password' => md5($this->request->getPost('password')),
                'dor' => $this->request->getPost('dor') ?: date('Y-m-d'),
                'gender' => $this->request->getPost('gender'),
                'services' => $this->request->getPost('services'),
                'amount' => floatval($this->request->getPost('amount')) * intval($this->request->getPost('plan')),
                'p_year' => date('Y'),
                'paid_date' => date('Y-m-d'),
                'plan' => $this->request->getPost('plan'),
                'address' => $this->request->getPost('address'),
                'contact' => $this->request->getPost('contact'),
                'attendance_count' => 0,
                
                // Ensure required columns are present to satisfy DB NOT NULL constraints
                'ini_bodytype' => $this->request->getPost('ini_bodytype') ?? '',
                'curr_bodytype' => $this->request->getPost('curr_bodytype') ?? '',
                'progress_date' => date('Y-m-d'),
                'status' => 'Active'
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
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        $member_id = $this->request->getGet('id');
        
        if (empty($member_id) || !is_numeric($member_id)) {
            session()->setFlashdata('error', 'Invalid member ID!');
            return redirect()->to('admin/members');
        }
        
        $db = \Config\Database::connect();
        $member = $db->table('members')
                    ->where('user_id', intval($member_id))
                    ->limit(1)
                    ->get()
                    ->getRowArray();
        
        $data = [
            'page' => 'members-update',
            'member' => $member
        ];
        
        return view('admin/edit-member', $data);
    }

    // ✅ FIXED addMemberReq - INSERT NEW MEMBER
    public function addMemberReq()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        if (strtolower($this->request->getMethod()) === 'post') {
            $data = [
                'fullname' => $this->request->getPost('fullname'),
                'username' => $this->request->getPost('username'),
                'password' => md5($this->request->getPost('password')),
                'dor' => $this->request->getPost('dor') ?: date('Y-m-d'),
                'gender' => $this->request->getPost('gender'),
                'services' => $this->request->getPost('services'),
                'amount' => floatval($this->request->getPost('amount')) * intval($this->request->getPost('plan')),
                'p_year' => date('Y'),
                'paid_date' => date('Y-m-d'),
                'plan' => $this->request->getPost('plan'),
                'address' => $this->request->getPost('address'),
                'contact' => $this->request->getPost('contact'),
                'attendance_count' => 0,
                // Add missing required columns
                'ini_bodytype' => $this->request->getPost('ini_bodytype') ?? '',
                'curr_bodytype' => $this->request->getPost('curr_bodytype') ?? '',
                'progress_date' => date('Y-m-d'),
                'status' => 'Active'
            ];

            $db = \Config\Database::connect();
            // Use Query Builder to avoid column-order issues
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
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        if (strtolower($this->request->getMethod()) === 'post') {
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
                'plan' => 'required|integer|greater_than[0]'
            ];
            
            if (! $this->validate($rules)) {
                $db = \Config\Database::connect();
                $member = $db->table('members')->where('user_id', $user_id)->get()->getRowArray();
                return view('admin/edit-member', [
                    'member' => $member,
                    'member_id' => $user_id,
                    'validation' => $this->validator
                ]);
            }
            
            $data = [
                'fullname' => $this->request->getPost('fullname'),
                'username' => $this->request->getPost('username'),
                'gender' => $this->request->getPost('gender'),
                'contact' => $this->request->getPost('contact'),
                'address' => $this->request->getPost('address'),
                'amount' => $this->request->getPost('amount'),
                'services' => $this->request->getPost('services'),
                'plan' => $this->request->getPost('plan')
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
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        $id = $this->request->getGet('id') ?? 0;
        if ($id) {
            $db = \Config\Database::connect();
            $db->query("DELETE FROM members WHERE user_id = ?", [$id]);
            session()->setFlashdata('success', 'Member deleted!');
        }
        return redirect()->to('admin/members');
    }

    public function updateProgress()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        if (strtolower($this->request->getMethod()) === 'post') {
            $member_id = $this->request->getPost('id');
            $ini_weight = $this->request->getPost('ini_weight');
            $curr_weight = $this->request->getPost('curr_weight');
            $ini_bodytype = $this->request->getPost('ini_bodytype');
            $curr_bodytype = $this->request->getPost('curr_bodytype');
            
            if (!$member_id) {
                session()->setFlashdata('error', '❌ Invalid member ID!');
                return redirect()->back();
            }
            
            try {
                $db = \Config\Database::connect();
                $db->table('members')->where('user_id', $member_id)->update([
                    'ini_weight' => $ini_weight ?? 0,
                    'curr_weight' => $curr_weight ?? 0,
                    'ini_bodytype' => $ini_bodytype ?? '',
                    'curr_bodytype' => $curr_bodytype ?? '',
                    'progress_date' => date('Y-m-d')
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
    
    public function deleteMember() { return view('admin/actions/delete-member', ['page' => 'members-remove']); }
    public function memberStatus() { return view('admin/member-status', ['page' => 'member-status']); }

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

        $existing = $db->table('attendance')->where('curr_date', $curr_date)->where('user_id', $id)->get()->getRowArray();
        if (! $existing) {
            $db->table('attendance')->insert(['user_id' => $id, 'curr_date' => $curr_date, 'curr_time' => $curr_time, 'present' => 1]);
            $db->table('members')->where('user_id', $id)->increment('attendance_count');
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
        
        $existing = $db->query("SELECT id FROM attendance WHERE curr_date = ? AND user_id = ?", [$curr_date, $member_id])->getRowArray();
        if ($existing) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Already marked today for ' . $member['fullname'],
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
    public function viewProgressReport() { return view('admin/view-progress-report', ['page' => 'c-p-r']); }
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
    public function servicesReport() { return view('admin/services-report', ['page' => 'services-report']); }

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
    public function sendReminder() { return view('admin/sendReminder', ['page' => 'payment']); }
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
