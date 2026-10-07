<?php

namespace App\Http\Controllers;

use App\Models\Student;

class ParrainageController extends Controller
{
    /**
     * Affiche la liste publique des élèves pour le filtrage dynamique JS
     */
    public function index()
    {
        // On récupère la liste plate de tous les élèves actifs/en attente
        $students = Student::whereIn('status', ['active', 'pending'])
            ->ordered()
            ->get();

        // On envoie $students à la vue (c'est ce qu'attend ton filtrage JS)
        return view('pages.parrainage.index', compact('students'));
    }
}
