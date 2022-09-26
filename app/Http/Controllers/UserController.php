<?php

namespace App\Http\Controllers;
use App\Admin;
use App\Mail\PermitRequestMail;
use App\Models\User;
use App\PermitRequest;
use App\Search;
use App\SearchAddress;
use App\Jobs\PermitImportDataReport;
use App\Jobs\ReadCsvFileReport;
use App\Libraries\ChunkReadFilter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\File;
use Auth;
use Crypt;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PDF;
use Twilio\Rest\Client;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function creditRem()
    {
        $payment = DB::table('payment')->where('user_id', Auth::guard('web')->user()->id)->offset(0)->limit(1)->orderBy('id', 'DESC')->get();
        if (!$payment->isEmpty()) {
            $today = date("Y-m-d");
            $expire = date("Y-m-d", strtotime("+1 month", strtotime($payment[0]->created_at)));
            if ($today < $expire) {

                $myReportPrimeReport = DB::table('permit_requests')->where('user_id', Auth::guard('web')->user()->id)->whereIn('status', [0, 1])->where('payment_id', $payment[0]->id)->get()->count();

                $myReportSearchAddress = DB::table('search_address')->where('user_id', Auth::guard('web')->user()->id)->whereNotIn('alarm', [-1])->where('payment_id', $payment[0]->id)->get()->count();

                $report = $myReportSearchAddress + $myReportPrimeReport;
                $price = DB::table('pricing')->where('id', $payment[0]->price_id)->offset(0)->limit(1)->orderBy('id', 'DESC')->get();

                if (!$price->isEmpty()) {
                    $reportt = explode(' ', $price[0]->report);
                    if ($reportt[0] == 'Unlimited') {
                        $reportt[0] = '10000';
                    }
                    $rem = $reportt[0] - $report;
                    \Session::put('usePermit', ($rem < 0 ? 0 : $rem));
                } else {
                    \Session::put('usePermit', 0);
                }

            } else {
                \Session::put('usePermit', 0);
            }
        } else {
            \Session::put('usePermit', 0);
        }
    }

    public function index()
    {
        $user = Auth::guard('web')->user();
        $this->creditRem();
        \Session::forget(['loginPOPUP', 'forgetPass']);
        return view('dashboard.my-report');
    }

    public function getPermitRequestData()
    {
        $user = Auth::guard('web')->user();
        $this->creditRem();
        \Session::forget(['loginPOPUP', 'forgetPass']);
        $report = PermitRequest::where('user_id', $user->id)->get();
        return view('dashboard.permit-request')->with('report', $report);
    }

    public function printPermitRequestData($status, $ids = null)
    {
        if ($status != 3 && $ids != null) {
            $report = PermitRequest::where('status', $status)->whereIn('id', explode(',', $ids))->get();
        }
        if ($status == 4 && $ids != null) {
            $report = PermitRequest::whereIn('id', explode(',', $ids))->get();
        } elseif ($status != 3 && $ids == null) {
            $report = PermitRequest::where('status', $status)->get();
        } else {
            $report = PermitRequest::get();
            //dd($array);
        }
        if (count($report) == 0) {
            return redirect(url()->previous());
        }

        $data = [
            // 'streetName' => $name,
            'array' => $report,
        ];
        $pdf = \PDF::loadView('pdf/permitRequestsPdf', $data);
        //return $pdf->stream('permit');
        return $pdf->stream('permitsearch-' . date("Y-m-d h:i:sa") . '.pdf');
    }

    public function tableResult(Request $request)
    {
        $user = Auth::guard('web')->user();
        $this->creditRem();
        $search = \Session::get('search') ?? [];
        \Session::put('search-new', $search);
        if (isset($search)) {
            foreach ($search as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $key1 => $value1) {
                        $report = DB::table('search_address')->where('user_id', $user->id)->where('search_name', $value1->PropertyFullAddress)->get();
                        if (!$report->isEmpty()) {
                            foreach ($report as $key3 => $value3) {
                                if ($value3->alarm == 1) {
                                    $value1->alarm = 'yes';
                                } else {
                                    $value1->alarm = 'no';
                                }
                            }
                            $click = 'yes';
                            \Session::put('viewReportPopUp', $click);
                        } else {
                            \Session::forget('viewReportPopUp');
                            $value1->alarm = 'no';
                        }
                    }
                }
            }
        }
        return view('dashboard.table-view-report')->with(['data' => $search, 'searchQuery'=> \Session::get('search') ]);
    }

    public function addUserReportSesion($name = null)
    {
        $user = Auth::guard('web')->user();
        $report_data = DB::table('search_address')->where('user_id', $user->id)->where('search_name', $name)->get();
        $payment = DB::table('payment')->where('user_id', $user->id)->offset(0)->limit(1)->orderBy('id', 'DESC')->get();
        if (!$payment->isEmpty()) {
            $price = DB::table('pricing')->where('id', $payment[0]->price_id)->get();
            if ($report_data->isEmpty()) {
                $date = date('Y-m-d H:i:s', strtotime('+1  year'));
                if (\Session::get('PermitRequestData') != null) {
                    $dataSet = \Session::get('PermitRequestData'); //Session assigned to the datasetObj
                    $dataSet['payment_id'] = $payment[0]->id;
                    $dataSet['price_id'] = $price[0]->id;
                    $dataSet['user_id'] = $user->id;
                    $dataSet['created_at'] = date('Y-m-d H:i:s', strtotime('+1  year'));
                    $storeDBP = DB::table('permit_requests')->insert([$dataSet]);
                    $status = $this->PermitRequestMailNotification();
                    \Session::forget('PermitRequestData');
                }
                if (isset($name) && $name != null) {
                    $search_add_id = DB::table('search_address')->insertGetId(['user_id' => $user->id, 'search_name' => $name, 'price_id' => $price[0]->id, 'payment_id' => $payment[0]->id, 'alarm' => 0, 'valid_upto' => date('Y-m-d', strtotime('+1  year'))]);
                    $search_id = DB::table('search_address')->select('id')->where('search_name', $name)->first();
                    $reportObjId = DB::table('report')->insertGetId(['search_add_id' => $search_add_id, 'search_id' => $search_id->id]);
                }
            }
            $today = date("Y-m-d");
            $expire = date("Y-m-d", strtotime("+1 month", strtotime($payment[0]->created_at)));
            if ($today < $expire) {

                $myReportPrimeReport = DB::table('permit_requests')->where('user_id', $user->id)->whereIn('status', [0, 1])->where('payment_id', $payment[0]->id)->get()->count();

                $myReportSearchAddress = DB::table('search_address')->where('user_id', $user->id)->where('payment_id', $payment[0]->id)->whereNotIn('alarm', [-1])->get()->count();

                $myReport = $myReportSearchAddress + $myReportPrimeReport;
                $price = DB::table('pricing')->where('id', $payment[0]->price_id)->get();
                if (!$price->isEmpty()) {
                    $report = explode(' ', $price[0]->report);
                    if ($report[0] == 'Unlimited') {
                        $report[0] = '10000';
                    }
                    $rem = $report[0] - $myReport;
                    $rem = $rem < 0 ? 0 : $rem;
                    if ($rem >= 0) {
                        \Session::put('usePermit', $rem);
                    } else {
                        \Session::put('usePermit', 0);
                    }
                } else {
                    $rem = "0";
                    \Session::put('usePermit', $rem);
                }
            } else {
                $rem = "0";
                \Session::put('usePermit', $rem);
            }
            $click = 'yes';
            \Session::put('viewReportPopUp', $click);
            return response()->json($rem);
        }
    }

    public function viewAjaxPermitData(Request $request)
    {
        $id = Crypt::decrypt($request->id);
        $search = DB::table('search')->where('id', $id)->get();
        $user = Auth::guard('web')->user();
        $payment = DB::table('payment')->where('user_id', $user->id)->offset(0)->limit(1)->orderBy('id', 'DESC')->get();
        // if(!$payment->isEmpty()){
        //  $today = date("Y-m-d");
        //  $expire = date("Y-m-d", strtotime("+1 month", strtotime($payment[0]->created_at)));
        //  if($today < $expire){
        //      $myReport = DB::table('report')->where('user_id',$user->id)->where('payment_id',$payment[0]->id)->get()->count();
        //      $price = DB::table('pricing')->where('id',$payment[0]->price_id)->get();
        //      if(!$price->isEmpty()){
        //          $report = explode(' ',$price[0]->report);
        //          if($report[0] == 'Unlimited'){
        //           $report[0] = '10000';
        //          }
        //          $rem = $report[0] - $myReport - 1;
        //          if($rem >= 0){
        //           \Session::put('usePermit',$rem);
        //          }else{
        //           \Session::put('usePermit',0);
        //          }
        //      }else{
        //       $rem = "0";
        //          \Session::put('usePermit',$rem);
        //      }
        //  }else{
        //      $rem = "0";
        //      \Session::put('usePermit',$rem);
        //     }
        // }else{
        //  $rem = "0";
        //     \Session::put('usePermit',$rem);
        // }

        $price = DB::table('pricing')->where('id', $payment[0]->price_id)->offset(0)->limit(1)->orderBy('id', 'DESC')->get();
        //    // if($rem >= 0){
        $chk = DB::table('search_address')->where('user_id', $user->id)->where('search_name', $search[0]->PropertyFullAddress)->get();
        if (!$chk->isEmpty()) {
            // $date = date('Y-m-d',strtotime('+1  year'));
            $repS = DB::table('report')->where('search_add_id', $chk[0]->id)->where('search_id', $id)->get();
            if ($repS->isEmpty()) {
                $insert_id = DB::table('report')->insertGetId(['search_add_id' => $chk[0]->id, 'search_id' => $search[0]->id]);
            } else {
                DB::table('report')->where('search_add_id', $chk[0]->id)->where('search_id', $id)->update(['updated_at' => now()]);
                $insert_id = $repS[0]->id;
            }
        }

        foreach ($search as $key => $value) {
            $value->id = Crypt::encrypt($chk[0]->id);
            $value->PermitEffectiveDate = date('m/d/y', strtotime($value->PermitEffectiveDate));
            $value->PermitStatusDate = date('m/d/y', strtotime($value->PermitStatusDate));
        }
        // }else{
        //  $rem = "error";
        // }
        return response()->json([$search[0]]);
        // return response()->json([$search[0],$rem]);
    }

    public function setTextAlertSelReport(Request $request)
    {
        if (!empty($request->input('_token'))) {
            $id = Crypt::decrypt($request->input('altPID'));
            $user = Auth::guard('web')->user();
            $sel = DB::table('search_address')->where('id', $id)->get()[0]->search_name;
            if (array_key_exists('phone_num', $request->all())) {
                $phone = $this->sendMessage($request->input('phone_num'), $sel);
                if ($phone == "Success") {
                    DB::table('search_address')->where('id', $id)->update(['alarm' => 1]);
                    $chk = DB::table('alarm_notification')->where('user_id', $user->id)->get();
                    if ($chk->isEmpty()) {
                        DB::table('alarm_notification')->insertGetId(['user_id' => $user->id, 'phone' => $request->input('phone_num')]);
                    } else {
                        DB::table('alarm_notification')->where('user_id', $user->id)->update(['phone' => $request->input('phone_num')]);
                    }
                    return redirect('/dashboard/permit/my-report')->withSuccess('Notification set successfully.');
                } else {
                    return redirect()->back()->withFail($phone);
                }
            }
        } else {
            return redirect('/');
        }
    }

    public function viewMyReports()
    {
        $user = Auth::guard('web')->user();
        $this->creditRem();
        
        $report = DB::table('search_address')->select("*")
            ->join('report', 'report.search_add_id', '=', 'search_address.id')
            ->leftJoin('search', 'report.search_id', '=', 'search.id' )
            ->where('search_address.user_id', $user->id)
            ->orderBy('report.created_at', 'DESC')
            ->get()->toArray();
        
        if (!empty($report)) {

            // echo "<pre>"; print_r($report); exit;
            $array = [];
            $array1 = [];
            $listTemp = [];
            $date = strtotime(date('Y-m-d'));
            foreach ($report as $key => $value) {
                $exp = strtotime($value->valid_upto);
                if ($date < $exp) {
                    $search = DB::table('search')->where('PropertyFullAddress', $value->search_name)->get();
                    if (count($search) > 0) {
                        foreach ($search as $key1 => $value1) {
                            if (isset($value1->PermitNumber) && !in_array($value1->PermitNumber, $listTemp)) {
                                if ($value1->id == $value->search_id) {
                                    $value1->valid_upto = $value->valid_upto;
                                    $value1->alarm = $value->alarm;
                                    $value1->updated_at = $value->updated_at;
                                }
                                $array1[$value1->PropertyStreetName][$value1->PermitStatus][] = $value1;
                                $listTemp[] = $value1->PermitNumber;
                            }
                        }
                    } else {
                        # pending permit request 
                        if ($value->permit_request_id) {
                            $obj = [];
                            $permitRequest = DB::table('permit_requests')->where('id', $value->permit_request_id)->get();
                            if (count($permitRequest) > 0) {
                                $value->PropertyFullAddress = $value->search_name;
                                $value->PropertyCity = $permitRequest[0]->property_city;
                                $value->PropertyState = $permitRequest[0]->property_state;
                                $value->PropertyZipCode = $permitRequest[0]->zip_code;
                                $value->PermitStatus = 'pending';
                            }
                        }
                        
                        $array1[$value->search_add_id]['pending'][] = $value;
                    }
                    
                } else {
                    $array = '';
                }
            }
            // print_r($array1);
            // exit;
        } else {
            $array = '';
        }

        if (!empty($array1)) {
            $h = [];
            foreach ($array1 as $key => $value) {
                $gg = [];
                foreach ($value as $key1 => $value1) {

                    $gg[$key] = [
                        'id' => $value1[0]->id,
                        'street' => $value1[0]->PropertyFullAddress,
                        'city' => $value1[0]->PropertyCity,
                        'state' => $value1[0]->PropertyState,
                        'zipcode' => $value1[0]->PropertyZipCode,
                        'alert' => @$value1[0]->alarm ?? '',
                        'lastseen' => date('m/d/y', strtotime(@$value1[0]->updated_at ?? '')),
                        'valid' => $value1[0]->valid_upto ?? 'N/A',
                        'result' => $value,
                        'PermitStatus' => $value1[0]->PermitStatus,
                    ];
                }
                $h[] = $gg;
            }
        } else {
            $h = '';
        }

        // echo "<pre>";print_r($h);die;
        return view('dashboard.my-report')->with(['data' => $h]);
    }

    public function permitSampleDownload()
    {
        //PDF file is stored under project/public/download/info.pdf
        $file= public_path(). "/1621_Albert_Street.xlsx";

        $headers = array(
                'Content-Type: application/xlsx',
                );

        return response()->download($file, 'filename.xlsx', $headers);
    }
    public function viewSubscribePage()
    {
        $user = Auth::guard('web')->user();
        $this->creditRem();
        $subs = DB::table('payment')
            ->join('subscription', 'subscription.payment_id', '=', 'payment.id')
            ->join('pricing', 'pricing.id', '=', 'payment.price_id')
            ->where('payment.user_id', $user->id)->get();
        return view('dashboard.subscription')->with('data', $subs);
    }

    public function viewBillHistoryPage()
    {
        $data = DB::table('payment')
            ->select('payment.id as pay_id', 'payment.created_at as payment_date', 'payment.*', 'pricing.*', 'pricing.id as idd')
            ->join('pricing', 'pricing.id', '=', 'payment.price_id')
            ->where('user_id', Auth::guard('web')->user()->id)
            ->orderBy('payment.id', 'DESC')
            ->get();
        if (!$data->isEmpty()) {
            $bb = [];
            foreach ($data as $key => $value) {
                if ($value->plan_period == 'single') {
                    $bb[] = $value;
                }
            }
        } else {
            $bb = '';
        }
        $this->creditRem();
        return view('dashboard.billing-history')->with('data', $bb);
    }

    public function checkUserNotify()
    {
        $user = Auth::guard('web')->user()->id;
        $check = DB::table('alarm_notification')->where('user_id', $user)->get();
        if ($check->isEmpty()) {
            return "empty";
        } else {
            return "exists";
        }
    }

    public function viewProfilePage(Request $request)
    {
        if ($request->input('_token')) {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required'],
            ]);
            if ($validator->fails()) {
                $de = $validator->errors();
                return redirect()->back()->withFail($de);
            } else {
                $user = Auth::guard('web')->user();
                if (isset($user->user_role_type) && $user->user_role_type == 1) {
                    $file_name = Auth::user()->user_image;
                    $file_namec = Auth::user()->company_logo;
                    if ($request->hasFile('userImage')) {
                        $filenameWithExt = $request->file('userImage')->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $extension = $request->file('userImage')->getClientOriginalExtension();
                        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                        $path = $request->file('userImage')->storeAs('public/images/users', $fileNameToStore);
                        $file_name = $fileNameToStore;
                        if ($request->hasFile('companyLogo')) {
                            $filenameWithExtc = $request->file('companyLogo')->getClientOriginalName();
                            $filenamec = pathinfo($filenameWithExtc, PATHINFO_FILENAME);
                            $extensionc = $request->file('companyLogo')->getClientOriginalExtension();
                            $fileNameToStoreClogo = $filenamec . '_' . time() . '.' . $extensionc;
                            $pathc = $request->file('companyLogo')->storeAs('public/images/users', $fileNameToStoreClogo);
                            $file_namec = $fileNameToStoreClogo;
                            $dataIs = ['name' => $request->name, 'phone' => $request->phone, 'address1' => $request->address1, 'address2' => $request->address2, 'country' => $request->country, 'state' => $request->state, 'city' => $request->city, 'contact' => $request->contact, 'user_image' => $fileNameToStore ,'company_logo' => $fileNameToStoreClogo ,'website_url' => $request->website_url ,'company_name' => $request->company_name, 'company_phone_no' => $request->company_phone_no , 'zipcode' => $request->zipcode];
                        } else {
                        $dataIs = ['name' => $request->name, 'phone' => $request->phone, 'address1' => $request->address1, 'address2' => $request->address2, 'country' => $request->country, 'state' => $request->state, 'city' => $request->city, 'contact' => $request->contact, 'user_image' => $fileNameToStore ,'website_url' => $request->website_url ,'company_name' => $request->company_name, 'company_phone_no' => $request->company_phone_no , 'zipcode' => $request->zipcode];
                        }
                    }else{
                        if ($request->hasFile('companyLogo')) {
                            $filenameWithExtc = $request->file('companyLogo')->getClientOriginalName();
                            $filenamec = pathinfo($filenameWithExtc, PATHINFO_FILENAME);
                            $extensionc = $request->file('companyLogo')->getClientOriginalExtension();
                            $fileNameToStoreClogo = $filenamec . '_' . time() . '.' . $extensionc;
                            $pathc = $request->file('companyLogo')->storeAs('public/images/users', $fileNameToStoreClogo);
                            $file_namec = $fileNameToStoreClogo;
                            $dataIs = ['name' => $request->name, 'phone' => $request->phone, 'address1' => $request->address1, 'address2' => $request->address2, 'country' => $request->country, 'state' => $request->state, 'city' => $request->city, 'contact' => $request->contact , 'website_url' => $request->website_url ,'company_name' => $request->company_name,'company_logo' => $fileNameToStoreClogo, 'company_phone_no' => $request->company_phone_no , 'zipcode' => $request->zipcode];
                        } else {
                        $dataIs = ['name' => $request->name, 'phone' => $request->phone, 'address1' => $request->address1, 'address2' => $request->address2, 'country' => $request->country, 'state' => $request->state, 'city' => $request->city, 'contact' => $request->contact , 'website_url' => $request->website_url ,'company_name' => $request->company_name, 'company_phone_no' => $request->company_phone_no , 'zipcode' => $request->zipcode];
                        }
                    }
                    // File Upload End
                    $profileUpdate = DB::table('users')->where('id', $user->id)->update($dataIs);
                } else { // normal user
                    $profileUpdate = DB::table('users')->where('id', $user->id)->update(['name' => $request->name, 'phone' => $request->phone]);
                }

                $phone = DB::table('alarm_notification')->where('user_id', $user->id)->get();
                $message = "Your profile data update successfully.";
                $recipients = $request->phone;
                $account_sid = config('app.TWILIO_SID');
                $auth_token = config('app.TWILIO_AUTH_TOKEN');
                $twilio_number = config('app.TWILIO_NUMBER');
                try {
                    $client = new Client($account_sid, $auth_token);
                    $client->messages->create(
                        $recipients,
                        ['from' => $twilio_number, 'body' => $message]
                    );

                    $status = "Success";
                    if (!$phone->isEmpty()) {
                        DB::table('alarm_notification')->where('user_id', $user->id)->update(['phone' => $request->phone]);
                    } else {
                        DB::table('alarm_notification')->insertGetId(['user_id' => $user->id, 'phone' => $request->phone]);
                    }
                } catch (\Twilio\Exceptions\RestException $e) {
                    $status = "Please enter a valid phone number";
                    return redirect()->back()->withFaill($status);
                }
            }
        }

        $user = Auth::guard('web')->user()->id;
        $data = DB::table('users')->where('id', $user)->get();
        foreach ($data as $key => $value) {
            $phonee = DB::table('alarm_notification')->where('user_id', $value->id)->get();
            if ($phonee->isEmpty()) {
                $value->phone = '';
            } else {
                $value->phone = $phonee[0]->phone;
            }
        }
        $this->creditRem();
        return view('dashboard.profile')->with('data', $data);
    }
    public function permitUpload(Request $request)
    {
        $file = $request->file('upload_file');
        $imgrealpath = $request->file('upload_file')->getClientOriginalName();
        $filename = pathinfo($imgrealpath, PATHINFO_FILENAME);
        $extension = $request->file('upload_file')->getClientOriginalExtension();
        $uploadFileName = uniqid().'.'.$extension;
        $valid = ['xlsx','csv'];

        $usepermit = \Session::get('usePermit');
        if($usepermit > 0)
        {
            if (in_array($extension, $valid)) {

                DB::table('pemit_data_upload')->insertGetId(['filename' => $imgrealpath]);
                $path = $request->file('upload_file')->storeAs('/permitdata', $uploadFileName);
                $inputFileName = Storage::path($path);

                $spreadsheet = new Spreadsheet();
                $chunkSize = 1000;
                $isreportupload = 1;


                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader(ucfirst($extension));
                $size = filesize($inputFileName);
                $reader->setReadDataOnly(true);
                $reader->setReadEmptyCells(false);
                $reader->setLoadSheetsOnly('Sheet1');
                $chunkValid = $size / 1048576;
                if($chunkValid > 15){
                    $chunkFilter = new ChunkReadFilter();
                    $reader->setReadFilter($chunkFilter);
                    for ($startRow = 1; $startRow <= 40000; $startRow += $chunkSize) {
                        $chunkFilter->setRows($startRow,$chunkSize);
                        $spreadsheet = $reader->load($inputFileName);
                        $sheetData = $spreadsheet->getActiveSheet()->toArray();
                        $rowcount = count($spreadsheet);
                        if($rowcount <= 11)
                        {
                            dispatch(new PermitImportDataReport($sheetData , $isreportupload));
                        } else {
                            return redirect()->back()->withFail("Can't upload more than 10 address at a time.");
                        }
                    }
                } else {
                    $spreadsheet = $reader->load($inputFileName);
                    $worksheet = $spreadsheet->getActiveSheet();
                    $rows = $worksheet->toArray();
                    $rowcount = count($rows);
                    if($rowcount <= 11)
                    {
                        dispatch(new PermitImportDataReport($rows , $isreportupload));
                    } else {
                        return redirect()->back()->withFail("Can't upload more than 10 address at a time.");
                    }
                }
                File::delete($inputFileName);
                return redirect()->back()->withSuccess('Successfully uploaded Excel and Data uploading is inprogress, it will take some time...');
            } else {
                return redirect()->back()->withFail('Invalid file extension');
            }
        } else {
            return redirect()->back()->withFail('Kindly purchase credits to upload reports.');
        }
    }

    public function permituploadview()
    {
        return view('reportupload');
    }

    public function copylinkPermit( $addressIds = '')
    {
            if (!empty($addressIds)) {
                $addressData = Search::select('PropertyFullAddress')->WhereIn('id', explode(",", $addressIds))->get()->groupBy('PropertyFullAddress');

                $search_addresses = SearchAddress::WhereIn('search_name', array_keys($addressData->toArray()))->with('search')->get()->groupBy('search_name');
            } else {
                $search_addresses = SearchAddress::WhereIn('search_name', array_keys($addressData->toArray()))->with('search')->get()->groupBy('search_name');
            }
            $array = [];
            if (count($search_addresses) > 0) {
                foreach ($search_addresses as $address => $value) {
                    if (isset($value[0]->reports) && count($value[0]->reports) > 0) {
                        foreach ($value[0]->search as $key => $search) {
                            $record_flag = '';
                            if ($search->PermitStatus == 'complete' || $search->PermitStatus == 'closed') {
                                $record_flag = 'closed';
                            } else {
                                $record_flag = 'open';
                            }
                            $array[$address]['location'] = $this->fn_get_LocationData($search->PropertyHouseNumber . ' ' . $search->PropertyStreetName . ' ' . $search->PropertyMode, $search->PropertyCity, $search->PropertyState, $search->PropertyZipCode);
                            $array[$address][$record_flag][] = [
                                'number' => $search->PermitNumber,
                                'date' => date('m/d/y', strtotime($search->PermitEffectiveDate)),
                                'description' => $search->PermitDescription,
                                'status' => ($search->PermitStatus == 'complete' || $search->PermitStatus == 'closed') ? 'closed' : 'open',
                                'address' => $search->PropertyFullAddress,
                                'agent' => $search->ApplicantName,
                                'cost' => $search->PermitFee,
                                'type' => $search->PermitType,
                                'cdate' => date('m/d/y', strtotime($search->PermitStatusDate)),
                            ];
                        }
                    }
                }
            }

        $base64 = "";
        $data = [
            'array' => $array,
            'is_pro_user' => '',
            'user_details' => [],
            'user_image' => '',
        ];

        $pdf = \PDF::loadView('pdf/permitPDF', $data);
        return $pdf->download('permitsearch.pdf');
    }

    public function downloadPermit($type, $addressIds = '')
    {
        $type = \Crypt::decrypt($type);
        $user = Auth::guard('web')->user();
        if ($type == 'report') {
            if (!empty($addressIds)) {
                $addressData = Search::select('PropertyFullAddress')->WhereIn('id', explode(",", $addressIds))->get()->groupBy('PropertyFullAddress');

                $search_addresses = SearchAddress::where('user_id', $user->id)->WhereIn('search_name', array_keys($addressData->toArray()))->with('search')->get()->groupBy('search_name');
            } else {
                $search_addresses = SearchAddress::where('user_id', $user->id)->WhereIn('search_name', array_keys($addressData->toArray()))->with('search')->get()->groupBy('search_name');
            }
            $array = [];
            if (count($search_addresses) > 0) {
                foreach ($search_addresses as $address => $value) {
                    if (isset($value[0]->reports) && count($value[0]->reports) > 0) {
                        foreach ($value[0]->search as $key => $search) {
                            $record_flag = '';
                            if ($search->PermitStatus == 'complete' || $search->PermitStatus == 'closed') {
                                $record_flag = 'closed';
                            } else {
                                $record_flag = 'open';
                            }
                            $array[$address]['location'] = $this->fn_get_LocationData($search->PropertyHouseNumber . ' ' . $search->PropertyStreetName . ' ' . $search->PropertyMode, $search->PropertyCity, $search->PropertyState, $search->PropertyZipCode);

                            $array[$address][$record_flag][] = [
                                'number' => $search->PermitNumber,
                                'date' => date('m/d/y', strtotime($search->PermitEffectiveDate)),
                                'description' => $search->PermitDescription,
                                'status' => ($search->PermitStatus == 'complete' || $search->PermitStatus == 'closed') ? 'closed' : 'open',
                                'address' => $search->PropertyFullAddress,
                                'agent' => $search->ApplicantName,
                                'cost' => $search->PermitFee,
                                'type' => $search->PermitType,
                                'cdate' => date('m/d/y', strtotime($search->PermitStatusDate)),
                            ];
                        }
                    }
                }
            }
        } else {
            $permit = Search::where('PropertyFullAddress', $type)->get()->groupBy('PropertyFullAddress');
            $array = [];
            foreach ($permit as $address => $values) {
                foreach ($values as $key => $value) {
                    $record_flag = '';
                    if ($value->PermitStatus == 'complete') {
                        $record_flag = 'closed';
                    } else {
                        $record_flag = 'open';
                    }
                    $array[$address]['location'] = $this->fn_get_LocationData($value->PropertyHouseNumber . ' ' . $value->PropertyStreetName . ' ' . $value->PropertyMode, $value->PropertyCity, $value->PropertyState, $value->PropertyZipCode);

                    $array[$address][$record_flag][] = [
                        'number' => $value->PermitNumber,
                        'date' => date('m/d/y', strtotime($value->PermitEffectiveDate)),
                        'description' => $value->PermitDescription,
                        'status' => ($value->PermitStatus == 'complete' || $value->PermitStatus == 'closed') ? 'closed' : 'open',
                        'address' => $value->PropertyFullAddress,
                        'agent' => $value->ApplicantName,
                        'cost' => $value->PermitFee,
                        'type' => $value->PermitType,
                        'cdate' => date('m/d/y', strtotime($value->PermitStatusDate)),
                    ];
                }
            }
        }

        $base64 = "";
        // temporary commented due to twilio api issue
        /* if (isset($user->user_image) && !empty($user->user_image)) {
        $path = public_path('images/users/' . $user->user_image);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        } */

        $data = [
            // 'streetName' => $name,
            'array' => $array,
            'is_pro_user' => $user->user_role_type,
            'user_details' => $user,
            'user_image' => $base64,
        ];

        $pdf = \PDF::loadView('pdf/permitPDF', $data);
        return $pdf->download('permitsearch.pdf');
    }

    public function printPermit($type, $addressIds = '')
    {
        $type = \Crypt::decrypt($type);
        $user = Auth::guard('web')->user();
        if ($type == 'report') {
            if (!empty($addressIds)) {
                $addressData = Search::select('PropertyFullAddress')->WhereIn('id', explode(",", $addressIds))->get()->groupBy('PropertyFullAddress');
                $search_addresses = SearchAddress::where('user_id', $user->id)->WhereIn('search_name', array_keys($addressData->toArray()))->with('search')->get()->groupBy('search_name');
            } else {
                $search_addresses = SearchAddress::where('user_id', $user->id)->WhereIn('search_name', array_keys($addressData->toArray()))->with('search')->get()->groupBy('search_name');
            }
            $array = [];
            if (count($search_addresses) > 0) {
                foreach ($search_addresses as $address => $value) {
                    if (isset($value[0]->search) && count($value[0]->search) > 0) {
                        // dd($value[0]->search );
                        foreach ($value[0]->search as $key => $search) {
                            $record_flag = '';
                            if ($search->PermitStatus == 'complete' || $search->PermitStatus == 'closed') {
                                $record_flag = 'closed';
                            } else {
                                $record_flag = 'open';
                            }
                            $array[$address]['location'] = $this->fn_get_LocationData($search->PropertyHouseNumber . ' ' . $search->PropertyStreetName . ' ' . $search->PropertyMode, $search->PropertyCity, $search->PropertyState, $search->PropertyZipCode);
                            $array[$address][$record_flag][] = [
                                'number' => $search->PermitNumber,
                                'date' => date('m/d/y', strtotime($search->PermitEffectiveDate)),
                                'description' => $search->PermitDescription,
                                'status' => ($search->PermitStatus == 'complete' || $search->PermitStatus == 'closed') ? 'closed' : 'open',
                                'address' => $search->PropertyFullAddress,
                                'agent' => $search->ApplicantName,
                                'cost' => $search->PermitFee,
                                'type' => $search->PermitType,
                                'cdate' => date('m/d/y', strtotime($search->PermitStatusDate)),
                            ];
                        }
                    }
                }
            }
        } else {
            $permit = Search::where('PropertyFullAddress', $type)->get()->groupBy('PropertyFullAddress');
            $array = [];
            foreach ($permit as $address => $values) {
                foreach ($values as $key => $value) {
                    $record_flag = '';
                    if ($value->PermitStatus == 'complete' || $value->PermitStatus == 'closed') {
                        $record_flag = 'closed';
                    } else {
                        $record_flag = 'open';
                    }
                    $array[$address]['location'] = $this->fn_get_LocationData($value->PropertyHouseNumber . ' ' . $value->PropertyStreetName . ' ' . $value->PropertyMode, $value->PropertyCity, $value->PropertyState, $value->PropertyZipCode);
                    $array[$address][$record_flag][] = [
                        'number' => $value->PermitNumber,
                        'date' => date('m/d/y', strtotime($value->PermitEffectiveDate)),
                        'description' => $value->PermitDescription,
                        'status' => ($value->PermitStatus == 'complete' || $value->PermitStatus == 'closed') ? 'closed' : 'open',
                        'address' => $value->PropertyFullAddress,
                        'agent' => $value->ApplicantName,
                        'cost' => $value->PermitFee,
                        'type' => $value->PermitType,
                        'cdate' => date('m/d/y', strtotime($value->PermitStatusDate)),
                    ];
                }
            }
        }

        $data = [
            'array' => $array,
        ];
        $pdf = \PDF::loadView('pdf/permitPDF', $data);
        return $pdf->stream('permit');
    }

    public function fn_get_LocationData($address, $city = null, $state = null, $zip = null)
    {

        $arrCoOrdinate = [];
        $address = urlencode($address);
        $city = urlencode($city);
        $state = urlencode($state);
        $zip = urlencode($zip);
        $formattedAddr = $address . '+' . $city . '+' . $state . '+' . $zip;
        $url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCspRPQC5shbwVwsgD9MAyy4UBbLDg2kJU&address=$formattedAddr";
        // Make the HTTP request
        //return @file_get_contents($url);
        $intLat = $intLong = 0;
        $arrData = @file_get_contents($url);
        $jsonData = json_decode($arrData, true);
        if (!empty($jsonData["results"]) && isset($jsonData["results"])) {
            $jsonData = json_decode($arrData, true);
            $arrCoOrdinate['lat'] = $jsonData["results"][0]["geometry"]["location"]["lat"];
            $arrCoOrdinate['lng'] = $jsonData["results"][0]["geometry"]["location"]["lng"];
        }
        // return json_encode($arrCoOrdinate);
        return $arrCoOrdinate['lat'] . ',' . $arrCoOrdinate['lng'];
    }

    public function sendMessage($recipients, $address)
    {
        $user = Auth::guard('web')->user();
        $message = "Hello " . $user->name . ", You activate the notification alarm for " . $address . ".";
        $account_sid = config('app.TWILIO_SID');
        $auth_token = config('app.TWILIO_AUTH_TOKEN');
        $twilio_number = config('app.TWILIO_NUMBER');
        try {
            $client = new Client($account_sid, $auth_token);
            $client->messages->create(
                $recipients,
                ['from' => $twilio_number, 'body' => $message]
            );
            $status = "Success";
        } catch (\Twilio\Exceptions\RestException $e) {
            $status = "Please enter a valid phone number.";
        }
        return $status;
    }
    // public function viewSettingPage(){
    //     $user = Auth::guard('web')->user();
    //     $this->creditRem();
    //     return View('dashboard.setting');
    // }
    public function setNotification(Request $request)
    {
        $user = Auth::guard('web')->user()->id;
        $id = Crypt::decrypt($request->id);
        $address = Crypt::decrypt($request->address);
        $status = $request->alarm;
        $sel = DB::table('search_address')->where('user_id', $user)->where('search_name', $address)->get();
        if (!$sel->isEmpty()) {
            DB::table('search_address')->where(['user_id' => $user, 'search_name' => $address])->update(['alarm' => $status]);
            return response()->json('success');
        } else {
            return response()->json('empty');
        }
    }

    // public function sendShareReport(Request $request){
    //     $email = $request->email;
    //     $user = Auth::guard('web')->user();
    //     $report = DB::table('search_address')
    //     ->join('report','report.search_add_id', '=', 'search_address.id')
    //     ->where('search_address.user_id',$user->id)
    //     ->get();
    //     $permit = [];
    //     foreach ($report as $key => $value) {
    //      $permit[] = DB::table('search')->where('id',$value->search_id)->get();
    //  }

    //  $array = [];
    //  foreach ($permit as $key => $value) {
    //     $array[] = [
    //         'number' => $value[0]->PermitNumber,
    //         'date' => date('m/d/y',strtotime($value[0]->PermitEffectiveDate)),
    //         'description' => $value[0]->PermitDescription,
    //         'status' => $value[0]->PermitStatus,
    //         'address' => $value[0]->PropertyFullAddress,
    //         'agent' => $value[0]->ApplicantName,
    //         'cost' => $value[0]->PermitFee,
    //         'type' => $value[0]->PermitType,
    //         'cdate' => date('m/d/y',strtotime($value[0]->PermitStatusDate)),
    //     ];

    // }

    // $data = [
    //     'array' => $array
    // ];

    // $dt['email'] = $email;
    // $dt['title'] = "Permit Search report";
    // $dt['body'] = "This is for testing share email.";
    // $pdf = \PDF::loadView('pdf/permitPDF', $data);
    // \Mail::send('mail.sharemail', $dt, function($message)use($dt, $pdf) {
    //     $message->to($dt["email"], $dt["email"])
    //     ->subject($dt["title"])
    //     ->attachData($pdf->output(), "myReport.pdf");
    // });
    // return redirect('/dashboard/permit/my-report')->withSuccess('Report share successfully.');
    // }

    public function sendShareReport($email, $addressIds = '')
    {
        $user = Auth::guard('web')->user();
        if (!empty($addressIds)) {
            $addressData = Search::select('PropertyFullAddress')->WhereIn('id', explode(",", $addressIds))->get()->groupBy('PropertyFullAddress');

            $search_addresses = SearchAddress::where('user_id', $user->id)->WhereIn('search_name', array_keys($addressData->toArray()))->with('search')->get()->groupBy('search_name');
        } else {
            $search_addresses = SearchAddress::where('user_id', $user->id)->WhereIn('search_name', array_keys($addressData->toArray()))->with('search')->get()->groupBy('search_name');
        }

        $array = [];
        if (count($search_addresses) > 0) {
            foreach ($search_addresses as $address => $value) {
                if (isset($value[0]->search) && count($value[0]->search) > 0) {
                    // dd($value[0]->search );
                    foreach ($value[0]->search as $key => $search) {
                        $record_flag = '';
                        if ($search->PermitStatus == 'complete' || $search->PermitStatus == 'closed') {
                            $record_flag = 'closed';
                        } else {
                            $record_flag = 'open';
                        }
                        $array[$address]['location'] = $this->fn_get_LocationData($search->PropertyHouseNumber . ' ' . $search->PropertyStreetName . ' ' . $search->PropertyMode, $search->PropertyCity, $search->PropertyState, $search->PropertyZipCode);
                        $array[$address][$record_flag][] = [
                            'number' => $search->PermitNumber,
                            'date' => date('m/d/y', strtotime($search->PermitEffectiveDate)),
                            'description' => $search->PermitDescription,
                            'status' => ($search->PermitStatus == 'complete' || $search->PermitStatus == 'closed') ? 'closed' : 'open',
                            'address' => $search->PropertyFullAddress,
                            'agent' => $search->ApplicantName,
                            'cost' => $search->PermitFee,
                            'type' => $search->PermitType,
                            'cdate' => date('m/d/y', strtotime($search->PermitStatusDate)),
                        ];
                    }
                }
            }
        }

        $data = [
            'array' => $array,
        ];
        $email_multiple = "";
        if (isset(Auth::user()->user_role_type) && Auth::user()->user_role_type == 1) {
            $email_multiple = explode(",", str_replace(", ", ",", $email));
        } else {
            $email_multiple = $email;
        }

        $dt['email'] = $email_multiple;
        $dt['title'] = "Permit Search report";
        $dt['body'] = "This is for testing share email.";
        $pdf = \PDF::loadView('pdf/permitPDF', $data);
        \Mail::send('mail.sharemail', $dt, function ($message) use ($dt, $pdf) {
            $message->to($dt["email"], $dt["email"])
                ->subject($dt["title"])
                ->attachData($pdf->output(), "myReport.pdf");
        });
        return redirect('/dashboard/permit/my-report')->withSuccess('Report share successfully.');
    }

    public function viewChangePass()
    {
        return view('dashboard.change-password');
    }

    public function userPermitRequest(Request $request)
    {
        $data = [];
        foreach ($request->data as $value) {
            $data[$value['name']] = ($value['name'] == 'description') ? $value['value'] : strtoupper($value['value']);
        }
        \Session::put('PermitRequestData', $data);
        # check user is logged in or new
        if (isset(Auth::guard('web')->user()->id) && Auth::guard('web')->user()->id != null) {
            $this->creditRem();
            if (\Session::get('usePermit') > 0) {
                $this->addUserReportSesion();
                return 0; // if credit is available
            } else {
                return 1; // for logged user
            }
        } else {
            return 2;
        }
        // for not logged user
    }

    public function ClickToUseCreditsForPermitRequests()
    {
        $this->storePermitRequest();
    }

    public function forget_perment_search()
    {
        \Session::forget('PermitRequestData');
    }

    public function PermitRequestMailNotification()
    {
        try {
            if (\Session::get('PermitRequestData') != null) {
                $details = \Session::get('PermitRequestData');
                $adminObj = Admin::where('role_id', 1)->first();
                \Mail::to($adminObj->email)->send(new PermitRequestMail($details));
            }
        } catch (Exception $e) {
            $exception = $e->getMessage();
            Log::error($exception);
        }
    }
}
