<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;

class HomeController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::where('is_published', true)->orderBy('created_at','desc')->get();
        return view('student.home', compact('quizzes'));
    }
}
