<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Alternative extends Model
{
    use AsSource;

    protected $fillable = [
        'name',
    ];

    public function criteriaValues()
    {
        return $this->hasMany(AlternativeCriteriaValue::class);
    }
}
