// app/Filters/Filter.php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    public function apply(Builder $builder, $value)
    {
        return $this->applyFilter($builder, $value);
    }

    protected abstract function applyFilter(Builder $builder, $value);
}
