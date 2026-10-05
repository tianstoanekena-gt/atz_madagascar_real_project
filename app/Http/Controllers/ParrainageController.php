<?php

namespace App\Http\Controllers;

use App\Models\Student;

class ParrainageController extends Controller
{
    /**
     * Affiche la liste publique des élèves, groupés par niveau d'étude
     */
    public function index()
    {
        $students = Student::whereIn('status', ['active', 'pending'])
            ->ordered()
            ->get();

        $groupedStudents = $students->groupBy('education_level');

        return view('pages.parrainage.index', compact('groupedStudents'));
    }
}
