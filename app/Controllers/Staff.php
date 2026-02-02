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

    public function members() { return view('staff/staff-pages/members', ['page' => 'members']); }
    public function memberEntry() { return view('staff/staff-pages/member-entry', ['page' => 'members-entry']); }
    public function addMember() { return view('staff/staff-pages/add-member-req', ['page' => 'add-member']); }
    public function editMember() { return view('staff/staff-pages/edit-member', ['page' => 'members-update']); }
    public function editMemberReq() { return view('staff/staff-pages/edit-member-req', ['page' => 'members-update']); }
    public function removeMember() { return view('staff/staff-pages/remove-member', ['page' => 'members-remove']); }
    public function deleteMember() { return view('staff/staff-pages/actions/delete-member', ['page' => 'members-remove']); }
    public function memberStatus() { return view('staff/staff-pages/member-status', ['page' => 'membersts']); }

    public function equipment() { return view('staff/staff-pages/equipment', ['page' => 'list-equip']); }
    public function equipmentEntry() { return view('staff/staff-pages/equipment-entry', ['page' => 'add-equip']); }
    public function addEquipment() { return view('staff/staff-pages/add-equipment-req', ['page' => 'add-equip']); }
    public function editEquipment() { return view('staff/staff-pages/edit-equipment', ['page' => 'update-equip']); }
    public function editEquipmentReq() { return view('staff/staff-pages/edit-equipment-req', ['page' => 'update-equip']); }
    public function removeEquipment() { return view('staff/staff-pages/remove-equipment', ['page' => 'remove-equip']); }
    public function deleteEquipment() { return view('staff/staff-pages/actions/delete-equipment', ['page' => 'remove-equip']); }

    public function attendance() { return view('staff/staff-pages/attendance', ['page' => 'attendance']); }
    public function checkAttendance() { return view('staff/staff-pages/actions/check-attendance', ['page' => 'attendance']); }
    public function deleteAttendance() { return view('staff/staff-pages/actions/delete-attendance', ['page' => 'attendance']); }

    public function payment() { return view('staff/staff-pages/payment', ['page' => 'payment']); }
    public function userPayment() { return view('staff/staff-pages/user-payment', ['page' => 'payment']); }
    public function userpay() { return view('staff/staff-pages/userpay', ['page' => 'payment']); }
    public function searchResult() { return view('staff/staff-pages/search-result', ['page' => 'payment']); }
    public function sendReminder() { return view('staff/staff-pages/sendReminder', ['page' => 'payment']); }
}
?>
