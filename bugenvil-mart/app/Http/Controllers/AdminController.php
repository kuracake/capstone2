<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Halaman Dashboard
    // Ubah nama method dari 'dashboard' ke 'index' agar cocok dengan route
    public function index()
    {
        return view('admin.dashboard');
    }
}