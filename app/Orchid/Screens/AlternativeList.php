<?php

namespace App\Orchid\Screens;

use App\Models\Alternative;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;

class AlternativeList extends Screen
{
    public $name = 'Manajemen Layanan Cloud';

    public function query(): array
    {
        return [
            'alternatives' => Alternative::all(),
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('Tambah Layanan')
                ->route('platform.alternatives.edit')
                ->icon('plus'),
        ];
    }

    public function layout(): array
    {
        return [
            Layout::table('alternatives', [
                TD::make('name', 'Nama Layanan'),
                TD::make('created_at', 'Ditambahkan')->render(fn($alt) => $alt->created_at->format('d M Y')),
                TD::make('Aksi')
                    ->render(fn($alt) => Group::make([
                        Link::make('Edit')
                            ->route('platform.alternatives.edit', $alt->id)
                            ->icon('pencil'),

                        Button::make('Hapus')
                            ->method('remove')
                            ->parameters(['id' => $alt->id])
                            ->confirm('Yakin ingin menghapus layanan ini?')
                            ->icon('trash'),
                    ])),
            ]),
        ];
    }

    public function remove(Request $request)
    {
        Alternative::findOrFail($request->get('id'))->delete();
        alert()->success('Layanan berhasil dihapus!');
        return redirect()->route('platform.alternatives');
    }
}

