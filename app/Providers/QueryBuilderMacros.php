<?php

namespace App\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;

class QueryBuilderMacros extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //adding new reorder function to a Query Builder to use reorder instead of main orderBy
        Builder::macro('reorder', function() {
            $property = $this->unions ? 'unionOrders' : 'orders';

            $this->{$property} = null;

            if (func_num_args() > 0) {
                return $this->orderBy(...func_get_args());
            }

            return $this;
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
