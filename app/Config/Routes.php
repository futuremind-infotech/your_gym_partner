<?php

namespace Config;

use CodeIgniter\Config\Services;

$routes = Services::routes();

/*
|--------------------------------------------------------------------------
| Basic Router Setup
|--------------------------------------------------------------------------
*/
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Frontend');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
$routes->get('/', 'Frontend::index');
$routes->get('about', 'Frontend::about');
$routes->get('contact', 'Frontend::contact');
$routes->get('blog', 'Frontend::blog');
$routes->get('gallery', 'Frontend::gallery');
$routes->get('pricing', 'Frontend::pricing');

/*
|--------------------------------------------------------------------------
| Admin Login Routes
|--------------------------------------------------------------------------
*/
$routes->get('login', 'Home::loginPage');
$routes->post('login/process', 'Login::process');
$routes->get('dashboard', 'Dashboard::index');

$routes->get('logout', 'Auth::logout');
$routes->post('logout', 'Auth::logout');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (🔥 FIXED)
|--------------------------------------------------------------------------
*/
$routes->group('admin', ['namespace' => 'App\Controllers'], function ($routes) {

    // Dashboard
    $routes->get('/', 'Admin::index');
    $routes->get('index', 'Admin::index');

    // ===================== MEMBERS =====================
    $routes->get('members', 'Admin::members');
    $routes->get('member-entry', 'Admin::memberEntry');
    $routes->post('add-member', 'Admin::addMember');          // ✅ FIXED
    $routes->get('edit-member', 'Admin::editMember');
    $routes->post('edit-member-req', 'Admin::editMemberReq');
    $routes->get('remove-member', 'Admin::removeMember');
    $routes->post('delete-member', 'Admin::deleteMember');
    $routes->get('member-status', 'Admin::memberStatus');

    // ===================== EQUIPMENT =====================
    $routes->get('equipment', 'Admin::equipment');
    $routes->get('equipment-entry', 'Admin::equipmentEntry');
    $routes->post('add-equipment', 'Admin::addEquipment');
    $routes->get('edit-equipment', 'Admin::editEquipment');
    $routes->get('edit-equipmentform', 'Admin::editEquipmentform');
    $routes->post('edit-equipment-req', 'Admin::editEquipmentReq');
    $routes->get('remove-equipment', 'Admin::removeEquipment');
    $routes->post('delete-equipment', 'Admin::deleteEquipment');

    // ===================== ATTENDANCE =====================
    $routes->get('attendance', 'Admin::attendance');
    $routes->get('qr-scanner', 'Admin::qr_scanner');
    $routes->get('check-attendance', 'Admin::checkAttendance');
    $routes->post('mark-qr-attendance', 'Admin::mark_qr_attendance');
    $routes->get('delete-attendance', 'Admin::deleteAttendance');
    $routes->get('view-attendance', 'Admin::viewAttendance');
    $routes->get('generate-qr/(:num)', 'Admin::generate_qr/$1');
    $routes->get('old-qr/(:num)', 'Admin::old_qr/$1');

    // ===================== REPORTS =====================
    $routes->get('reports', 'Admin::reports');
    $routes->get('customer-progress', 'Admin::customerProgress');
    $routes->get('progress-report', 'Admin::progressReport');
    $routes->post('update-progress', 'Admin::updateProgress');
    $routes->get('view-progress-report', 'Admin::viewProgressReport');
    $routes->post('search-result-progress', 'Admin::searchResultProgress');
    $routes->get('members-report', 'Admin::membersReport');
    $routes->get('view-member-report', 'Admin::viewMemberReport');
    $routes->get('services-report', 'Admin::servicesReport');

    // ===================== PAYMENT =====================
    $routes->get('payment', 'Admin::payment');
    $routes->get('user-payment', 'Admin::userPayment');
    $routes->post('userpay', 'Admin::userpay');
    $routes->get('payment-receipt', 'Admin::userpay');
    $routes->post('search-result', 'Admin::searchResult');
    $routes->post('sendReminder', 'Admin::sendReminder');

    // ===================== ANNOUNCEMENT =====================
    $routes->get('announcement', 'Admin::announcement');
    $routes->post('post-announcement', 'Admin::postAnnouncement');
    $routes->get('manage-announcement', 'Admin::manageAnnouncement');
    $routes->get('remove-announcement', 'Admin::removeAnnouncement');

    // ===================== STAFF =====================
    $routes->get('staffs', 'Admin::staffs');
    $routes->get('staffs-entry', 'Admin::staffsEntry');
    $routes->post('add-staff', 'Admin::addStaff');
    $routes->get('edit-staff-form', 'Admin::editStaffForm');
    $routes->post('edit-staff-req', 'Admin::editStaffReq');
    $routes->get('remove-staff', 'Admin::removeStaff');
    $routes->post('added-staffs', 'Admin::addedStaffs');
});

/*
|--------------------------------------------------------------------------
| STAFF ROUTES
|--------------------------------------------------------------------------
*/
$routes->group('staff', ['namespace' => 'App\Controllers'], function ($routes) {

    $routes->get('/', 'Staff::index');
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
    $routes->get('check-attendance', 'Staff::checkAttendance');
    $routes->get('delete-attendance', 'Staff::deleteAttendance');

    $routes->get('payment', 'Staff::payment');
    $routes->get('user-payment', 'Staff::userPayment');
    $routes->post('userpay', 'Staff::userpay');
    $routes->post('search-result', 'Staff::searchResult');
});

/*
|--------------------------------------------------------------------------
| CUSTOMER ROUTES
|--------------------------------------------------------------------------
*/
$routes->group('customer', ['namespace' => 'App\Controllers'], function ($routes) {

    $routes->get('/', 'Customer::index');
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
});

/* DEBUG ROUTES - NO AUTHENTICATION */
$routes->group('test-debug', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('members', 'TestDebug::members');
});

/* QUICK TEST ROUTES */
$routes->group('quick-test', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('add-member', 'QuickTest::addMember');
    $routes->get('view-members', 'QuickTest::viewMembers');
});
