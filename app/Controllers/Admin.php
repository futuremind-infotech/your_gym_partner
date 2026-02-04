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
        
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'fullname' => 'required|min_length[2]',
                'username' => 'required|min_length[3]|is_unique[members.username]',
                'password' => 'required|min_length[6]',
                'gender' => 'required',
                'services' => 'required',
                'amount' => 'required|numeric|greater_than[0]',
                'plan' => 'required|integer|greater_than[0]'
            ];
            
            if (! $this->validate($rules)) {
                return view('admin/member-entry', ['page' => 'members-entry']);
            }
            return $this->addMemberReq(); 
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
        $data = [];
        
        if ($member_id) {
            $db = \Config\Database::connect();
            $member = $db->table('members')
                        ->where('user_id', $member_id)
                        ->get()
                        ->getRowArray();
            
            if ($member) {
                $data['member'] = $member;
            }
            $data['member_id'] = $member_id;
        }
        
        return view('admin/edit-member', $data);
    }

    // ✅ FIXED addMemberReq - INSERT NEW MEMBER
    public function addMemberReq()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        if ($this->request->getMethod() === 'post') {
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
                'last_attendance' => null
            ];
            
            $db = \Config\Database::connect();
            $db->query("INSERT INTO members (fullname,username,password,dor,gender,services,amount,p_year,paid_date,plan,address,contact,attendance_count,last_attendance) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)", 
                array_values($data));
            
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
        
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'fullname' => 'required|min_length[2]',
                'username' => 'required|min_length[3]',
                'gender' => 'required',
                'services' => 'required',
                'amount' => 'required|numeric|greater_than[0]',
                'plan' => 'required|integer|greater_than[0]'
            ];
            
            if (! $this->validate($rules)) {
                $user_id = $this->request->getPost('user_id');
                $db = \Config\Database::connect();
                $member = $db->table('members')->where('user_id', $user_id)->get()->getRowArray();
                return view('admin/edit-member', ['member' => $member, 'member_id' => $user_id]);
            }
            
            $user_id = $this->request->getPost('user_id');
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
            
            $db = \Config\Database::connect();
            $db->query("UPDATE members SET fullname=?, username=?, gender=?, contact=?, address=?, amount=?, services=?, plan=? WHERE user_id=?", 
                array_values($data) + [$user_id]);
            
            if ($db->affectedRows() > 0) {
                session()->setFlashdata('success', '✅ Member updated successfully!');
            } else {
                session()->setFlashdata('error', '❌ No changes made or member not found!');
            }
            
            return redirect()->to('admin/members');
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

    public function deleteMember() { return view('admin/actions/delete-member', ['page' => 'members-remove']); }
    public function memberStatus() { return view('admin/member-status', ['page' => 'member-status']); }

    // EQUIPMENT SECTION
    public function equipment() { return view('admin/equipment', ['page' => 'list-equip']); }
    public function equipmentEntry() { return view('admin/equipment-entry', ['page' => 'add-equip']); }
    public function addEquipment() { return view('admin/add-equipment-req', ['page' => 'add-equip']); }
    public function editEquipment() { return view('admin/edit-equipment', ['page' => 'update-equip']); }
    public function editEquipmentform() { return view('admin/edit-equipmentform', ['page' => 'update-equip']); }
    public function editEquipmentReq() { return view('admin/edit-equipment-req', ['page' => 'update-equip']); }
    public function removeEquipment() { return view('admin/remove-equipment', ['page' => 'remove-equip']); }
    public function deleteEquipment() { return view('admin/actions/delete-equipment', ['page' => 'remove-equip']); }

    // ATTENDANCE SECTION
    public function attendance() { return view('admin/attendance', ['page' => 'attendance']); }
    
    public function qr_scanner() { 
        return view('admin/qr_scanner', ['page' => 'attendance']); 
    }

    public function checkAttendance()
    {
        $id = $this->request->getGet('id');
        if (! $id) {
            return redirect()->to('/admin/attendance');
        }

        $db = \Config\Database::connect();
        date_default_timezone_set('Asia/Kolkata');
        $curr_date = date('Y-m-d');
        $curr_time = date('H:i:s');

        $existing = $db->query("SELECT * FROM attendance WHERE curr_date = ? AND user_id = ?", [$curr_date, $id])->getRowArray();
        if (! $existing) {
            $db->query("INSERT INTO attendance (user_id, curr_date, curr_time, present) VALUES (?, ?, ?, 1)", [$id, $curr_date, $curr_time]);
            $db->query("UPDATE members SET attendance_count = attendance_count + 1 WHERE user_id = ?", [$id]);
        }

        return redirect()->to('/admin/attendance');
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

        date_default_timezone_set('Asia/Kolkata');
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
        $db->query("UPDATE members SET attendance_count = attendance_count + 1, last_attendance = ? WHERE user_id = ?", 
            [$curr_date, $member_id]);

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
        $id = $this->request->getGet('id');
        if (! $id) {
            return redirect()->to('/admin/attendance');
        }

        $db = \Config\Database::connect();
        $db->query("DELETE FROM attendance WHERE user_id = ?", [$id]);
        $db->query("UPDATE members SET attendance_count = GREATEST(attendance_count - 1, 0) WHERE user_id = ?", [$id]);

        return redirect()->to('/admin/attendance');
    }
    
    public function viewAttendance() { return view('admin/view-attendance', ['page' => 'view-attendance']); }

    // ALL OTHER METHODS - UNCHANGED
    public function reports() { return view('admin/reports', ['page' => 'chart']); }
    public function customerProgress() { return view('admin/customer-progress', ['page' => 'manage-customer-progress']); }
    public function progressReport() { return view('admin/progress-report', ['page' => 'c-p-r']); }
    public function updateProgress() { return view('admin/update-progress', ['page' => 'c-p-r']); }
    public function viewProgressReport() { return view('admin/view-progress-report', ['page' => 'c-p-r']); }
    public function membersReport() { return view('admin/members-report', ['page' => 'member-repo']); }
    public function viewMemberReport() { return view('admin/view-member-report', ['page' => 'member-repo']); }
    public function servicesReport() { return view('admin/services-report', ['page' => 'services-report']); }

    public function payment() { return view('admin/payment', ['page' => 'payment']); }
    public function userPayment() { return view('admin/user-payment', ['page' => 'payment']); }
    
    public function userpay()
    {
        // Handle POST request for payment processing
        if ($this->request->getMethod() === 'post') {
            $db = \Config\Database::connect();
            
            $fullname = $this->request->getPost('fullname');
            $services = $this->request->getPost('services');
            $amount = intval($this->request->getPost('amount'));
            $plan = intval($this->request->getPost('plan'));
            $status = $this->request->getPost('status');
            $member_id = intval($this->request->getPost('id'));
            
            // Calculate payable amount
            $amountpayable = $amount * $plan;
            
            // Set timezone to Asia/Kolkata
            date_default_timezone_set('Asia/Kolkata');
            $curr_date = date('Y-m-d');
            
            // Update member payment record
            $db->query(
                "UPDATE members SET amount = ?, plan = ?, status = ?, paid_date = ?, reminder = 0 WHERE user_id = ?",
                [$amountpayable, $plan, $status, $curr_date, $member_id]
            );
            
            // Pass data to receipt view
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

    public function staffs() { return view('admin/staffs', ['page' => 'staff-management']); }
    public function staffsEntry() { return view('admin/staffs-entry', ['page' => 'staff-management']); }
    public function addedStaffs() { return view('admin/added-staffs', ['page' => 'staff-management']); }
    public function editStaffForm() { return view('admin/edit-staff-form', ['page' => 'staff-management']); }
    public function editStaffReq() { return view('admin/edit-staff-req', ['page' => 'staff-management']); }
    public function removeStaff() { return view('admin/remove-staff', ['page' => 'staff-management']); }
}
?>
