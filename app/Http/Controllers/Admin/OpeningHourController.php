<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OpeningHour;
use Illuminate\Http\Request;

class OpeningHourController extends Controller
{
    public function index()
    {
        $hours = OpeningHour::orderBy('order')->get();

        if ($hours->isEmpty()) {
            $this->seedDefaultDays();
            $hours = OpeningHour::orderBy('order')->get();
        }

        return view('admin.contact.opening-hours.index', compact('hours'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hours' => 'required|array',
            'hours.*.open_time' => 'nullable|date_format:H:i',
            'hours.*.close_time' => 'nullable|date_format:H:i',
            'hours.*.is_closed' => 'boolean',
        ]);

        foreach ($request->hours as $id => $data) {
            $hour = OpeningHour::find($id);
            if (!$hour) continue;

            $hour->update([
                'open_time' => !empty($data['is_closed']) ? null : ($data['open_time'] ?? null),
                'close_time' => !empty($data['is_closed']) ? null : ($data['close_time'] ?? null),
                'is_closed' => !empty($data['is_closed']),
            ]);
        }

        return redirect()->route('admin.contact.opening-hours.index')
            ->with('success', 'Horaires mis à jour avec succès !');
    }

    private function seedDefaultDays()
    {
        $days = [
            ['day' => 'Lundi', 'order' => 1],
            ['day' => 'Mardi', 'order' => 2],
            ['day' => 'Mercredi', 'order' => 3],
            ['day' => 'Jeudi', 'order' => 4],
            ['day' => 'Vendredi', 'order' => 5],
            ['day' => 'Samedi', 'order' => 6],
            ['day' => 'Dimanche', 'order' => 7],
        ];

        foreach ($days as $d) {
            OpeningHour::create([
                'day' => $d['day'],
                'open_time' => $d['order'] <= 5 ? '08:00' : null,
                'close_time' => $d['order'] <= 5 ? '17:00' : null,
                'is_closed' => $d['order'] > 5,
                'order' => $d['order'],
            ]);
        }
    }
}
