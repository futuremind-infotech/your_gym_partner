<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class Staff extends BaseController
{
    public function index()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('staff/staff-pages/index', ['page' => 'dashboard']);
    }

    // ===================== MEMBER METHODS =====================
    public function members() { 
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('staff/staff-pages/members', ['page' => 'members']); 
    }

    public function memberEntry() { 
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('staff/staff-pages/member-entry', ['page' => 'members-entry']); 
    }

    // ✅ FIXED addMember - HANDLES POST DATA FOR MEMBER CREATION
    public function addMember() { 
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
                return view('staff/staff-pages/member-entry', [
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
                'last_attendance' => null
            ];
            
            try {
                $db = \Config\Database::connect();
                $db->table('members')->insert($data);
                session()->setFlashdata('success', '✅ New member added successfully!');
                return redirect()->to('staff/members');
            } catch (\Exception $e) {
                session()->setFlashdata('error', '❌ Error adding member: ' . $e->getMessage());
                return view('staff/staff-pages/member-entry', ['page' => 'members-entry']);
            }
        }
        
        return view('staff/staff-pages/member-entry', ['page' => 'members-entry']); 
    }

    // ✅ FIXED editMember - LOADS FORM DATA FOR EDITING
    public function editMember() { 
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
        
        // Use edit-memberform.php instead of edit-member.php (which is the list view)
        return view('staff/staff-pages/edit-memberform', $data); 
    }

    // ✅ FIXED editMemberReq - UPDATES MEMBER DATA
    public function editMemberReq() { 
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        if ($this->request->getMethod() === 'post') {
            $user_id = $this->request->getPost('user_id');
            
            if (!$user_id) {
                session()->setFlashdata('error', '❌ Invalid member ID!');
                return redirect()->to('staff/members');
            }
            
            $rules = [
                'fullname' => 'required|min_length[2]',
                'username' => 'required|min_length[3]',
                'gender' => 'required',
                'services' => 'required',
                'amount' => 'required|numeric|greater_than[0]',
                'plan' => 'required|integer|greater_than[0]'
            ];
            
            if (! $this->validate($rules)) {
                $db = \Config\Database::connect();
                $member = $db->table('members')->where('user_id', $user_id)->get()->getRowArray();
                return view('staff/staff-pages/edit-member', [
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
                return redirect()->to('staff/members');
            } catch (\Exception $e) {
                session()->setFlashdata('error', '❌ Error updating member: ' . $e->getMessage());
                return redirect()->back();
            }
        }
        
        return view('staff/staff-pages/edit-member', ['page' => 'members-update']); 
    }

    public function removeMember() { 
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('staff/staff-pages/remove-member', ['page' => 'members-remove']); 
    }

    // ✅ FIXED deleteMember - HANDLES POST DELETION
    public function deleteMember() { 
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        if ($this->request->getMethod() === 'post') {
            $user_id = $this->request->getPost('user_id');
            
            if (!$user_id) {
                session()->setFlashdata('error', '❌ Invalid member ID!');
                return redirect()->to('staff/members');
            }
            
            try {
                $db = \Config\Database::connect();
                $db->table('members')->where('user_id', $user_id)->delete();
                session()->setFlashdata('success', '✅ Member deleted successfully!');
                return redirect()->to('staff/members');
            } catch (\Exception $e) {
                session()->setFlashdata('error', '❌ Error deleting member: ' . $e->getMessage());
                return redirect()->to('staff/members');
            }
        }
        
        return view('staff/staff-pages/actions/delete-member', ['page' => 'members-remove']); 
    }

    public function memberStatus() { 
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('staff/staff-pages/member-status', ['page' => 'membersts']); 
    }

    // ===================== EQUIPMENT METHODS =====================
    public function equipment() { 
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('staff/staff-pages/equipment', ['page' => 'list-equip']); 
    }

    public function equipmentEntry() { 
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('staff/staff-pages/equipment-entry', ['page' => 'add-equip']); 
    }

    // ✅ FIXED addEquipment - HANDLES POST DATA FOR EQUIPMENT CREATION
    public function addEquipment() { 
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[2]',
                'description' => 'required',
                'quantity' => 'required|integer|greater_than[0]',
                'amount' => 'required|numeric|greater_than[0]'
            ];
            
            if (! $this->validate($rules)) {
                return view('staff/staff-pages/equipment-entry', [
                    'page' => 'add-equip',
                    'validation' => $this->validator
                ]);
            }
            
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'quantity' => $this->request->getPost('quantity'),
                'amount' => $this->request->getPost('amount'),
                'date' => $this->request->getPost('date') ?: date('Y-m-d'),
                'contact' => $this->request->getPost('contact'),
                'vendor' => $this->request->getPost('vendor'),
                'address' => $this->request->getPost('address')
            ];
            
            try {
                $db = \Config\Database::connect();
                $db->table('equipments')->insert($data);
                session()->setFlashdata('success', '✅ Equipment added successfully!');
                return redirect()->to('staff/equipment');
            } catch (\Exception $e) {
                session()->setFlashdata('error', '❌ Error adding equipment: ' . $e->getMessage());
                return view('staff/staff-pages/equipment-entry', ['page' => 'add-equip']);
            }
        }
        
        return view('staff/staff-pages/equipment-entry', ['page' => 'add-equip']); 
    }

    public function editEquipment() { 
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        $equip_id = $this->request->getGet('id');
        $data = [];
        
        if ($equip_id) {
            $db = \Config\Database::connect();
            $equipment = $db->table('equipments')
                           ->where('equipment_id', $equip_id)
                           ->get()
                           ->getRowArray();
            
            if ($equipment) {
                $data['equipment'] = $equipment;
            }
            $data['equip_id'] = $equip_id;
        }
        
        return view('staff/staff-pages/edit-equipment', $data); 
    }

    // ✅ FIXED editEquipmentReq - UPDATES EQUIPMENT DATA
    public function editEquipmentReq() { 
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        if ($this->request->getMethod() === 'post') {
            $equip_id = $this->request->getPost('equipment_id');
            
            if (!$equip_id) {
                session()->setFlashdata('error', '❌ Invalid equipment ID!');
                return redirect()->to('staff/equipment');
            }
            
            $rules = [
                'equipment_name' => 'required|min_length[2]',
                'brand' => 'required',
                'cost' => 'required|numeric|greater_than[0]',
                'quantity' => 'required|integer|greater_than[0]'
            ];
            
            if (! $this->validate($rules)) {
                $db = \Config\Database::connect();
                $equipment = $db->table('equipments')->where('equipment_id', $equip_id)->get()->getRowArray();
                return view('staff/staff-pages/edit-equipment', [
                    'equipment' => $equipment,
                    'equip_id' => $equip_id,
                    'validation' => $this->validator
                ]);
            }
            
            $data = [
                'equipment_name' => $this->request->getPost('equipment_name'),
                'brand' => $this->request->getPost('brand'),
                'cost' => $this->request->getPost('cost'),
                'quantity' => $this->request->getPost('quantity')
            ];
            
            try {
                $db = \Config\Database::connect();
                $db->table('equipments')->where('equipment_id', $equip_id)->update($data);
                
                if ($db->affectedRows() > 0) {
                    session()->setFlashdata('success', '✅ Equipment updated successfully!');
                } else {
                    session()->setFlashdata('error', '⚠️ No changes made!');
                }
                return redirect()->to('staff/equipment');
            } catch (\Exception $e) {
                session()->setFlashdata('error', '❌ Error updating equipment: ' . $e->getMessage());
                return redirect()->back();
            }
        }
        
        return view('staff/staff-pages/edit-equipment', ['page' => 'update-equip']); 
    }

    public function removeEquipment() { 
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('staff/staff-pages/remove-equipment', ['page' => 'remove-equip']); 
    }

    // ✅ FIXED deleteEquipment - HANDLES POST DELETION
    public function deleteEquipment() { 
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        if ($this->request->getMethod() === 'post') {
            $equip_id = $this->request->getPost('equipment_id');
            
            if (!$equip_id) {
                session()->setFlashdata('error', '❌ Invalid equipment ID!');
                return redirect()->to('staff/equipment');
            }
            
            try {
                $db = \Config\Database::connect();
                $db->table('equipments')->where('equipment_id', $equip_id)->delete();
                session()->setFlashdata('success', '✅ Equipment deleted successfully!');
                return redirect()->to('staff/equipment');
            } catch (\Exception $e) {
                session()->setFlashdata('error', '❌ Error deleting equipment: ' . $e->getMessage());
                return redirect()->to('staff/equipment');
            }
        }
        
        return view('staff/staff-pages/actions/delete-equipment', ['page' => 'remove-equip']); 
    }

    public function attendance() { return view('staff/staff-pages/attendance', ['page' => 'attendance']); }

    public function checkAttendance()
    {
        $id = $this->request->getGet('id');
        if (! $id) {
            return redirect()->to('/staff/attendance');
        }

        $db = \Config\Database::connect();
        date_default_timezone_set('Asia/Kathmandu');
        $current_date = date('Y-m-d h:i A');
        $exp = explode(' ', $current_date);
        $curr_date = $exp[0];
        $curr_time = $exp[1] . ' ' . $exp[2];

        $existing = $db->query("SELECT * FROM attendance WHERE curr_date = ? AND user_id = ?", [$curr_date, $id])->getRowArray();
        if (! $existing) {
            $db->query("INSERT INTO attendance (user_id, curr_date, curr_time, present) VALUES (?, ?, ?, 1)", [$id, $curr_date, $curr_time]);
            $db->query("UPDATE members SET attendance_count = attendance_count + 1 WHERE user_id = ?", [$id]);
        }

        return redirect()->to('/staff/attendance');
    }

    public function deleteAttendance()
    {
        $id = $this->request->getGet('id');
        if (! $id) {
            return redirect()->to('/staff/attendance');
        }

        $db = \Config\Database::connect();
        $db->query("DELETE FROM attendance WHERE user_id = ?", [$id]);
        $db->query("UPDATE members SET attendance_count = GREATEST(attendance_count - 1, 0) WHERE user_id = ?", [$id]);

        return redirect()->to('/staff/attendance');
    }

    public function payment() { return view('staff/staff-pages/payment', ['page' => 'payment']); }
    public function userPayment() { return view('staff/staff-pages/user-payment', ['page' => 'payment']); }
    public function userpay() { return view('staff/staff-pages/userpay', ['page' => 'payment']); }
    public function searchResult() { return view('staff/staff-pages/search-result', ['page' => 'payment']); }
    public function sendReminder() { return view('staff/staff-pages/sendReminder', ['page' => 'payment']); }
}
?>
