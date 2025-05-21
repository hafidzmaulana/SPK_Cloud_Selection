<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Actions\Button;

use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaEditScreen extends Screen
{
    public $name = 'Edit Kriteria';
    public $exists = false;

    public function query(Criteria $criteria): array
    {
        $this->exists = $criteria->exists;
        $this->name = $this->exists ? 'Edit Kriteria' : 'Tambah Kriteria';

        return [
            'criteria' => $criteria,
        ];
    }

    public function commandBar(): array
    {
        return [
            Button::make('Simpan')->method('save'),
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('criteria.name')
                    ->title('Nama Kriteria')
                    ->placeholder('Contoh: Kecepatan Akses')
                    ->required(),

                Select::make('criteria.type')
                    ->title('Tipe Kriteria')
                    ->options([
                        'benefit' => 'Benefit',
                        'cost' => 'Cost',
                    ])
                    ->required(),

                Input::make('criteria.weight')
                    ->title('Bobot (%)')
                    ->type('number')
                    ->min(0)
                    ->max(100)
                    ->step(1)
                    ->required()
                    ->help('Masukkan nilai bobot antara 0 sampai 100'),
            ]),
        ];
    }

    public function save(Request $request, Criteria $criteria)
    {
        $validated = $request->validate([
            'criteria.name' => 'required|string|max:255',
            'criteria.type' => 'required|in:benefit,cost',
            'criteria.weight' => 'required|numeric|min:0|max:100',
        ]);

        $criteria->fill($validated['criteria'])->save();

        Toast::info($this->exists ? 'Kriteria diperbarui!' : 'Kriteria ditambahkan!');
        return redirect()->route('platform.criteria');
    }
}
