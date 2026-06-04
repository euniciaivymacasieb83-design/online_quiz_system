<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'teacher') {
            return redirect()->route('quizzes.index');
        }

        if (auth()->user()->role === 'student') {
            return redirect()->route('quizzes.available');
        }

        return view('dashboard');
    }
}