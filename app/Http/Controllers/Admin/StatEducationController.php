<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatEducation;
use App\Models\StatEducationTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatEducationController extends Controller
{
    public function index()
    {
        $stats = StatEducation::with('translations')->orderBy('year', 'desc')->orderBy('order')->paginate(15);
        return view('admin.stats.education.index', compact('stats'));
    }
    public function create()
    {
        return view('admin.stats.education.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2020|max:2035',
            'value' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:20',
            'display_type' => 'required|in:progress,percentage,chart_bar',
            'icon' => 'nullable|string|max:50',
            'layout_style' => 'nullable|string|in:card,banner,highlight,wide|max:30',
            'chart_label' => 'nullable|string|max:50',
            'percentage_value' => 'nullable|numeric|min:0|max:100',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
            'label_fr' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $stat = StatEducation::create([
                'year' => $request->year,
                'value' => $request->value,
                'unit' => $request->unit,
                'display_type' => $request->display_type,
                'icon' => $request->icon,
                'layout_style' => $request->layout_style,
                'chart_label' => $request->chart_label,
                'percentage_value' => $request->percentage_value,
                'order' => $request->order ?? 0,
                'is_published' => $request->has('is_published'),
            ]);
            foreach (['fr', 'mg', 'en'] as $locale) {
                if ($request->filled("label_{$locale}")) {
                    StatEducationTranslation::create([
                        'stat_education_id' => $stat->id,
                        'locale' => $locale,
                        'label' => $request->input("label_{$locale}"),
                        'trend' => $request->input("trend_{$locale}"),
                        'detail' => $request->input("detail_{$locale}"),
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('admin.stats.education.index')->with('success', 'Statistique éducation ajoutée !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur : ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(StatEducation $statEducation)
    {
        $statEducation->load('translations');
        return view('admin.stats.education.edit', compact('statEducation'));
    }

    public function update(Request $request, StatEducation $statEducation)
    {
        $request->validate([
            'year' => 'required|integer|min:2020|max:2035',
            'value' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:20',
            'display_type' => 'required|in:progress,percentage,chart_bar',
            'icon' => 'nullable|string|max:50',
            'layout_style' => 'nullable|string|in:card,banner,highlight,wide|max:30',
            'chart_label' => 'nullable|string|max:50',
            'percentage_value' => 'nullable|numeric|min:0|max:100',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
            'label_fr' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $statEducation->update([
                'year' => $request->year,
                'value' => $request->value,
                'unit' => $request->unit,
                'display_type' => $request->display_type,
                'icon' => $request->icon,
                'layout_style' => $request->layout_style,
                'chart_label' => $request->chart_label,
                'percentage_value' => $request->percentage_value,
                'order' => $request->order ?? 0,
                'is_published' => $request->has('is_published'),
            ]);
            foreach (['fr', 'mg', 'en'] as $locale) {
                $statEducation->translations()->updateOrCreate(
                    ['locale' => $locale],
                    [
                        'label' => $request->input("label_{$locale}"),
                        'trend' => $request->input("trend_{$locale}"),
                        'detail' => $request->input("detail_{$locale}"),
                    ]
                );
            }
            DB::commit();
            return redirect()->route('admin.stats.education.index')->with('success', 'Statistique éducation mise à jour !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur : ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(StatEducation $statEducation)
    {
        $statEducation->delete();
        return redirect()->route('admin.stats.education.index')->with('success', 'Statistique supprimée !');
    }
}
