<?php

namespace App\Jobs;

use App\Search;
use Auth;
use App\SearchAddress;
use Carbon\Carbon;
use Twilio\Rest\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DB;
use Illuminate\Support\Facades\Log;

class PermitImportDataReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $rows;
    public $uniId;
    public $isreportupload;
    public $uniqueFor = 3600;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($rows,$isreportupload = null)
    {
        $this->rows = $rows;
        $this->isreportupload = $isreportupload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $rows = $this->rows;
        $columnkey = [];
        $rowdata = [];
        if (!empty($rows)) {
            foreach ($rows as $key => $value) {
                if ($key == 0) {
                    $columnkey = $value;
                    continue;
                }
                $rowdata[$key] = array_combine($columnkey, $value);
            }
        }
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';  

        if (!empty($rowdata)) {
            foreach ($rowdata as $row) {
                try {
                    if(!is_numeric($row['PermitStatusDate']))
                    {
                        $row['PermitStatusDate'] = Carbon::createFromFormat('m/d/Y',$row['PermitStatusDate'])->format('Y-m-d');
                    } else {
                        $date1 = ($row['PermitStatusDate'] - 25569) * 86400;
                        $row['PermitStatusDate'] = date('Y-m-d', $date1);
                    }
                    if(!is_numeric($row['PermitEffectiveDate']))
                    {
                        $row['PermitEffectiveDate'] = Carbon::createFromFormat('m/d/Y',$row['PermitEffectiveDate'])->format('Y-m-d');
                    } else {
                        $date2 = ($row['PermitEffectiveDate'] - 25569) * 86400;
                        $row['PermitEffectiveDate'] = date('Y-m-d', $date2);
                    }

                    $row['_token'] = substr(str_shuffle($permitted_chars), 0, 16);
                    $row['PropertyFullAddress'] = strtoupper($row['PropertyFullAddress'] . ', ' . $row['PropertyCity'] . ', ' . $row['PropertyState'] . ' 0' . $row['PropertyZipCode']);
                    $array = [
                        'masterpermitid' => $row['MasterPermitID'],
                        'sourceid' => $row['SourceID'],
                        'sourcepermitid' => $row['SourcePermitID'],
                        'fipscode' => $row['FIPSCode'],
                        'location' => $row['Location'],
                        'propertyfulladdress' => strtoupper($row['PropertyFullAddress']),
                        'propertyhousenumberprefix' => strtoupper($row['PropertyHouseNumberPrefix']),
                        'propertyhousenumber' => $row['PropertyHouseNumber'],
                        'propertyhousenumbersuffix' => $row['PropertyHouseNumberSuffix'],
                        'propertydirection' => $row['PropertyDirection'],
                        'propertystreetname' => strtoupper($row['PropertyStreetName']),
                        'propertymode' => strtoupper($row['PropertyMode']),
                        'propertyquadrant' => $row['PropertyQuadrant'],
                        'propertyunitnumber' => $row['PropertyUnitNumber'],
                        'propertycity' => strtoupper($row['PropertyCity']),
                        'propertystate' => strtoupper($row['PropertyState']),
                        'propertyzipcode' => $row['PropertyZipCode'],
                        'propertyzipcodeplusfour' => $row['PropertyZipCodePlusFour'],
                        'permitnumber' => (string)$row['PermitNumber'],
                        'projectname' => $row['ProjectName'],
                        'permittype' => $row['PermitType'],
                        'permitsubtype' => $row['PermitSubType'],
                        'permitclass' => $row['PermitClass'],
                        'permitdescription' => $row['PermitDescription'],
                        'permitstatus' => $row['PermitStatus'],
                        'permitstatusdate' => $row['PermitStatusDate'],
                        'permiteffectivedate' => $row['PermitEffectiveDate'],
                        'permitjobvalue' => $row['PermitJobValue'],
                        'permitfee' => $row['PermitFee'],
                        'applicantname' => $row['ApplicantName'],
                        '_token' => $row['_token']
                    ];
                    $check = Search::where('PermitNumber', $array['permitnumber'])->first();
                    $check1 = SearchAddress::where(['search_name' => $array['propertyfulladdress'], 'alarm' => 1])->first();

                    // if (isset($check1) && !empty($check1)) {
                    //     $phone = DB::table('alarm_notification')->where('user_id', $check1->user_id)->get()[0]->phone;
                    //     $message = "Hello , This permit number " . $array['permitnumber'] . " status  " . $array['permitstatus'] . ".";
                    //     $account_sid = config('app.TWILIO_SID');
                    //     $auth_token = config('app.TWILIO_AUTH_TOKEN');
                    //     $twilio_number = config('app.TWILIO_NUMBER');

                    //     $client = new Client($account_sid, $auth_token);
                    //     $client->messages->create(
                    //         $phone,
                    //         ['from' => $twilio_number, 'body' => $message]
                    //     );
                    // }

                    if (empty($check) && !isset($check)) {
                        $this->uniId = Search::insertGetId($array);
                    } else {
                        Search::where('PermitNumber', $array['permitnumber'])->update($array);
                    }
                    $this->uniId = $array['permitnumber'];
                } catch (\Exception $e) {
                    continue;
                }
                if($this->isreportupload  == 1){
                    $searchdet = Search::where('PermitNumber', $this->uniId)->first();
                    $address = $searchdet['PropertyFullAddress'];
                    $search_id = $searchdet['id'];
                    $userid = Auth::user()->id;
                    $payment = DB::table('payment')->where('user_id', $userid)->offset(0)->limit(1)->orderBy('id', 'DESC')->get();
                    $price = DB::table('pricing')->where('id', $payment[0]->price_id)->get();
                    $search_add_id = DB::table('search_address')->insertGetId(['user_id' => $userid, 'search_name' => $address, 'price_id' => $price[0]->id, 'payment_id' => $payment[0]->id, 'alarm' => 0, 'valid_upto' => date('Y-m-d', strtotime('+1  year'))]);
                    $search_id = DB::table('search_address')->select('id')->where('search_name', $address)->first();
                    $reportObjId = DB::table('report')->insertGetId(['search_add_id' => $search_add_id, 'search_id' => $search_id->id]);
                    $this->creditRem();
                }
                
            }
        }
    }

    public function uniqueId()
    {
        return $this->uniId;
    }

    public function creditRem()
    {
        $payment = DB::table('payment')->where('user_id', Auth::guard('web')->user()->id)->offset(0)->limit(1)->orderBy('id', 'DESC')->get();
        if (!$payment->isEmpty()) {
            $today = date("Y-m-d");
            $expire = date("Y-m-d", strtotime("+1 month", strtotime($payment[0]->created_at)));
            if ($today < $expire) {
                $myReportPrimeReport = DB::table('permit_requests')->where('user_id', Auth::guard('web')->user()->id)->whereIn('status', [0, 1])->where('payment_id', $payment[0]->id)->get()->count();
                $myReportSearchAddress = DB::table('search_address')->where('user_id', Auth::guard('web')->user()->id)->where('payment_id', $payment[0]->id)->get()->count();
                $report = $myReportSearchAddress + $myReportPrimeReport;
                $price = DB::table('pricing')->where('id', $payment[0]->price_id)->offset(0)->limit(1)->orderBy('id', 'DESC')->get();
                if (!$price->isEmpty()) {
                    $reportt = explode(' ', $price[0]->report);
                    if ($reportt[0] == 'Unlimited') {
                        $reportt[0] = '10000';
                    }
                    $rem = $reportt[0] - $report;
                    \Session::put('usePermit', $rem);
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
}
