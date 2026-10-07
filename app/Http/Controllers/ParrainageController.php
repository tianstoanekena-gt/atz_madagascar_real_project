<?php

namespace App\Http\Controllers;

use App\Models\Student;

class ParrainageController extends Controller
{
    public function index()
    {
        $students = Student::whereIn('status', ['active', 'pending'])
            ->ordered()
            ->get();

        $groupedStudents = $students->groupBy('education_level');

        return view('pages.parrainage.index', compact('groupedStudents'));
    }
}
