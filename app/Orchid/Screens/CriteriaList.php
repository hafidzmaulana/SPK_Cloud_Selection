<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;

use App\Models\Criteria;
use Orchid\Screen\Fields\Group;
use Illuminate\Http\Request;

class CriteriaList extends Screen
{
    public $name = 'Manajemen Kriteria';

    public function query(): array
    {
        return [
            'criterias' => Criteria::all(),
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('Tambah Kriteria')->route('platform.criteria.edit'),
        ];
    }

    public function layout(): array
    {
        return [
            Layout::table('criterias', [
                TD::make('name', 'Nama'),
                TD::make('type', 'Tipe'),
                TD::make('weight', 'Bobot (%)'),
                TD::make('Aksi')
                    ->render(fn ($criteria) => Group::make([
                        Link::make('Edit')
                            ->route('platform.criteria.edit', $criteria->id)
                            ->icon('pencil'),
                        Button::make('Hapus')
                            ->method('remove')
                            ->confirm('Yakin ingin menghapus?')
                            ->parameters(['id' => $criteria->id])
                            ->icon('trash'),
                    ])),
            ]),
        ];
    }

    public function remove(Request $request)
    {
        Criteria::findOrFail($request->get('id'))->delete();

        \Orchid\Support\Facades\Alert::info('Kriteria dihapus');
        return redirect()->route('platform.criteria');
    }
}

