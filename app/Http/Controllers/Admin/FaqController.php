<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = Faq::orderBy('order')->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => Faq::count(),
            'published' => Faq::published()->count(),
            'draft' => Faq::where('is_published', false)->count(),
            'by_category' => Faq::selectRaw('category, count(*) as count')
                ->groupBy('category')
                ->pluck('count', 'category'),
        ];

        return view('admin.faq.index', compact('faqs', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = [
            'general' => 'Général',
            'membership' => 'Adhésion',
            'donation' => 'Dons',
            'activities' => 'Activités',
            'contact' => 'Contact',
        ];
        $languages = ['mg' => 'Malagasy', 'fr' => 'Français', 'en' => 'English'];

        return view('admin.faq.create', compact('categories', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|in:general,membership,donation,activities,contact',
            'order' => 'nullable|integer|min:0',

            // Au moins une question requise
            'question_fr' => 'nullable|max:500',
            'question_mg' => 'nullable|max:500',
            'question_en' => 'nullable|max:500',

            // Réponses
            'answer_fr' => 'nullable|max:5000',
            'answer_mg' => 'nullable|max:5000',
            'answer_en' => 'nullable|max:5000',

            'is_published' => 'boolean',
        ], [
            'category.required' => 'La catégorie est obligatoire.',
            'category.in' => 'Catégorie invalide.',
        ]);

        // Vérifier qu'au moins une question est fournie
        if (empty($request->question_fr) && empty($request->question_mg) && empty($request->question_en)) {
            return redirect()->back()
                ->withErrors(['question_fr' => 'Au moins une question (FR, MG ou EN) est requise.'])
                ->withInput();
        }

        DB::beginTransaction();
        try {
            Faq::create([
                'category' => $request->category,
                'order' => $request->order ?? 0,
                'question_mg' => $request->question_mg,
                'question_fr' => $request->question_fr,
                'question_en' => $request->question_en,
                'answer_mg' => $this->sanitizeHtml($request->answer_mg),
                'answer_fr' => $this->sanitizeHtml($request->answer_fr),
                'answer_en' => $this->sanitizeHtml($request->answer_en),
                'is_published' => $request->has('is_published'),
                'view_count' => 0,
            ]);

            DB::commit();

            return redirect()->route('admin.faq.index')
                ->with('success', 'FAQ ajoutée avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        return redirect()->route('admin.faq.edit', $faq->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        $categories = [
            'general' => 'Général',
            'membership' => 'Adhésion',
            'donation' => 'Dons',
            'activities' => 'Activités',
            'contact' => 'Contact',
        ];
        $languages = ['mg' => 'Malagasy', 'fr' => 'Français', 'en' => 'English'];

        return view('admin.faq.edit', compact('faq', 'categories', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'category' => 'required|in:general,membership,donation,activities,contact',
            'order' => 'nullable|integer|min:0',

            'question_fr' => 'nullable|max:500',
            'question_mg' => 'nullable|max:500',
            'question_en' => 'nullable|max:500',

            'answer_fr' => 'nullable|max:5000',
            'answer_mg' => 'nullable|max:5000',
            'answer_en' => 'nullable|max:5000',

            'is_published' => 'boolean',
        ]);

        if (empty($request->question_fr) && empty($request->question_mg) && empty($request->question_en)) {
            return redirect()->back()
                ->withErrors(['question_fr' => 'Au moins une question (FR, MG ou EN) est requise.'])
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $faq->update([
                'category' => $request->category,
                'order' => $request->order ?? $faq->order,
                'question_mg' => $request->question_mg,
                'question_fr' => $request->question_fr,
                'question_en' => $request->question_en,
                'answer_mg' => $this->sanitizeHtml($request->answer_mg),
                'answer_fr' => $this->sanitizeHtml($request->answer_fr),
                'answer_en' => $this->sanitizeHtml($request->answer_en),
                'is_published' => $request->has('is_published'),
            ]);

            DB::commit();

            return redirect()->route('admin.faq.index')
                ->with('success', 'FAQ mise à jour avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        DB::beginTransaction();
        try {
            $faq->delete();
            DB::commit();
            return redirect()->route('admin.faq.index')
                ->with('success', 'FAQ supprimée avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()]);
        }
    }

    /**
     * Sanitiser le HTML des réponses (autoriser seulement tags sûrs).
     */
    private function sanitizeHtml(?string $html): ?string
    {
        if (empty($html)) return null;

        // Autoriser seulement ces tags : ul, ol, li, p, br, strong, em, a, span
        $allowedTags = '<ul><ol><li><p><br><strong><em><a><span>';

        return strip_tags($html, $allowedTags);
    }
}
