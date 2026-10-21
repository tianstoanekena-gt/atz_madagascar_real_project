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

    /**
     * Affiche la page de détails publique d'un élève
     */
    public function show($locale = null, $studentId = null)
    {
        // MÉTHODE 100% SÉCURISÉE : 
        // On récupère le paramètre par son NOM dans la route, 
        // peu importe l'ordre ou les changements futurs d'URL.
        $id = request()->route('studentId') ?? $studentId;

        // On récupère l'élève (findOrFail gère automatiquement le 404 si l'ID n'existe pas)
        $student = \App\Models\Student::findOrFail($id);

        return view('pages.parrainage.show', compact('student'));
    }
}
