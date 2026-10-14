<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::ordered()->get();
        return view('admin.parrainage.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.parrainage.students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZÀ-ÿ\s\'\-]+$/u'],
            'last_name' => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZÀ-ÿ\s\'\-]+$/u'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:M,F'],
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'location' => ['required', 'string', 'max:150'],
            'whatsapp' => ['nullable', 'regex:/^\+?[0-9]{10,15}$/'],
            'education_level' => ['required', 'in:primaire,college,lycee,superieur,formation_pro'],
            'description' => ['required', 'string', 'min:20', 'max:2000'],
            'description_mg' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'needs_mg' => ['nullable', 'string'],
            'needs_en' => ['nullable', 'string'],
            'needs' => ['required', 'string', 'min:10', 'max:1000'],
            'target_amount' => ['required', 'numeric', 'min:10000', 'max:100000000'],
            'status' => ['required', 'in:pending,active,completed'],
            'is_featured' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'first_name.regex' => 'Le prénom ne doit contenir que des lettres, espaces, apostrophes ou tirets.',
            'last_name.regex' => 'Le nom ne doit contenir que des lettres, espaces, apostrophes ou tirets.',
            'birth_date.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',
            'whatsapp.regex' => 'Le numéro WhatsApp doit être au format international (ex: +261341234567).',
            'description.min' => 'La description doit contenir au moins 20 caractères.',
            'target_amount.min' => 'L\'objectif doit être d\'au moins 10 000 Ar.',
        ]);

        // Upload de la photo
        $validated['photo'] = $request->file('photo')->store('students', 'public');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['order'] = $request->order ?? 0;

        Student::create($validated);

        //dd($request->all());

        return redirect()->route('admin.students.index')
            ->with('success', 'Élève ajouté avec succès.');
    }

    public function edit(Student $student)
    {
        return view('admin.parrainage.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZÀ-ÿ\s\'\-]+$/u'],
            'last_name' => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZÀ-ÿ\s\'\-]+$/u'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:M,F'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'location' => ['required', 'string', 'max:150'],
            'whatsapp' => ['nullable', 'regex:/^\+?[0-9]{10,15}$/'],
            'education_level' => ['required', 'in:primaire,college,lycee,superieur,formation_pro'],
            'description' => ['required', 'string', 'min:20', 'max:2000'],
            'description_mg' => ['nullable', 'string'],       // ✅ AJOUTÉ
            'description_en' => ['nullable', 'string'],       // ✅ AJOUTÉ
            'needs' => ['required', 'string', 'min:10', 'max:1000'],
            'needs_mg' => ['nullable', 'string'],             // ✅ AJOUTÉ
            'needs_en' => ['nullable', 'string'],             // ✅ AJOUTÉ
            'target_amount' => ['required', 'numeric', 'min:10000', 'max:100000000'],
            'status' => ['required', 'in:pending,active,completed'],
            'is_featured' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        $updateData = $validated;
        $updateData['is_featured'] = $request->has('is_featured');
        $updateData['order'] = $request->order ?? 0;

        // Si nouvelle photo uploadée
        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $updateData['photo'] = $request->file('photo')->store('students', 'public');
        }

        $student->update($updateData);

        return redirect()->route('admin.students.index')
            ->with('success', 'Élève mis à jour avec succès.');
    }
    public function destroy(Student $student)
    {
        // Vérifier s'il y a des sponsorships en cours
        if ($student->sponsorships()->where('payment_status', 'pending')->exists()) {
            return redirect()->route('admin.students.index')
                ->with('error', 'Impossible de supprimer cet élève : il a des demandes de parrainage en attente.');
        }

        // Supprimer la photo
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }

        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Élève supprimé avec succès.');
    }
}
