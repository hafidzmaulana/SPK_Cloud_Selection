<?php

namespace App\Orchid\Screens;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\AlternativeCriteriaValue;
use Illuminate\Support\Collection;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Illuminate\Support\Arr;
use stdClass;
use App\Orchid\Layouts\SawResultTable;

class SAWProcess extends Screen
{
    public $name = 'Hasil Perhitungan SAW';

    public function query(): array
    {
        $criterias = Criteria::all();
        $alternatives = Alternative::with('criteriaValues')->get();

        $normalized = [];
        $scores = [];

        // Persiapan nilai min/max tiap kriteria
        $minMax = [];
        foreach ($criterias as $criteria) {
            $values = AlternativeCriteriaValue::where('criteria_id', $criteria->id)->pluck('value');
            $minMax[$criteria->id] = [
                'min' => $values->min(),
                'max' => $values->max(),
            ];
        }

        // Normalisasi & hitung skor
        foreach ($alternatives as $alt) {
            $total = 0;
            $normData = [];

            foreach ($criterias as $criteria) {
                $val = $alt->criteriaValues->where('criteria_id', $criteria->id)->first()?->value ?? 0;

                if ($criteria->type === 'benefit') {
                    $norm = $val / ($minMax[$criteria->id]['max'] ?: 1);
                } else {
                    $norm = ($minMax[$criteria->id]['min'] ?: 1) / ($val ?: 1);
                }

                $normData[$criteria->name] = round($norm, 4);
                $total += $normData[$criteria->name] * $criteria->weight;
            }

            $normalized[] = [
                'name' => $alt->name,
                'normalized' => $normData,
                'score' => round($total, 4),
            ];

            $scores[$alt->name] = round($total, 4);
        }

        // Ranking
        $ranking = collect($normalized)->sortByDesc('score')->values();
          
        return [
            'ranking' => collect($ranking),
        ];
    }

    public function layout(): array
    {
        return [
            SawResultTable::class,
        ];
    }
}
