<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatNutrition;
use App\Models\StatNutritionTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatNutritionController extends Controller
{
    public function index()
    {
        $stats = StatNutrition::with('translations')->orderBy('year', 'desc')->orderBy('order')->paginate(15);
        return view('admin.stats.nutrition.index', compact('stats'));
    }
    public function create()
    {
        return view('admin.stats.nutrition.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2020|max:2035',
            'value' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:20',
            'display_type' => 'required|in:counter',
            'icon' => 'nullable|string|max:50',
            'layout_style' => 'nullable|string|in:card,banner,highlight,wide|max:30',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
            'label_fr' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $stat = StatNutrition::create([
                'year' => $request->year,
                'value' => $request->value,
                'unit' => $request->unit,
                'display_type' => $request->display_type,
                'icon' => $request->icon,
                'layout_style' => $request->layout_style,
                'order' => $request->order ?? 0,
                'is_published' => $request->has('is_published'),
            ]);
            foreach (['fr', 'mg', 'en'] as $locale) {
                if ($request->filled("label_{$locale}")) {
                    StatNutritionTranslation::create([
                        'stat_nutrition_id' => $stat->id,
                        'locale' => $locale,
                        'label' => $request->input("label_{$locale}"),
                        'trend' => $request->input("trend_{$locale}"),
                        'detail' => $request->input("detail_{$locale}"),
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('admin.stats.nutrition.index')->with('success', 'Statistique nutrition ajoutée !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur : ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(StatNutrition $statNutrition)
    {
        $statNutrition->load('translations');
        return view('admin.stats.nutrition.edit', compact('statNutrition'));
    }

    public function update(Request $request, StatNutrition $statNutrition)
    {
        $request->validate([
            'year' => 'required|integer|min:2020|max:2035',
            'value' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:20',
            'display_type' => 'required|in:counter',
            'icon' => 'nullable|string|max:50',
            'layout_style' => 'nullable|string|in:card,banner,highlight,wide|max:30',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
            'label_fr' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $statNutrition->update([
                'year' => $request->year,
                'value' => $request->value,
                'unit' => $request->unit,
                'display_type' => $request->display_type,
                'icon' => $request->icon,
                'layout_style' => $request->layout_style,
                'order' => $request->order ?? 0,
                'is_published' => $request->has('is_published'),
            ]);
            foreach (['fr', 'mg', 'en'] as $locale) {
                $statNutrition->translations()->updateOrCreate(
                    ['locale' => $locale],
                    [
                        'label' => $request->input("label_{$locale}"),
                        'trend' => $request->input("trend_{$locale}"),
                        'detail' => $request->input("detail_{$locale}"),
                    ]
                );
            }
            DB::commit();
            return redirect()->route('admin.stats.nutrition.index')->with('success', 'Statistique nutrition mise à jour !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur : ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(StatNutrition $statNutrition)
    {
        $statNutrition->delete();
        return redirect()->route('admin.stats.nutrition.index')->with('success', 'Statistique supprimée !');
    }
}
