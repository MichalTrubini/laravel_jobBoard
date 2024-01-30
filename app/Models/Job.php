<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    public static array $experience = ['entry', 'intermediate', 'senior'];
    public static array $category = ['IT', 'Finance', 'Sales', 'Marketing'];

    public function scopeFilter(EloquentBuilder|Builder $query, array $filters) : EloquentBuilder|Builder
    {
        return $query->when(request('search'), function($query) {
            $query->where(function($query){
                $query->where('title', 'like', '%'.request('search').'%')
                ->orWhere('description', 'like', '%'.request('search').'%');
            });
        })->when(request('min_salary'), function($query) {
            $query->where('salary', '>=', request('min_salary'));
        })->when(request('max_salary'), function($query) {
            $query->where('salary', '<=', request('max_salary'));
        })->when(request('experience'), function($query){
            $query->where('experience', request('experience'));
        })->when(request('category'), function($query){
            $query->where('category', request('category'));
        });
    }
}
