<?php

namespace App\Controllers;

class Home extends BaseController
{
   // app/Controllers/Home.php
public function index()
{
    return view('index');  // Points to app/Views/index.php
}


}
