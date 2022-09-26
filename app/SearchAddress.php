<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class SearchAddress extends Model
{
    protected $table = "search_address";

    //Relation with Report table
    public function reports()
    {
        return $this->hasMany('App\Report','search_add_id');
    }

    public function search()
    {
        return $this->hasMany('App\search','PropertyFullAddress','search_name');
    }
}
