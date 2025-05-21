<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Criteria extends Model
{
    use AsSource;

    protected $fillable = [
        'name',
        'type',
        'weight',
    ];

    protected $casts = [
        'weight' => 'float'
    ];

    public function alternativeValues()
    {
        return $this->hasMany(AlternativeCriteriaValue::class);
    }
}