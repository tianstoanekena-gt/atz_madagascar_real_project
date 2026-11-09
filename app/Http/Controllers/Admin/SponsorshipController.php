<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsorship;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SponsorshipController extends Controller
{
    public function index(Request $request)
    {
        $query = Sponsorship::with(['student', 'godparent', 'validator']);

        // Filtres
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $sponsorships = $query->orderBy('created_at', 'desc')->paginate(15);
        $students = Student::ordered()->get();

        return view('admin.parrainage.sponsorships.index', compact('sponsorships', 'students'));
    }

    /**
     * Affiche le formulaire de création d'un parrainage (Liaison manuelle)
     */
    public function create(Request $request)
    {
        // Récupère tous les parrains et les élèves disponibles
        $godparents = \App\Models\Godparent::orderBy('last_name')->get();
        $students = \App\Models\Student::whereIn('status', ['pending', 'active'])->ordered()->get();

        // Permet de pré-sélectionner un parrain ou un élève si on vient d'une fiche dédiée
        $selectedGodparent = $request->query('godparent_id');
        $selectedStudent = $request->query('student_id');

        return view('admin.parrainage.sponsorships.create', compact('godparents', 'students', 'selectedGodparent', 'selectedStudent'));
    }

    /**
     * Enregistre la liaison Parrain <-> Élève
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'godparent_id' => ['required', 'exists:godparents,id'],
            'student_id' => ['required', 'exists:students,id'],
            'amount' => ['required', 'numeric', 'min:1000'],
            'message' => ['nullable', 'string', 'max:1000'],
        ], [
            'godparent_id.exists' => 'Le parrain sélectionné est invalide.',
            'student_id.exists' => 'L\'élève sélectionné est invalide.',
            'amount.min' => 'Le montant doit être d\'au moins 1 000 Ar.',
        ]);

        // 1. Créer le parrainage (Statut 'validated' directement car c'est l'admin qui le saisit)
        $sponsorship = Sponsorship::create([
            'godparent_id' => $validated['godparent_id'],
            'student_id' => $validated['student_id'],
            'amount' => $validated['amount'],
            'message' => $validated['message'] ?? '',
            'payment_status' => 'validated',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        // 2. Incrémenter le montant collecté de l'élève
        $sponsorship->student->increment('collected_amount', $validated['amount']);

        // 3. Vérifier si l'objectif est atteint pour changer le statut
        if ($sponsorship->student->collected_amount >= $sponsorship->student->target_amount) {
            $sponsorship->student->update(['status' => 'completed']);
        }

        return redirect()->route('admin.sponsorships.index')
            ->with('success', 'Parrainage créé et validé avec succès. Le montant a été ajouté à l\'élève.');
    }

    public function show(Sponsorship $sponsorship)
    {
        $sponsorship->load(['student', 'godparent', 'validator']);

        return view('admin.parrainage.sponsorships.show', compact('sponsorship'));
    }

    /**
     * Valider une demande de parrainage (CM)
     */
    public function approve(Sponsorship $sponsorship)
    {
        if ($sponsorship->payment_status === 'validated') {
            return redirect()->back()->with('error', 'Ce parrainage est déjà validé.');
        }

        $sponsorship->validateBy(Auth::user());

        return redirect()->back()->with('success', 'Parrainage validé avec succès. Le montant a été ajouté au total collecté de l\'élève.');
    }

    /**
     * Rejeter une demande de parrainage (CM)
     */
    public function reject(Request $request, Sponsorship $sponsorship)
    {
        if ($sponsorship->payment_status === 'rejected') {
            return redirect()->back()->with('error', 'Ce parrainage est déjà rejeté.');
        }

        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $sponsorship->rejectBy(Auth::user(), $request->reason ?? '');

        return redirect()->back()->with('success', 'Parrainage rejeté.');
    }

    /**
     * Remettre en attente (annuler validation/rejet)
     */
    public function resetStatus(Sponsorship $sponsorship)
    {
        // Si c'était validé, on doit décrémenter le montant collecté
        if ($sponsorship->payment_status === 'validated') {
            $sponsorship->student->decrement('collected_amount', $sponsorship->amount);

            // Si l'élève était passé en "completed", on le repasse en "active"
            if ($sponsorship->student->status === 'completed') {
                $sponsorship->student->update(['status' => 'active']);
            }
        }

        $sponsorship->update([
            'payment_status' => 'pending',
            'validated_by' => null,
            'validated_at' => null,
        ]);

        return redirect()->back()->with('success', 'Parrainage remis en attente.');
    }

    public function destroy(Sponsorship $sponsorship)
    {
        // Si validé, décrémenter le montant collecté
        if ($sponsorship->payment_status === 'validated') {
            $sponsorship->student->decrement('collected_amount', $sponsorship->amount);

            if ($sponsorship->student->status === 'completed') {
                $sponsorship->student->update(['status' => 'active']);
            }
        }

        // Supprimer la preuve de paiement si elle existe
        if ($sponsorship->payment_proof) {
            Storage::disk('public')->delete($sponsorship->payment_proof);
        }

        $sponsorship->delete();

        return redirect()->route('admin.sponsorships.index')
            ->with('success', 'Parrainage supprimé avec succès.');
    }
}
