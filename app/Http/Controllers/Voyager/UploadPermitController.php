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
use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;
use TCG\Voyager\Http\Controllers\VoyagerBaseController as BaseVoyagerBaseController;

class UploadPermitController extends BaseVoyagerBaseController
{
    use BreadRelationshipParser;

    public function store(Request $request)
    {
        try {
            $slug = $this->getSlug($request);
            $file = $request->file('filename');
            $imgrealpath = $file[0]->getClientOriginalName();
            $filename = pathinfo($imgrealpath, PATHINFO_FILENAME);
            $extension = pathinfo($imgrealpath, PATHINFO_EXTENSION);
            $uploadFileName = uniqid().'.'.$extension; 
            $valid = ['xlsx', 'xls', 'xlsb','csv'];
            if (in_array($extension, $valid)) {
                DB::table('pemit_data_upload')->insertGetId(['filename' => $imgrealpath]);

                $path = Storage::disk('local')->putFileAs('/permitdata', $request->file('filename')[0], $uploadFileName);   
                $inputFileName = Storage::path($path);
                dispatch(new ReadCsvFile($inputFileName,$extension));

                return redirect()->back()->withSuccess('Successfully uploaded Excel and Data uploading is inprogress, it will take some time...');
            } else {
                return redirect()->back()->withFail('Invalid file extension');
            }
        } catch (Exception $e) {
            return redirect()->back()->withFail('Failed to Upload file');
        }
    }

    function containsOnlyNull($array)
    {
        return empty(array_filter($array, function ($a) { return $a !== null;}));
    }
}
