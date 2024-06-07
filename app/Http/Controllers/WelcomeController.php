<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class WelcomeController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
        'title' => 'Selamat Datang',
        'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';
        $activeSubMenu = '';

        return view('welcome', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'activeSubMenu' => $activeSubMenu]);
    }
}
