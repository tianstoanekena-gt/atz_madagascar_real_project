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
