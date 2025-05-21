<?php

namespace App\Orchid\Screens;

use App\Models\Alternative;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Actions\Button;

class AlternativeEdit extends Screen
{
    public $name = 'Edit Layanan Cloud';
    public $exists = false;

    public function query(Alternative $alternative): array
    {
        $this->exists = $alternative->exists;

        if ($this->exists) {
            $this->name = 'Edit Layanan Cloud';
        }

        return ['alternative' => $alternative];
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
                Input::make('alternative.name')
                    ->title('Nama Layanan Cloud')
                    ->required(),
            ]),
        ];
    }

    public function save(Request $request, Alternative $alternative)
    {
        $alternative->fill($request->get('alternative'))->save();
        Toast::info('Layanan berhasil disimpan!');
        return redirect()->route('platform.alternatives');
    }
}
