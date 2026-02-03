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

    public function members() { return view('admin/members', ['page' => 'members']); }
    public function memberEntry() { return view('admin/member-entry', ['page' => 'members-entry']); }
    public function addMember() { return view('admin/add-member-req', ['page' => 'add-member']); }
    public function editMember() { return view('admin/edit-member', ['page' => 'members-update']); }
    public function editMemberform() { return view('admin/edit-memberform', ['page' => 'members-update']); }
    public function editMemberReq() { return view('admin/edit-member-req', ['page' => 'members-update']); }
    public function removeMember() { return view('admin/remove-member', ['page' => 'members-remove']); }
    public function deleteMember() { return view('admin/actions/delete-member', ['page' => 'members-remove']); }
    public function memberStatus() { return view('admin/member-status', ['page' => 'member-status']); }

    public function equipment() { return view('admin/equipment', ['page' => 'list-equip']); }
    public function equipmentEntry() { return view('admin/equipment-entry', ['page' => 'add-equip']); }
    public function addEquipment() { return view('admin/add-equipment-req', ['page' => 'add-equip']); }
    public function editEquipment() { return view('admin/edit-equipment', ['page' => 'update-equip']); }
    public function editEquipmentform() { return view('admin/edit-equipmentform', ['page' => 'update-equip']); }
    public function editEquipmentReq() { return view('admin/edit-equipment-req', ['page' => 'update-equip']); }
    public function removeEquipment() { return view('admin/remove-equipment', ['page' => 'remove-equip']); }
    public function deleteEquipment() { return view('admin/actions/delete-equipment', ['page' => 'remove-equip']); }

    public function attendance() { return view('admin/attendance', ['page' => 'attendance']); }

    public function checkAttendance()
    {
        $id = $this->request->getGet('id');
        if (! $id) {
            return redirect()->to('/admin/attendance');
        }

        $db = \Config\Database::connect();
        date_default_timezone_set('Asia/Kathmandu');
        $current_date = date('Y-m-d h:i A');
        $exp = explode(' ', $current_date);
        $curr_date = $exp[0];
        $curr_time = $exp[1] . ' ' . $exp[2];

        // Prevent duplicate check-in for same date
        $existing = $db->query("SELECT * FROM attendance WHERE curr_date = ? AND user_id = ?", [$curr_date, $id])->getRowArray();
        if (! $existing) {
            $db->query("INSERT INTO attendance (user_id, curr_date, curr_time, present) VALUES (?, ?, ?, 1)", [$id, $curr_date, $curr_time]);
            $db->query("UPDATE members SET attendance_count = attendance_count + 1 WHERE user_id = ?", [$id]);
        }

        return redirect()->to('/admin/attendance');
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
    public function userpay() { return view('admin/userpay', ['page' => 'payment']); }
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
