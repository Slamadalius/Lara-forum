<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    protected $request, $builder;

    //protected $filters array which specifies possible filters
    protected $filters = ['by', 'popular'];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        //loop through array from getFilters method e.g. ("by"=>"username") $filter = "by", $value = "username"
        foreach ($this->getFilters() as $filter => $value) {
            //check if this class has a method called e.g. "by"
            if(method_exists($this, $filter)) {
                //if it does, call that function with a value of the getFilters() array. e.g. by(username)
                $this->$filter($value);
            }
        }

        
        //returning the query builder
        return $this->builder;
    }

    public function getFilters()
    {
        //this return only filters from the request that are specified in $filters array -> "by"=>"username"
        return $this->request->only($this->filters);
    }
}