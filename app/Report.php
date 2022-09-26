<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Report extends Model
{
    protected $table = "report";


    //Relation with Search table
    public function search()
    {
        return $this->belongsTo('App\Search','search_id');
    }
    
    //Relation with SearchAddress table
    public function search_address()
    {
        return $this->belongsTo('App\SearchAddress','search_add_id');
    }
    
}
