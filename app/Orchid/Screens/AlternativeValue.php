<?php

namespace App\Orchid\Screens;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\AlternativeCriteriaValue;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Matrix;

class AlternativeValue extends Screen
{
    public $name = 'Input Nilai Alternatif per Kriteria';

    public function query(): array
    {
        return [
            'alternatives' => Alternative::with('criteriaValues.criteria')->get(),
            'criterias' => Criteria::all(),
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Select::make('alternative_id')
                    ->title('Pilih Layanan Cloud')
                    ->options(Alternative::pluck('name', 'id')->toArray())
                    ->required(),

                ...Criteria::all()->map(function ($criteria) {
                    return Input::make("criteria_values.{$criteria->id}")
                        ->title("Nilai untuk {$criteria->name} ({$criteria->type})")
                        ->type('number')
                        ->step(0.01)
                        ->required();
                })->toArray(),
            ]),
        ];
    }

    public function commandBar(): array
    {
        return [
            \Orchid\Screen\Actions\Button::make('Simpan Nilai')->method('save'),
        ];
    }

    public function save(Request $request)
    {
        $alternativeId = $request->get('alternative_id');
        $values = $request->get('criteria_values');

        foreach ($values as $criteriaId => $value) {
            AlternativeCriteriaValue::updateOrCreate(
                [
                    'alternative_id' => $alternativeId,
                    'criteria_id' => $criteriaId,
                ],
                [
                    'value' => $value,
                ]
            );
        }

        Toast::info('Nilai berhasil disimpan.');
        return redirect()->route('platform.values');
    }
}

