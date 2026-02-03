<?php

namespace Config;

use CodeIgniter\Config\Services;

$routes = Services::routes();

$routes->setDefaultNamespace('App\\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// Main routes
$routes->get('/', 'Home::index');
$routes->post('login/process', 'Login::process');
$routes->get('dashboard', 'Dashboard::index');
$routes->get('index', 'Home::index');
$routes->get('index.php', 'Home::index');

// Logout
$routes->post('logout', 'Auth::logout');
$routes->get('logout', 'Auth::logout');

// ============================================================================
// COMPREHENSIVE LEGACY ROUTE SHORTCUTS - Maps all legacy .php files to controllers
// ============================================================================

$routes->get('admin/generate_qr/(:num)', 'Admin::generate_qr/$1');
$routes->get('admin/qr_scanner', 'Admin::qr_scanner');
$routes->post('admin/mark_qr_attendance', 'Admin::mark_qr_attendance');
$routes->get('admin/members', 'Admin::members');

// ADMIN - Members Section
$routes->match(['get', 'post'], 'members', 'Admin::members');
$routes->match(['get', 'post'], 'members.php', 'Admin::members');
$routes->match(['get', 'post'], 'member-entry', 'Admin::memberEntry');
$routes->match(['get', 'post'], 'member-entry.php', 'Admin::memberEntry');
$routes->match(['get', 'post'], 'add-member', 'Admin::addMember');
$routes->match(['get', 'post'], 'add-member.php', 'Admin::addMember');
$routes->match(['get', 'post'], 'add-member-req', 'Admin::addMember');
$routes->match(['get', 'post'], 'add-member-req.php', 'Admin::addMember');
$routes->match(['get', 'post'], 'edit-member', 'Admin::editMember');
$routes->match(['get', 'post'], 'edit-member.php', 'Admin::editMember');
$routes->match(['get', 'post'], 'edit-memberform', 'Admin::editMemberform');
$routes->match(['get', 'post'], 'edit-memberform.php', 'Admin::editMemberform');
$routes->match(['get', 'post'], 'edit-member-req', 'Admin::editMemberReq');
$routes->match(['get', 'post'], 'edit-member-req.php', 'Admin::editMemberReq');
$routes->match(['get', 'post'], 'delete-member', 'Admin::deleteMember');
$routes->match(['get', 'post'], 'delete-member.php', 'Admin::deleteMember');
$routes->match(['get', 'post'], 'remove-member', 'Admin::removeMember');
$routes->match(['get', 'post'], 'remove-member.php', 'Admin::removeMember');
$routes->match(['get', 'post'], 'member-status', 'Admin::memberStatus');
$routes->match(['get', 'post'], 'member-status.php', 'Admin::memberStatus');

// ADMIN - Equipment Section
$routes->match(['get', 'post'], 'equipment', 'Admin::equipment');
$routes->match(['get', 'post'], 'equipment.php', 'Admin::equipment');
$routes->match(['get', 'post'], 'equipment-entry', 'Admin::equipmentEntry');
$routes->match(['get', 'post'], 'equipment-entry.php', 'Admin::equipmentEntry');
$routes->match(['get', 'post'], 'add-equipment', 'Admin::addEquipment');
$routes->match(['get', 'post'], 'add-equipment.php', 'Admin::addEquipment');
$routes->match(['get', 'post'], 'add-equipment-req', 'Admin::addEquipment');
$routes->match(['get', 'post'], 'add-equipment-req.php', 'Admin::addEquipment');
$routes->match(['get', 'post'], 'edit-equipment', 'Admin::editEquipment');
$routes->match(['get', 'post'], 'edit-equipment.php', 'Admin::editEquipment');
$routes->match(['get', 'post'], 'edit-equipmentform', 'Admin::editEquipmentform');
$routes->match(['get', 'post'], 'edit-equipmentform.php', 'Admin::editEquipmentform');
$routes->match(['get', 'post'], 'edit-equipment-req', 'Admin::editEquipmentReq');
$routes->match(['get', 'post'], 'edit-equipment-req.php', 'Admin::editEquipmentReq');
$routes->match(['get', 'post'], 'remove-equipment', 'Admin::removeEquipment');
$routes->match(['get', 'post'], 'remove-equipment.php', 'Admin::removeEquipment');
$routes->match(['get', 'post'], 'delete-equipment', 'Admin::deleteEquipment');
$routes->match(['get', 'post'], 'delete-equipment.php', 'Admin::deleteEquipment');

// ADMIN - Attendance Section
$routes->match(['get', 'post'], 'attendance', 'Admin::attendance');
$routes->match(['get', 'post'], 'attendance.php', 'Admin::attendance');
$routes->match(['get', 'post'], 'check-attendance', 'Admin::checkAttendance');
$routes->match(['get', 'post'], 'check-attendance.php', 'Admin::checkAttendance');
$routes->match(['get', 'post'], 'delete-attendance', 'Admin::deleteAttendance');
$routes->match(['get', 'post'], 'delete-attendance.php', 'Admin::deleteAttendance');
$routes->match(['get', 'post'], 'view-attendance', 'Admin::viewAttendance');
$routes->match(['get', 'post'], 'view-attendance.php', 'Admin::viewAttendance');

// ADMIN - Reports Section
$routes->match(['get', 'post'], 'reports', 'Admin::reports');
$routes->match(['get', 'post'], 'reports.php', 'Admin::reports');
$routes->match(['get', 'post'], 'customer-progress', 'Admin::customerProgress');
$routes->match(['get', 'post'], 'customer-progress.php', 'Admin::customerProgress');
$routes->match(['get', 'post'], 'progress-report', 'Admin::progressReport');
$routes->match(['get', 'post'], 'progress-report.php', 'Admin::progressReport');
$routes->match(['get', 'post'], 'update-progress', 'Admin::updateProgress');
$routes->match(['get', 'post'], 'update-progress.php', 'Admin::updateProgress');
$routes->match(['get', 'post'], 'view-progress-report', 'Admin::viewProgressReport');
$routes->match(['get', 'post'], 'view-progress-report.php', 'Admin::viewProgressReport');
$routes->match(['get', 'post'], 'members-report', 'Admin::membersReport');
$routes->match(['get', 'post'], 'members-report.php', 'Admin::membersReport');
$routes->match(['get', 'post'], 'view-member-report', 'Admin::viewMemberReport');
$routes->match(['get', 'post'], 'view-member-report.php', 'Admin::viewMemberReport');
$routes->match(['get', 'post'], 'services-report', 'Admin::servicesReport');
$routes->match(['get', 'post'], 'services-report.php', 'Admin::servicesReport');
$routes->match(['get', 'post'], 'search-result-progress', 'Admin::searchResultProgress');
$routes->match(['get', 'post'], 'search-result-progress.php', 'Admin::searchResultProgress');

// ADMIN - Payment Section
$routes->match(['get', 'post'], 'payment', 'Admin::payment');
$routes->match(['get', 'post'], 'payment.php', 'Admin::payment');
$routes->match(['get', 'post'], 'user-payment', 'Admin::userPayment');
$routes->match(['get', 'post'], 'user-payment.php', 'Admin::userPayment');
$routes->match(['get', 'post'], 'userpay', 'Admin::userpay');
$routes->match(['get', 'post'], 'userpay.php', 'Admin::userpay');
$routes->match(['get', 'post'], 'search-result', 'Admin::searchResult');
$routes->match(['get', 'post'], 'search-result.php', 'Admin::searchResult');
$routes->match(['get', 'post'], 'sendReminder', 'Admin::sendReminder');
$routes->match(['get', 'post'], 'sendReminder.php', 'Admin::sendReminder');

// ADMIN - Announcement Section
$routes->match(['get', 'post'], 'announcement', 'Admin::announcement');
$routes->match(['get', 'post'], 'announcement.php', 'Admin::announcement');
$routes->match(['get', 'post'], 'post-announcement', 'Admin::postAnnouncement');
$routes->match(['get', 'post'], 'post-announcement.php', 'Admin::postAnnouncement');
$routes->match(['get', 'post'], 'manage-announcement', 'Admin::manageAnnouncement');
$routes->match(['get', 'post'], 'manage-announcement.php', 'Admin::manageAnnouncement');
$routes->match(['get', 'post'], 'remove-announcement', 'Admin::removeAnnouncement');
$routes->match(['get', 'post'], 'remove-announcement.php', 'Admin::removeAnnouncement');

// ADMIN - Staff Section
$routes->match(['get', 'post'], 'staffs', 'Admin::staffs');
$routes->match(['get', 'post'], 'staffs.php', 'Admin::staffs');
$routes->match(['get', 'post'], 'staffs-entry', 'Admin::staffsEntry');
$routes->match(['get', 'post'], 'staffs-entry.php', 'Admin::staffsEntry');
$routes->match(['get', 'post'], 'added-staffs', 'Admin::addedStaffs');
$routes->match(['get', 'post'], 'added-staffs.php', 'Admin::addedStaffs');
$routes->match(['get', 'post'], 'edit-staff-form', 'Admin::editStaffForm');
$routes->match(['get', 'post'], 'edit-staff-form.php', 'Admin::editStaffForm');
$routes->match(['get', 'post'], 'edit-staff-req', 'Admin::editStaffReq');
$routes->match(['get', 'post'], 'edit-staff-req.php', 'Admin::editStaffReq');
$routes->match(['get', 'post'], 'remove-staff', 'Admin::removeStaff');
$routes->match(['get', 'post'], 'remove-staff.php', 'Admin::removeStaff');

// ADMIN ROUTES - Grouped
$routes->group('admin', [], static function ($routes) {
    $routes->get('', 'Admin::index');
    $routes->get('index', 'Admin::index');
    $routes->get('members', 'Admin::members');
    $routes->get('member-entry', 'Admin::memberEntry');
    $routes->post('add-member', 'Admin::addMember');
    $routes->get('edit-member', 'Admin::editMember');
    $routes->get('edit-memberform', 'Admin::editMemberform');
    $routes->post('edit-member-req', 'Admin::editMemberReq');
    $routes->get('remove-member', 'Admin::removeMember');
    $routes->post('delete-member', 'Admin::deleteMember');
    $routes->get('member-status', 'Admin::memberStatus');
    $routes->get('equipment', 'Admin::equipment');
    $routes->get('equipment-entry', 'Admin::equipmentEntry');
    $routes->post('add-equipment', 'Admin::addEquipment');
    $routes->get('edit-equipment', 'Admin::editEquipment');
    $routes->get('edit-equipmentform', 'Admin::editEquipmentform');
    $routes->post('edit-equipment-req', 'Admin::editEquipmentReq');
    $routes->get('remove-equipment', 'Admin::removeEquipment');
    $routes->post('delete-equipment', 'Admin::deleteEquipment');
    $routes->get('attendance', 'Admin::attendance');
    $routes->post('check-attendance', 'Admin::checkAttendance');
    $routes->post('delete-attendance', 'Admin::deleteAttendance');
    $routes->get('view-attendance', 'Admin::viewAttendance');
    $routes->get('reports', 'Admin::reports');
    $routes->get('customer-progress', 'Admin::customerProgress');
    $routes->get('progress-report', 'Admin::progressReport');
    $routes->post('update-progress', 'Admin::updateProgress');
    $routes->get('view-progress-report', 'Admin::viewProgressReport');
    $routes->get('members-report', 'Admin::membersReport');
    $routes->get('view-member-report', 'Admin::viewMemberReport');
    $routes->get('services-report', 'Admin::servicesReport');
    $routes->get('payment', 'Admin::payment');
    $routes->get('user-payment', 'Admin::userPayment');
    $routes->post('userpay', 'Admin::userpay');
    $routes->post('search-result', 'Admin::searchResult');
    $routes->post('sendReminder', 'Admin::sendReminder');
    $routes->get('search-result-progress', 'Admin::searchResultProgress');
    $routes->get('announcement', 'Admin::announcement');
    $routes->post('post-announcement', 'Admin::postAnnouncement');
    $routes->get('manage-announcement', 'Admin::manageAnnouncement');
    $routes->post('remove-announcement', 'Admin::removeAnnouncement');
    $routes->get('staffs', 'Admin::staffs');
    $routes->get('staffs-entry', 'Admin::staffsEntry');
    $routes->post('added-staffs', 'Admin::addedStaffs');
    $routes->get('edit-staff-form', 'Admin::editStaffForm');
    $routes->post('edit-staff-req', 'Admin::editStaffReq');
    $routes->post('remove-staff', 'Admin::removeStaff');
});

// STAFF ROUTES
$routes->group('staff', [], static function ($routes) {
    $routes->get('', 'Staff::index');
    $routes->get('index', 'Staff::index');
    $routes->get('members', 'Staff::members');
    $routes->get('member-entry', 'Staff::memberEntry');
    $routes->post('add-member', 'Staff::addMember');
    $routes->get('edit-member', 'Staff::editMember');
    $routes->post('edit-member-req', 'Staff::editMemberReq');
    $routes->get('remove-member', 'Staff::removeMember');
    $routes->post('delete-member', 'Staff::deleteMember');
    $routes->get('member-status', 'Staff::memberStatus');
    $routes->get('equipment', 'Staff::equipment');
    $routes->get('equipment-entry', 'Staff::equipmentEntry');
    $routes->post('add-equipment', 'Staff::addEquipment');
    $routes->get('edit-equipment', 'Staff::editEquipment');
    $routes->post('edit-equipment-req', 'Staff::editEquipmentReq');
    $routes->get('remove-equipment', 'Staff::removeEquipment');
    $routes->post('delete-equipment', 'Staff::deleteEquipment');
    $routes->get('attendance', 'Staff::attendance');
    $routes->post('check-attendance', 'Staff::checkAttendance');
    $routes->post('delete-attendance', 'Staff::deleteAttendance');
    $routes->get('payment', 'Staff::payment');
    $routes->get('user-payment', 'Staff::userPayment');
    $routes->post('userpay', 'Staff::userpay');
    $routes->post('search-result', 'Staff::searchResult');
    $routes->post('sendReminder', 'Staff::sendReminder');
});

// CUSTOMER ROUTES
$routes->group('customer', [], static function ($routes) {
    $routes->get('', 'Customer::index');
    $routes->get('index', 'Customer::index');
    $routes->get('pages', 'Customer::pages');
    $routes->get('pages/index', 'Customer::pagesIndex');
    $routes->get('pages/my-report', 'Customer::myReport');
    $routes->get('pages/to-do', 'Customer::todo');
    $routes->post('pages/add-to-do', 'Customer::addTodo');
    $routes->post('pages/update-todo', 'Customer::updateTodo');
    $routes->post('pages/modified-todo', 'Customer::modifiedTodo');
    $routes->post('pages/remove-todo', 'Customer::removeTodo');
    $routes->get('pages/announcement', 'Customer::announcement');
    $routes->get('pages/customer-reminder', 'Customer::reminder');
    $routes->post('pages/register-cust', 'Customer::registerCustomer');
    // Add these routes at the BOTTOM (before closing bracket)
$routes->get('writable/qr_codes/(:any)', 'Admin::serve_qr/$1');
$routes->get('writable/(:any)', 'Admin::serve_file/$1');
// Fix old QR paths - ADD THIS LINE
$routes->get('qr_(:num)', function($id) {
    $qr_data = site_url('admin/mark_qr_attendance?user_id=' . $id);
    $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=" . urlencode($qr_data);
    return redirect()->to($qr_url);
});
// Handle old QR paths (qr_16 → live QR)
$routes->get('qr_(:num)', 'Admin::old_qr/$1');


});