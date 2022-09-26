<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Search extends Model
{
    protected $table = "search";

    // public function getPermitStatusAttribute($value)
    // {
    //     switch (@$this->attributes['PermitStatus']) {
    //         case 'closed':
    //             return "complete";
    //         case 'Closed':
    //             return "complete";

    //     }
    // }
}
