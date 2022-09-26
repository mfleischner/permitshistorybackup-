<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use App\states;

class PermitRequest extends Model
{
    // use SoftDeletes;

    protected $table = 'permit_requests';

    protected $append = ['state_name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'mobile',
        'purchase_with_in',
        'property_house_no_prefix',
        'property_house_no_suffix',
        'description',
        'property_city',
        'property_state',
        'property_direction',
        'property_house_no',
        'property_street_name',
        'property_zip_code',
        'purchase_with_in',
        'email',
        'description',
        'payment_id',
        'price_id',
        'user_id',
        'status',
        'permit_req_file_id',
    ];

    // protected $appends =  ['status'];

    public function getStatusAttribute($value)
    {
        switch (@$this->attributes['status']) {
            case 0:
                return "Not Started";
            case 1:
                return "Pending";
            case 2:
                return "In Review";
            case 3:
                return "Completed";
        }
    }

    public function getStatusClassAttribute($value)
    {
        switch (@$this->attributes['status']) {
            case 0:
                return "warning";
            case 1:
                return "primary";
            case 2:
                return "success";
        }
    }

    public function setStatusAttribute($value)
    {
        if ($value == 'Not Started')
            $this->attributes['status'] = '0';

        if ($value == 'Pending')
            $this->attributes['status'] = '1';

        if ($value == 'In Review')
            $this->attributes['status'] = '2';

        if ($value == 'Completed')
            $this->attributes['status'] = '3';

    }


    public function getStateNameAttribute($value)
    {
        $data = States::select('name')->where('code', $this->attributes['property_state'])->first();
        return $data['name'] ?? $this->attributes['property_state'];
    }
}
