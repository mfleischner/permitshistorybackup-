<?php
namespace App\Http\Controllers\Voyager;

use DB;
use Exception;
use App\Jobs\PermitImportData;
use App\Jobs\ReadCsvFile;
use App\Libraries\ChunkReadFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\PermitRequest;
use App\Mail\PermitRequestApproveNotifyMail;
use Illuminate\Support\Facades\Mail;
use Redirect;
use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;
use TCG\Voyager\Http\Controllers\VoyagerBaseController as BaseVoyagerBaseController;

class PermitRequestMailController extends BaseVoyagerBaseController
{
    public function update(Request $request, $id)
    {
        $permit = PermitRequest::find($id);
        $permit->first_name = $request->input('first_name');
        $permit->last_name = $request->input('last_name');
        $permit->property_street_name = $request->input('property_street_name');
        $permit->property_city = $request->input('property_city');
        $permit->property_state = $request->input('property_state');
        $value = $request->input('status');
        $status =0;
        if ($value == 'Not Started')
        {
            $status = '0';
        } 
        else if ($value == 'Pending')
        {
            $status = '1';
        } 
        else if ($value == 'In Review')
        {
            $status = '2';
        } else if ($value == 'Completed')
        {
            $status = '3';
        }
        $permit->status = $status;
        $permit->permit_req_file_id = $request->input('permit_req_file_id');
        $permit->flag = $request->input('flag');
        $permit->save();

        if($permit->status == 'Completed')
        {
            \Mail::to($permit->email_address)->send(new PermitRequestApproveNotifyMail($permit));
        }
        return Redirect::to('admin/permit-requests');
    }
}
