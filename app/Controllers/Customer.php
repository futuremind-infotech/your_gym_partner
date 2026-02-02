<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class Customer extends BaseController
{
    public function index()
    {
        return view('customer/index', ['page' => 'login']);
    }

    public function pages() { return view('customer/pages/index', ['page' => 'dashboard']); }
    public function pagesIndex() { return view('customer/pages/index', ['page' => 'dashboard']); }
    public function myReport() { return view('customer/pages/my-report', ['page' => 'report']); }
    public function todo() { return view('customer/pages/to-do', ['page' => 'todo']); }
    public function addTodo() { return view('customer/pages/add-to-do', ['page' => 'todo']); }
    public function updateTodo() { return view('customer/pages/update-todo', ['page' => 'todo']); }
    public function modifiedTodo() { return view('customer/pages/actions/modified-todo', ['page' => 'todo']); }
    public function removeTodo() { return view('customer/pages/actions/remove-todo', ['page' => 'todo']); }
    public function announcement() { return view('customer/pages/announcement', ['page' => 'announcement']); }
    public function reminder() { return view('customer/pages/customer-reminder', ['page' => 'reminder']); }
    public function registerCustomer() { return view('customer/pages/register-cust', ['page' => 'register']); }
}
?>
