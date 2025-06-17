<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use App\Models\Criteria;

class SawResultTable extends Table
{
    /**
     * Data source.
     * Target key from the screen's query method.
     *
     * @var string
     */
    protected $target = 'ranking'; // Targetkan data 'ranking' dari SAWProcess screen

    /**
     * @return TD[]
     */
    protected function columns(): array
    {
        // Definisikan kolom-kolom standar untuk nama alternatif dan skor
        $columns = [
            TD::make('name', 'Nama Alternatif')
                // Gunakan render() untuk mengakses 'name' dari array $item
                ->render(function ($row) {
                    return $row['name'] ?? '';
                }),

            TD::make('score', 'Skor Akhir')
                ->alignRight()
                // Mengatur perataan skor ke kanan
                ->render(function ($row) {
                    return number_format($row['score'] ?? 0, 4);
                }),

            TD::make('ranking', 'Ranking')
                ->alignCenter()
                ->render(function ($row) {
                    return $row['ranking'] ?? '';
                }),
        ];

        // Tambahkan kolom dinamis untuk setiap kriteria yang dinormalisasi
        // Ini akan menampilkan nilai normalisasi untuk setiap kriteria
        $criterias = Criteria::orderBy('id')->get(); // Ambil semua kriteria diurutkan berdasarkan ID
        foreach ($criterias as $criteria) {
            $columns[] = TD::make("normalized.{$criteria->name}", "Norm. {$criteria->name}")
                ->alignRight()
                // Mengatur perataan nilai normalisasi ke kanan
                ->render(function ($row) use ($criteria) {
                    return number_format($row['normalized'][$criteria->name] ?? 0, 4);
                });
        }

        return $columns;
    }
}
