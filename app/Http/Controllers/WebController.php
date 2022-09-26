<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Crypt;
use \Cache;
use Stripe;
use App\Admin;
use Exception;
use App\Report;
use App\Search;
use App\Payment;
use App\Pricing;
use App\Models\User;
use App\Subscription;
use App\PermitRequest;
use App\SearchAddress;
use App\Mail\ContactUsMail;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use App\Mail\AddressApproveSendMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use App\Mail\AdminNotificationSendMail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Mail\PermitRequestApproveNotifyMail;

class WebController extends Controller
{
    public function index()
    {
        $this->sesDestroy();
        $states = DB::table('state_list')->get();
        // $this->getAllSearchRecords();
        if (isset($_GET['getcredits']) && $_GET['getcredits'] === 'yes') {
            $price = DB::table('pricing')->where('report', 1)->get();
        } else {
            $price = DB::table('pricing')->get();
        }
        return view('index')->with(['states' => $states, 'price' => $price,
            'title' => 'Permit Search - Find Permit History on Any Property',
            'description' => 'Don\'t run the risk of buying or selling a house with costly hidden problems. Shop with confidence for a home with a Permit Search history that\'s right for you.']);
    }
    public function landing()
    {
        $this->sesDestroy();
        $states = DB::table('state_list')->get();
        if (isset($_GET['getcredits']) && $_GET['getcredits'] === 'yes') {
            $price = DB::table('pricing')->where('report', 1)->get();
        } else {
            $price = DB::table('pricing')->get();
        }
        return view('landing')->with(['states' => $states, 'price' => $price]);
    }
    public function sesDestroy()
    {
        \Session::forget(['search', 'pricePlan', 'blurSignErr']);
    }

    public function aboutus()
    {
        $this->sesDestroy();
        \Session::forget(['loginPOPUP', 'forgetPass']);
        return view('about-us')->with([
            'title' => 'Permit History Reports - Get a Permit Search Report',
            'description' => 'Don\’t settle for anything less than a genuine Permit Search History Report when buying a home. Permit Search helps you avoid costly hidden problems and issues.'
        ]);
    }

    public function pricing()
    {

        if (!isset($_GET['type'])) {
            \Session::put('buycredits', false);
            $this->sesDestroy();
        } else {
            \Session::put('buycredits', true);
        }
        \Session::forget(['loginPOPUP', 'forgetPass']);
        if (\Session::get('PermitRequestData') != null) {
            if (\Session::get('usePermit') == 0) {
                $price = DB::table('pricing')->where('report', 1)->first();
                return redirect('buy-subscription/' . Crypt::encrypt($price->id));
            } else {
                return redirect('/');
            }
        } else {
            $price = DB::table('pricing')->where('plan_period','single')->get();
        }
        return view('pricing')->with('price', $price)->with([
            'title' => 'Get a Permit Search Report Now',
            'description' => 'View Permit Search Reports instantly at home or on the go with your mobile device. Only Permit Search provides genuine permit history information for homes.'
        ]);
    }

   public function pricings()
    {
        if (!isset($_GET['type'])) {
            \Session::put('buycredits', false);
            $this->sesDestroy();
        } else {
            \Session::put('buycredits', true);
        }
        \Session::forget(['loginPOPUP', 'forgetPass']);
        if (\Session::get('PermitRequestData') != null) {
            if (\Session::get('usePermit') == 0) {
                $price = DB::table('pricing')->where('report', 1)->first();
                return redirect('buy-subscription/' . Crypt::encrypt($price->id));
            } else {
                return redirect('/');
            }
        } else {
            $price = DB::table('pricing')->where('plan_period','single')->get();
        }
        return view('pricing-new')->with('price', $price)->with([
            'title' => 'Get a Permit Search Report Now',
            'description' => 'View Permit Search Reports instantly at home or on the go with your mobile device. Only Permit Search provides genuine permit history information for homes.'
        ]);
    }

    public function subscribe()
    {
        if (!isset($_GET['type'])) {
            \Session::put('buycredits', false);
            $this->sesDestroy();
        } else {
            \Session::put('buycredits', true);
        }
        \Session::forget(['loginPOPUP', 'forgetPass']);
        if (\Session::get('PermitRequestData') != null) {
            if (\Session::get('usePermit') == 0) {
                $price = DB::table('pricing')->where('report', 1)->first();
                return redirect('buy-subscription/' . Crypt::encrypt($price->id));
            } else {
                return redirect('/');
            }
        } else {
            $price = DB::table('pricing')->get();
        }
        return view('subscribe')->with('subscribe', $price);
    }

    public function faq()
    {
        $this->sesDestroy();
        \Session::forget(['loginPOPUP', 'forgetPass']);
        return view('faq')->with([
            'title' => 'Frequently Asked Questions - Permit Search',
            'description' => 'Permit Search answers your most common permit history questions. Start a permit search for your next home with confidence and learn about permit history.'
        ]);
    }

       public function pro()
    {
        $price = DB::table('pricing')->where('plan_period','!=','single')->get();

    //    $propricing =  array('0' => [
    //          'id' => 1,
    //          'title' => 'Pro Monthly',
    //           'price' => '$299',
    //           'eachvalue' => '@30/each report',
    //           'report' => '1 - 10 reports / month',
    //           'description' => 'Print and share result.',
    //         ],
    //         '1' => [
    //             'id' => 2,
    //            'title' => 'Pro Monthly',
    //             'price' => '$799',
    //             'eachvalue' => '@28/each report',
    //            'report' => '11-30 reports / month',
    //            'description' => 'Print and share result.',
    //         ],
    //         '2' => [
    //             'id' => 3,
    //             'title' => 'Pro Monthly',
    //              'price' => '$1,249',
    //              'eachvalue' => '@25/each report',
    //             'report' => '31-50 reports / month',
    //             'description' => 'Print and share result.',
    //          ],
    //          '3' => [
    //             'id' => 4,
    //             'title' => 'Pro Monthly',
    //              'price' => '$2,149',
    //              'eachvalue' => '@22/each report',
    //             'report' => '51-100 reports / month',
    //             'description' => 'Print and share result.',
    //          ]
    //     );
        return view('pro',compact('price'))->with([
            'title' => 'Permit Search PRO - Put Permit Search to Work for You',
            'description' => 'Permit Search can help your brokerage with acquisition, advertising, retail, and service. The number one choice for real estate agents, inspectors, and more.'
        ]);
    }
    public function privacyPolicy()
    {
        $this->sesDestroy();
        \Session::forget(['loginPOPUP', 'forgetPass']);
        return view('privacy-policy')->with([
            'title' => 'Permit Search Privacy Policy',
            'description' => 'Please read the Permit Search privacy policy carefully to better understand how we are committed to protecting your privacy.'
        ]);
    }

    public function termAndCondition()
    {
        $this->sesDestroy();
        \Session::forget(['loginPOPUP', 'forgetPass']);
        return view('term-condition')->with([
            'title' => 'Permit Search Terms and Definitions',
            'description' => 'Read our terms and conditions and disclaimers for Permit Search. We are the leading in providing permit search history information and results.'
        ]);
    }

    public function contactus()
    {
        $this->sesDestroy();
        \Session::forget(['loginPOPUP', 'forgetPass']);
        $data = DB::table('Inquirey')->get();
        return view('contact-us')->with('data', $data)->with([
            'title' => 'Contact Permit Search',
            'description' => 'Need to speak to someone about your permit search? Contact us today to speak with a permit search respresentative.'
        ]);
    }

    public function redirectHome()
    {
        $g = 'yes';
        \Session::put('forgetPass', $g);
        return redirect('/');
    }

    public function getAllSearchRecords()
    {
        $value = Cache::rememberForever('search_data_cache', function () {
            return DB::table('search')
            ->orderBy('PropertyFullAddress', 'asc')
            ->get();
        });
    }

    public function searchPermit(Request $request)
    {
        $search = DB::table('search')
        ->where('PropertyFullAddress', 'LIKE', '%' . $request->input('data') . '%')
        ->orWhere('PropertyCity', 'LIKE', $request->input('data') . '%')
        ->orderBy('PropertyFullAddress', 'asc')->limit(100)
        ->get();
        $res = [];
        foreach ($search as $key => $value) {
            $res[$value->PropertyFullAddress][] = [
                'id' => Crypt::encrypt($value->PropertyFullAddress),
                'PropertyFullAddress' => $value->PropertyFullAddress,
            ];
        }
        if (!empty($res)) {
            return response()->json($res);
        } else {
            return "empty";
        }
    }

    // public function searchPermit(Request $request) {

    //     $search = Cache::get('search_data_cache');
    //     $res = [];
    //     foreach ($search as $key => $value) {
    //         if(@strstr($value->PropertyFullAddress, strtoupper($request->input('data')))
    //             || @strstr($value->PropertyCity, strtoupper($request->input('data')))
    //             || @strstr($value->PropertyFullAddress, $request->input('data'))
    //             || @strstr($value->PropertyCity, $request->input('data'))
    //         )
    //         {
    //             $res[$value->PropertyFullAddress][] = [
    //                 'id' => Crypt::encrypt($value->PropertyFullAddress),
    //                 'PropertyFullAddress' => $value->PropertyFullAddress
    //             ];
    //         }
    //     }
    //     if(!empty($res)){
    //         return response()->json($res);
    //     }else{
    //         return "empty";
    //     }
    // }

    public function searchPermitResult($id)
    {
        \Session::put('search_address_id', $id);
        $id = Crypt::decrypt($id);
        $filter = Search::where('PropertyFullAddress', $id)->get();
        $price = DB::table('pricing')->orderBy("plan_period", "desc")->get();
        $array = [];
        foreach ($filter as $key => $value) {
            $value->searchTitle = $value->PropertyFullAddress;
            // $array[] = $value->searchTitle.' '.$value->PropertyCity.' '.$value->PropertyState.' '.$value->PropertyZipCode;
            $array[] = $value->PropertyFullAddress;
            $array[$value->PermitStatus][] = $value;
        }
        \Session::put('search', $array);
        // echo "<pre>";print_r($array);die;
        if (Auth::guard('web')->check()) {
            return redirect('/dashboard/permit');
        } else {
            return view('table-blur')->with(['data' => $array, 'price' => $price]);
        }
    }
    public function searchPermitResultGoogleMapAPI(Request $request)
    {
        $searchAddress = str_replace(', USA', ' ', $request->input("searchNAME"));
        \Session::put('search_address_id', $searchAddress);
        
        if ($searchAddress) {
            $filter = Search::where('PropertyFullAddress', 'LIKE', '%' . $searchAddress . '%')->limit(1000)->get();
        }

        $array = $filter = [];
        foreach ($filter as $key => $value) {
            $value->searchTitle = $value->PropertyFullAddress;
            // $array[] = $value->searchTitle.' '.$value->PropertyCity.' '.$value->PropertyState.' '.$value->PropertyZipCode;
            $array[] = $value->PropertyFullAddress;
            $array[$value->PermitStatus][] = $value;
        }

        \Session::put('search', $array);
        // echo "<pre>";print_r($array);die;
        // if (Auth::guard('web')->check() && \Session::get('usePermit') > 0) {
        if (Auth::guard('web')->check()) {
            
            ## If search address is not present, insert into request permit page and place the address in reporting page as pending
            if (\Session::get('usePermit') > 0) {
                $updated = $this->updatePermitRequestBasedOnSearch($request, $array, $searchAddress);
                if ($updated) {
                    return redirect('/dashboard/permit/my-report/')->with('searchQuery', $searchAddress );
                } else {
                    return redirect('/dashboard/permit')->with('searchQuery', $searchAddress );
                }
                
            } else {
                return redirect('/dashboard/permit')->with('searchQuery', $searchAddress );
            }
            
        } else {
            $price = DB::table('pricing')->where("plan_period", "single")->get();
            return view('search-results')->with(['data' => $array, 'price' => $price, 'search' => $searchAddress,'zip_code' => $request->input("zip_code")]);
        }
    }

    protected function updatePermitRequestBasedOnSearch(Request $request, $array, $searchAddress) {
        if (count($array) === 0) {
            
            $user_id = Auth::guard('web')->user()->id;
            $payment = DB::table('payment')->where('user_id', $user_id)->offset(0)->limit(1)->orderBy('id', 'DESC')->get();

            if (!$payment->isEmpty()) {
                $purchasedPrice = DB::table('pricing')->where('id', $payment[0]->price_id)->get();

                $dataSet = [];
                $dataSet['user_id'] = $user_id;
                $dataSet['first_name'] = Auth::guard('web')->user()->name;
                $dataSet['last_name'] = '';
                $dataSet['email_address'] = Auth::guard('web')->user()->email;
                $dataSet['property_street_name'] = $request->input("property_street_name");
                $dataSet['property_city'] = $request->input("property_city");
                $dataSet['property_state'] = $request->input("property_state");
                $dataSet['zip_code'] = $request->input("zip_code");
                $dataSet['payment_id'] = $payment[0]->id;
                $dataSet['price_id'] = $payment[0]->price_id;
                $dataSet['status'] = '0';
                $dataSet['created_at'] = date('Y-m-d H:i:s', strtotime('+1  year'));
                $permitId = DB::table('permit_requests')->insert([$dataSet]);

                if ($searchAddress) {
                    $search_add_id = DB::table('search_address')->insertGetId(['user_id' => $user_id, 'search_name' => $searchAddress, 'price_id' => $payment[0]->price_id, 'payment_id' => $payment[0]->id, 'alarm' => -1, 'valid_upto' => date('Y-m-d', strtotime('+1  year'))]);
                    // $search_id = DB::table('search')->select('id')->where('search_name', $searchAddress)->first();
                    $reportObjId = DB::table('report')->insertGetId(['search_add_id' => $search_add_id, 'search_id' => 0, 'permit_request_id' => $permitId]);

                    return true;
                }

            }
        }
        return false;
    }

    public function getPriceDetails(Request $request)
    {
        $id = Crypt::decrypt($request->input('id'));
        $data = DB::table('pricing')->where('id', $id)->get();
        foreach ($data as $key => $value) {
            $value->id = Crypt::encrypt($value->id);
        }
        \Session::put('pricePlan', $data);
        return response()->json($data);
    }

    public function getFormDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'stripeToken' => ['required', 'string', 'max:255'],
            'priceIDVal' => ['required'],
        ]);

        $attributeNames = array(
            'name' => 'Name',
            'email' => 'Email',
            'Password' => 'Password',
            'stripeToken' => 'Card Info',
            'priceIDVal' => 'Price Plan',
        );

        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()) {
            $de = $validator->errors();
            \Session::put('blurSignErr', 'error');
            return redirect()->back()->withFail($de);
        } else {
            \Session::forget(['blurSignErr']);
            // echo "<pre>";print_r($request->all());die;
            $user = DB::table('users')->where('email', $request->input('email'))->get();
            if ($user->isEmpty()) {
                if ($request->input('password') == $request->input('password_confirmation')) {
                    $insert_id = DB::table('users')->insertGetId([
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'password' => Hash::make($request->input('password')),
                        'user_role_type' => (!empty($request->input("userTypeRadio")))?$request->input("userTypeRadio"):0,
                    ]);
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
                            $dataIs = ['phone' => $request->phone, 'address1' => $request->address1, 'address2' => $request->address2, 'country' => $request->country, 'state' => $request->state, 'city' => $request->city, 'contact' => $request->contact, 'user_image' => $fileNameToStore ,'company_logo' => $fileNameToStoreClogo ,'website_url' => $request->website_url ,'company_name' => $request->company_name, 'company_phone_no' => $request->company_phone_no , 'zipcode' => $request->zipcode];
                        } else {
                            $dataIs = [ 'phone' => $request->phone, 'address1' => $request->address1, 'address2' => $request->address2, 'country' => $request->country, 'state' => $request->state, 'city' => $request->city, 'contact' => $request->contact, 'user_image' => $fileNameToStore ,'website_url' => $request->website_url ,'company_name' => $request->company_name, 'company_phone_no' => $request->company_phone_no , 'zipcode' => $request->zipcode];
                        }
                    }else{
                        if ($request->hasFile('companyLogo')) {
                            $filenameWithExtc = $request->file('companyLogo')->getClientOriginalName();
                            $filenamec = pathinfo($filenameWithExtc, PATHINFO_FILENAME);
                            $extensionc = $request->file('companyLogo')->getClientOriginalExtension();
                            $fileNameToStoreClogo = $filenamec . '_' . time() . '.' . $extensionc;
                            $pathc = $request->file('companyLogo')->storeAs('public/images/users', $fileNameToStoreClogo);
                            $file_namec = $fileNameToStoreClogo;
                            $dataIs = [ 'phone' => $request->phone, 'address1' => $request->address1, 'address2' => $request->address2, 'country' => $request->country, 'state' => $request->state, 'city' => $request->city, 'contact' => $request->contact , 'website_url' => $request->website_url ,'company_name' => $request->company_name,'company_logo' => $fileNameToStoreClogo, 'company_phone_no' => $request->company_phone_no , 'zipcode' => $request->zipcode];
                        } else {
                            $dataIs = [ 'phone' => $request->phone, 'address1' => $request->address1, 'address2' => $request->address2, 'country' => $request->country, 'state' => $request->state, 'city' => $request->city, 'contact' => $request->contact , 'website_url' => $request->website_url ,'company_name' => $request->company_name, 'company_phone_no' => $request->company_phone_no , 'zipcode' => $request->zipcode];
                        }
                    }

                    $profileUpdate = DB::table('users')->where('id', $insert_id)->update($dataIs);
                    $amount = Pricing::where('id', Crypt::decrypt($request->priceIDVal))->first();
                    $secrete_key = config('app.STRIPE_SECRET');
                    Stripe\Stripe::setApiKey($secrete_key);
                    $check = DB::table('payment')->where('user_id', $insert_id)->get();
                    if ($check->isEmpty()) {
                        try {
                            $customer = Stripe\Customer::create(array(
                                'email' => $request->input('email'),
                                'source' => $request->stripeToken,
                            ));
                        } catch (Exception $e) {
                            $api_error = $e->getMessage();
                        }
                        if ($amount->plan_period != "single") {
                            // Creates a new plan
                            try {
                                $plan = Stripe\Plan::create(array(
                                    "product" => [
                                        "name" => $amount->title,
                                    ],
                                    "amount" => $amount->price * 100,
                                    "currency" => 'usd',
                                    "interval" => "month",
                                ));
                            } catch (Exception $e) {
                                $api_error = $e->getMessage();
                            }
                            if (empty($api_error) && $plan) {
                                // Creates a new subscription
                                try {
                                    if (isset($request->coupon_code)) {
                                        $subscription = Stripe\Subscription::create([
                                            "customer" => $customer->id,
                                            "items" => [["plan" => $plan->id]],
                                            "coupon" => $request->coupon_code,
                                        ]);
                                    } else {
                                        $subscription = Stripe\Subscription::create([
                                            "customer" => $customer->id,
                                            "items" => [["plan" => $plan->id]],
                                        ]);
                                    }
                                } catch (Exception $e) {
                                    $api_error = $e->getMessage();
                                }
                                if (empty($api_error) && $subscription) {
                                    // DATAbase Insert
                                    $subsData = $subscription->jsonSerialize();
                                    $payAarray = [
                                        'user_id' => $insert_id,
                                        'price_id' => $amount->id,
                                        'stripe_customer' => $customer->id,
                                        '_token' => $request->input('_token'),
                                    ];
                                    $payment_id = DB::table('payment')->insertGetId($payAarray);
                                    $subArray = [
                                        'payment_id' => $payment_id,
                                        'subscription_id' => $subsData['id'],
                                        'plan_id' => $subsData['plan']['id'],
                                        'plan_amount' => $subsData['plan']['amount'] / 100,
                                        'plan_currency' => $subsData['plan']['currency'],
                                        'plan_interval' => $subsData['plan']['interval'],
                                        'plan_interval_count' => $subsData['plan']['interval_count'],
                                        'plan_start' => date("Y-m-d H:i:s", $subsData['current_period_start']),
                                        'plan_end' => date("Y-m-d H:i:s", $subsData['current_period_end']),
                                        'status' => $subsData['status'],
                                        '_token' => $request->input('_token'),
                                    ];

                                    DB::table('subscription')->insertGetId($subArray);
                                    Auth::loginUsingId($insert_id);
                                    return redirect('/dashboard/account/subscription');
                                } else {
                                    $statusMsg = "Subscription creation failed! " . $api_error;
                                    echo "<pre>";
                                    print_r($statusMsg);
                                    die;
                                }
                            } else {
                                $statusMsg = "Plan creation failed! " . $api_error;
                                echo "<pre>";
                                print_r($statusMsg);
                                die;
                            }
                        } else {
                            $stripe = Stripe\Charge::create([
                                "customer" => $customer->id,
                                "amount" => $amount->price * 100,
                                "currency" => 'USD',
                            ]);
                            $payAarray = [
                                'user_id' => $insert_id,
                                'price_id' => $amount->id,
                                'stripe_customer' => $customer->id,
                                '_token' => $request->input('_token'),
                            ];
                            DB::table('payment')->insertGetId($payAarray);
                            Auth::loginUsingId($insert_id);
                            $deductCreditAmount = app('App\Http\Controllers\UserController')->creditRem();
                            Auth::loginUsingId($insert_id);
                            if (Session::get('search_address_id')) {
                                Session::forget('search_address_id');
                                return redirect('/dashboard/permit');
                            } else {
                                if (\Session::get('PermitRequestData') != null && \Session::get('usePermit') > 0) {
                                    $deductCreditAmount = app('App\Http\Controllers\UserController')->addUserReportSesion();
                                    return redirect('/dashboard/permit-requests?request=new');
                                }
                                return redirect('/');
                            }
                        }
                    }

                    Auth::loginUsingId($insert_id);
                    return redirect('/dashboard/permit');
                } else {
                    return redirect()->back()->withError('Password & Confirm password does not match.');
                }
            } else {
                return redirect()->back()->withError('Email already exists.');
            }
        }
    }

    public function getLoginDetails(Request $request)
    {
        $search = \Session::get('search');
        $user = DB::table('users')->where('email', $request->input('email'))->get();

        // print_r($user);die;
        if (!$user->isEmpty()) {
            if (\Hash::check($request->input('password'), $user[0]->password)) {
                Auth::loginUsingId($user[0]->id);
                $deductCreditAmount = app('App\Http\Controllers\UserController')->creditRem();
                if (\Session::get('PermitRequestData') != null) {
                    $deductCreditAmount = app('App\Http\Controllers\UserController')->addUserReportSesion();
                    return response()->json('permit-request-credits-handle');
                }
                return response()->json('success');
                // return redirect('/dashboard/permit');
            } else {
                return response()->json('error');
            }
        } else {
            // return redirect()->back()->withFfail('Email & password does not match.');
            return response()->json('error');
        }
    }

    public function contactUsForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'mobile' => ['required', 'string', 'max:11'],
            'enq' => ['required', 'string'],
            'des' => ['required'],
        ]);

        if ($validator->fails()) {
            $de = $validator->errors();
            return response()->json('error');
        } else {
            $array = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('mobile'),
                'inquiry' => $request->input('enq'),
                'description' => $request->input('des'),
                '_token' => $request->input('_token'),
            ];
            DB::table('contact_us')->insert($array);

            $email = $array['email'];
            $details = [
                'Name' => $array['name'],
                'subject' => 'Contact Us',
            ];
            \Mail::to($email)
            ->send(new ContactUsMail($details));

            return response()->json('success');
        }
    }

    public function getSubscription($id)
    {
        if (!Auth::check()) {
            \Session::put('loginPOPUP', 'login');
        }
        \Session::put('subscribe_id', $id);
        if (Auth::guard('web')->check()) {
            return redirect('/payment');
        } else {
            return redirect('/');
        }
    }

    public function chkEmailExists($email)
    {
        $user = DB::table('users')->where('email', $email)->first();
        if($user)
        {
            return 1;
        } else {
            return 0;
        }

    }

    public function getPaymentForm()
    {
        try {
            // if(\Session::has('loginPOPUP')){
            $sub_id = \Session::get('subscribe_id');
            $payment = DB::table('payment')->where('user_id', Auth::guard('web')->user()->id)->offset(0)->limit(1)->orderBy('id', 'DESC')->get();
            if (!$payment->isEmpty()) {
                $today = date("Y-m-d");
                $expire = date("Y-m-d", strtotime("+1 month", strtotime($payment[0]->created_at)));
                if ($today < $expire) {
                    $myReportPrimeReport =
                    DB::table('permit_requests')
                    ->where('user_id', Auth::guard('web')
                        ->user()->id)->whereIn('status', [0, 1])
                    ->where('payment_id', $payment[0]->id)
                    ->get()->count();
                    $myReportSearchAddress =
                    DB::table('search_address')
                    ->where('user_id', Auth::guard('web')
                        ->user()->id)->where('payment_id', $payment[0]->id)
                    ->get()->count();
                    $report = $myReportSearchAddress + $myReportPrimeReport;
                    $price = DB::table('pricing')->where('id', $payment[0]->price_id)->offset(0)->limit(1)->orderBy('id', 'DESC')->get();
                    if (!$price->isEmpty()) {
                        $reportt = explode(' ', $price[0]->report);
                        if ($reportt[0] == 'Unlimited') {
                            $reportt[0] = '10000';
                        }
                        $rem = $reportt[0] - $report;
                    } else {
                        $rem = 0;
                    }
                } else {
                    $rem = 0;
                }
            } else {
                $rem = 0;
            }
            if ($rem == 0) {
                $price = DB::table('pricing')->where('id', Crypt::decrypt($sub_id))->get();
                return view('payment')->with('data', $price);
            } else {
                return redirect('/pricing')->withFfail('You have already purchased a plan.');
            }
    } catch (Exception $e) {
        return redirect('/pricing')->withFfail('Something went wrong.');
                //dd($e);
    }
}

public function getPayentDetails(Request $request)
{
    if (!empty($request->input('_token'))) {
        $user = \Auth::user();
        $sub = Pricing::where('id', Crypt::decrypt($request->SBID))->first();
        $check = Payment::where('user_id', $user->id)->first();
        $secrete_key = config('app.STRIPE_SECRET');
        Stripe\Stripe::setApiKey($secrete_key);
            if (isset($check) && $check != null) {
                $customer = (object) [
                    'id' => $check->stripe_customer,
                ];
            } else {
                try {
                    $customer = Stripe\Customer::create(array(
                        'email' => $user->email,
                        'source' => $request->stripeToken,
                    ));
                } catch (Exception $e) {
                    $api_error = $e->getMessage();
                }
            }
            if ($sub->plan_period != "single") {
                // Creates a new plan
                try {
                    $plan = Stripe\Plan::create(array(
                        "product" => [
                            "name" => $sub->title,
                        ],
                        "amount" => $sub->price * 100,
                        "currency" => 'usd',
                        "interval" => "month",
                    ));
                } catch (Exception $e) {
                    $api_error = $e->getMessage();
                }
                if (empty($api_error) && $plan) {
                    // Creates a new subscription
                    try {
                        if (isset($request->coupon_code)) {
                            $subscription = Stripe\Subscription::create([
                                "customer" => $customer->id,
                                "items" => [["plan" => $plan->id]],
                                "coupon" => $request->coupon_code,
                            ]);
                        } else {
                            $subscription = Stripe\Subscription::create([
                                "customer" => $customer->id,
                                "items" => [["plan" => $plan->id]],
                            ]);
                        }
                    } catch (Exception $e) {
                        $api_error = $e->getMessage();
                    }
                    if (empty($api_error) && $subscription) {
                        // DATAbase Insert
                        $subsData = $subscription->jsonSerialize();
                        $payAarray = [
                            'user_id' => $user->id,
                            'price_id' => $sub->id,
                            'stripe_customer' => $customer->id,
                            '_token' => $request->input('_token'),
                        ];
                        $payment_id = Payment::insertGetId($payAarray);
                        $subArray = [
                            'payment_id' => $payment_id,
                            'subscription_id' => $subsData['id'],
                            'plan_id' => $subsData['plan']['id'],
                            'plan_amount' => $subsData['plan']['amount'] / 100,
                            'plan_currency' => $subsData['plan']['currency'],
                            'plan_interval' => $subsData['plan']['interval'],
                            'plan_interval_count' => $subsData['plan']['interval_count'],
                            'plan_start' => date("Y-m-d H:i:s", $subsData['current_period_start']),
                            'plan_end' => date("Y-m-d H:i:s", $subsData['current_period_end']),
                            'status' => $subsData['status'],
                            '_token' => $request->input('_token'),
                        ];
                        Subscription::insertGetId($subArray);
                        \Session::forget('loginPOPUP');
                        return redirect('/dashboard/account/subscription')->withSuccess('Payment successfully!');
                    } else {
                        $statusMsg = "Subscription creation failed! " . $api_error;
                        // echo "<pre>";print_r($statusMsg);die;
                    }
                } else {
                    $statusMsg = "Plan creation failed! " . $api_error;
                    // echo "<pre>";print_r($statusMsg);die;
                }
            } else {
                $stripe = Stripe\Charge::create([
                    "customer" => @$customer->id,
                    "amount" => @$sub->price * 100,
                    "currency" => 'USD',
                ]);
                $payAarray = [
                    'user_id' => $user->id,
                    'price_id' => $sub->id,
                    'stripe_customer' => $customer->id,
                    '_token' => $request->input('_token'),
                ];
                DB::table('payment')->insertGetId($payAarray);
                \Session::forget('loginPOPUP');
                $deductCreditAmount = app('App\Http\Controllers\UserController')->creditRem();
                if (\Session::get('buycredits')) {
                    \Session::forget('buycredits');
                    // return redirect('dashboard/permit')->withSuccess('Payment successfully!');
                    return redirect('dashboard/permit/my-report/')->withSuccess('Payment successfully!');
                } else {
                    if (\Session::get('PermitRequestData') != null && \Session::get('usePermit') > 0) {
                        $deductCreditAmount = app('App\Http\Controllers\UserController')->addUserReportSesion();
                        return redirect('/dashboard/permit-requests?request=new');
                        // return redirect('dashboard/permit-requests')->withSuccess('Permit Request sent successfully!');
                    }
                    return redirect('/dashboard/permit/my-report/');
                }
            }
        } else {
            return redirect('/payment');
        }
    }

    public function getSubsCancel()
    {
        $stripe = new \Stripe\StripeClient(
            'sk_test_51Iuz7eJLnrSaon0lrxPZ0IE9zebwpM0IzGEd1hazHutsZNb7zAu4XFZQLzuxvKKUE2duUrwej0kyrP7e8tm1RG0c00yj1xqEPE'
        );
        echo "<pre>";
        print_r($response);
    }

    /**
     * function to check that the given coupon is valid or not
     */
    public function validateCoupon(Request $request)
    {
        try {
            $secrete_key = config('app.STRIPE_SECRET');
            Stripe\Stripe::setApiKey($secrete_key);
            $total = '';
            $original_price = '';
            $coupon = \Stripe\Coupon::retrieve($request->coupon); //->toArray();
            $sub = Pricing::where('id', Crypt::decrypt($request->SBID))->first();
            if (isset($coupon->percent_off) && isset($sub)) {
                $original_price = $sub->price;
                $total = $sub->price * ($coupon->percent_off / 100);
            }
        } catch (Exception $e) {
            $api_error = $e->getMessage();
            return ['status' => 'false', 'message' => $api_error];
        }
        return ['status' => 'true', 'message' => '', 'original_price' => $original_price, 'updated_price' => $total];
    }

    public function approvePermitRequests($ids)
    {
        if (isset($ids) && $ids != null) {
            $idsArr = explode(',', $ids);
            $PermitRequestObj = new PermitRequest();
            $PermitRequestLoad = $PermitRequestObj->whereIn('id', $idsArr)->where('status', '!=', '2')->get();
            if ($PermitRequestLoad != null) {
                foreach ($PermitRequestLoad as $addressObj) {
                    $house_number = filter_var($addressObj['property_street_name'], FILTER_SANITIZE_NUMBER_INT);
                    $street_name = str_replace($house_number . ' ', '', $addressObj['property_street_name']);
                    $matchedAddressObj = Search::where('PropertyCity', 'LIKE', '%' . $addressObj['property_city'] . '%')
                    ->where('PropertyState', $addressObj['property_state'])
                    ->where('PropertyZipCode', $addressObj['zip_code'])
                    ->Where('PropertyHouseNumber', $house_number)
                    ->Where('PropertyStreetName', 'LIKE', '%' . $street_name . '%')
                    ->first();
                    if (isset($matchedAddressObj) && $matchedAddressObj != null) {
                        $SearchAddress['user_id'] = $addressObj->user_id;
                        $SearchAddress['search_name'] = $matchedAddressObj->PropertyFullAddress;
                        $SearchAddress['payment_id'] = $addressObj->payment_id;
                        $SearchAddress['price_id'] = $addressObj->price_id;
                        $SearchAddress['alarm'] = 0;
                        $SearchAddress['valid_upto'] = date("Y-m-d H:i:s", strtotime("+1 month", strtotime($addressObj->created_at)));
                        $SearchAddress['created_at'] = date("Y-m-d H:i:s");
                        $SearchAddress['updated_at'] = date("Y-m-d H:i:s");
                        $SearchAddress['deleted_at'] = date("Y-m-d H:i:s");
                        $UpdatedAddressId = SearchAddress::insertGetId($SearchAddress);
                        if ($UpdatedAddressId) {
                            Report::insertGetId(['search_add_id' => $UpdatedAddressId, 'search_id' => $matchedAddressObj->id]);

                            PermitRequest::where('id', $addressObj->id)->update(['status' => '2', 'flag' => "Address Matched and approved"]);

                            try {
                                \Mail::to($addressObj->email_address)->send(new PermitRequestApproveNotifyMail($addressObj));
                            } catch (Exception $e) {
                                // dd($e);
                            }
                        }
                    } else {
                        $NotMatchAddress[] = $addressObj->id;
                        PermitRequest::where('id', $addressObj->id)->update(['status' => '1', 'flag' => "Address Not Matched"]);
                    }
                }
                //success matched
                if (isset($NotMatchAddress) && @count($NotMatchAddress) > 0) {
                    return 2;
                } else {
                    return 1;
                }
            } else {
                //not matched
                return 3;
            }
        }
        return http_response_code(404);
    }

    public function permitRequestFilesUpload($permt_req_id, Request $request)
    {
        // Handle file Upload
        if ($request->hasFile('upload_docs')) {
            $filenameWithExt = $request->file('upload_docs')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('upload_docs')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('upload_docs')->storeAs('public/upload_docs', $fileNameToStore);
            $read_excel = Excel::toArray([], $path);
            $excel_headers = "";
            $payAarray = [
                'permit_request_id' => $permt_req_id,
                'file_name' => $fileNameToStore,
                'created_at' => date("Y-m-d h:i:m"),
            ];
            $uploadedFileId = DB::table('permit_request_files')->insertGetId($payAarray);
            if (isset($read_excel[0][1]) && !empty($read_excel[0][1])) {
                $excel_headers = $read_excel[0][0];
                unset($read_excel[0][0]);
                foreach ($read_excel as $key_data => $row) {
                    $date_status = $row[$key_data + 1][25];
                    $date1 = ($row[$key_data + 1][25] - 25569) * 86400;
                    $date_status = date('Y-m-d', $date1);
                    $date2 = ($row[$key_data + 1][26] - 25569) * 86400;
                    $date_effective = date('Y-m-d', $date2);
                    $fullAddressString = strtoupper($row[$key_data + 1][5] . ', ' . $row[$key_data + 1][14] . ', ' . $row[$key_data + 1][15] . ' ' . $row[$key_data + 1][16]);
                    $array = [
                        'MasterPermitID' => $row[$key_data + 1][0],
                        'SourceID' => $row[$key_data + 1][1],
                        'SourcePermitID' => $row[$key_data + 1][2],
                        'FIPSCode' => $row[$key_data + 1][3],
                        'Location' => strtoupper($row[$key_data + 1][4]),
                        'PropertyFullAddress' => $fullAddressString,
                        'PropertyHouseNumberPrefix' => $row[$key_data + 1][6],
                        'PropertyHouseNumber' => $row[$key_data + 1][7],
                        'PropertyHouseNumberSuffix' => strtoupper($row[$key_data + 1][8]),
                        'PropertyDirection' => strtoupper($row[$key_data + 1][9]),
                        'PropertyStreetName' => strtoupper($row[$key_data + 1][10]),
                        'PropertyMode' => strtoupper($row[$key_data + 1][11]),
                        'PropertyQuadrant' => $row[$key_data + 1][12],
                        'PropertyUnitNumber' => $row[$key_data + 1][13],
                        'PropertyCity' => strtoupper($row[$key_data + 1][14]),
                        'PropertyState' => strtoupper($row[$key_data + 1][15]),
                        'PropertyZipCode' => $row[$key_data + 1][16],
                        'PropertyZipCodePlusFour' => $row[$key_data + 1][17],
                        'PermitNumber' => (string) $row[$key_data + 1][18],
                        'ProjectName' => $row[$key_data + 1][19],
                        'PermitType' => $row[$key_data + 1][20],
                        'PermitSubType' => $row[$key_data + 1][21],
                        'PermitClass' => $row[$key_data + 1][22],
                        'PermitDescription' => $row[$key_data + 1][23],
                        'PermitStatus' => $row[$key_data + 1][24],
                        'PermitStatusDate' => $date_status,
                        'PermitEffectiveDate' => $date_effective,
                        'PermitJobValue' => $row[$key_data + 1][27],
                        'PermitFee' => $row[$key_data + 1][28],
                        'ApplicantName' => $row[$key_data + 1][29],
                        '_token' => "",
                    ];

                    // check search table
                    $arrayObj = Search::where('PropertyCity', 'like', '%' . $array['PropertyCity'] . '%')
                    ->where('PropertyStreetName', 'like', '%' . $array['PropertyStreetName'] . '%')
                    ->where('PropertyState', 'like', '%' . $array['PropertyState'] . '%')
                    ->where('PropertyZipCode', 'like', '%' . $array['PropertyZipCode'] . '%');

                    $checkData = $arrayObj->first();
                    if (empty($checkData) && !isset($checkData)) { // excel search record not found
                        $statusInsertData = Search::insertGetId($array);
                        $searchId = $statusInsertData;
                    } else {
                        $statusInsertData = $arrayObj->update($array);
                        $searchId = $checkData->id;
                    }
                    if (isset($statusInsertData) && !empty($statusInsertData)) {
                        // check into permit search table
                        $permit_request = PermitRequest::where('property_street_name', 'like', '%' . $array['PropertyStreetName'] . '%')
                        ->where('property_city', 'like', '%' . $array['PropertyCity'] . '%')
                        ->where('property_state', 'like', '%' . $array['PropertyState'] . '%')
                        ->where('zip_code', 'like', '%' . $array['PropertyZipCode'] . '%')->where('status', '!=', 2)
                        ->first();
                        // if both search and permit request address match then add permit req file id to permit_requests and approve the status and send email
                        if (isset($permit_request) && !empty($permit_request)) { // permit request also found insert

                            $SearchAddress['user_id'] = $permit_request->user_id;
                            $SearchAddress['search_name'] = $array['PropertyFullAddress'];
                            $SearchAddress['payment_id'] = $permit_request->payment_id;
                            $SearchAddress['price_id'] = $permit_request->price_id;
                            $SearchAddress['alarm'] = 0;
                            $SearchAddress['valid_upto'] = date("Y-m-d H:i:s", strtotime("+1 month", strtotime($permit_request->created_at)));
                            $SearchAddress['created_at'] = date("Y-m-d H:i:s");
                            $SearchAddress['updated_at'] = date("Y-m-d H:i:s");
                            $SearchAddress['deleted_at'] = date("Y-m-d H:i:s");

                            $UpdatedAddressId = SearchAddress::insertGetId($SearchAddress);

                            // if permit request is different then add file for that permit requests
                            if ($permt_req_id != $permit_request->id) {
                                $payAarrayNew = [
                                    'permit_request_id' => $permit_request->id,
                                    'file_name' => $fileNameToStore,
                                    'created_at' => date("Y-m-d h:i:m"),
                                ];

                                $uploadedFileId = DB::table('permit_request_files')->insertGetId($payAarrayNew);
                            }
                            //reflects in reports
                            Report::insertGetId(['search_add_id' => $UpdatedAddressId, 'search_id' => $searchId]);
                            //update permit requests
                            PermitRequest::where('id', $permit_request->id)->update(['status' => '2', 'permit_req_file_id' => $uploadedFileId, 'flag' => "Address Matched and approved"]);
                            $admin_user = Admin::first();
                            $mail_data = [
                                'from_email' => env('MAIL_FROM_ADDRESS', 'demo@yopmail.com'),
                                'from_name' => env('APP_NAME', 'Test Project Name'),
                                'to_email' => (isset($admin_user, $admin_user->email) && !empty($admin_user)) ? $admin_user->email : "admin@yopmail.com",
                                'to_name' => (isset($admin_user, $admin_user->name) && !empty($admin_user)) ? $admin_user->name : "Admin",
                                'title' => 'Permit Search Uploaded Address Document Verified',
                                'subject' => 'Permit Search Address Approve',
                                'body' => "Your uploaded $fileNameToStore document address are verified...! and Approved status",
                            ];
                            try {
                                \Mail::to($mail_data['to_email'])->send(new AddressApproveSendMail($mail_data));
                                \Mail::to($permit_request->email_address)->send(new PermitRequestApproveNotifyMail($permit_request));
                            } catch (Exception $e) {
                                // dd($e);
                            }
                        }
                    }

                } // Loops Ends
            }
            if ($uploadedFileId) {
                return 1;
            }
        } else {
            return 'file not found';
        }
    }

    public function permitRequestStatusUpdate(Request $request,$permt_req_id, $status )
    {
        PermitRequest::where('id', $permt_req_id)->update(['status' => $status]);
        $permit = PermitRequest::find($permt_req_id);
        \Mail::to($permit->email_address)->send(new PermitRequestApproveNotifyMail($permit));
        return 1;
    }

    public function loadPermitRequestFiles($permt_req_id)
    {
        return DB::table('permit_request_files')
        ->select('*', 'permit_requests.permit_req_file_id as success_file_id', 'permit_request_files.file_name as file_name', 'permit_request_files.id as file_id')
        ->leftJoin('permit_requests', 'permit_request_files.id', 'permit_requests.permit_req_file_id')
        ->where('permit_request_files.permit_request_id', $permt_req_id)->orderByDesc('permit_request_files.id')->get();
    }

    public function permitAdminNotification(Request $request)
    {
        $type = $request->type;
        $body = "Customer Name : `" . Auth::user()->name . "` and Email : `" . Auth::user()->email . "` is trying to searching the address `" . $request->searchPR . "` but unable to found our database please check it once..!";
        if (isset($type) && $type == "success") {
            $body = "Customer Name : `" . Auth::user()->name . "` and Email : `" . Auth::user()->email . "` is trying to searching the address `" . $request->searchPR . "` has successfully found address to our database please check it once..!";
        }
        $admin_user = Admin::first();
        // Email Start
        $mail_data = [
            'from_email' => env('MAIL_FROM_ADDRESS', 'demo@yopmail.com'),
            'from_name' => env('APP_NAME', 'Test Project Name'),
            'to_email' => (isset($admin_user, $admin_user->email) && !empty($admin_user)) ? $admin_user->email : "admin@yopmail.com",
            'to_name' => (isset($admin_user, $admin_user->name) && !empty($admin_user)) ? $admin_user->name : "Admin",
            'title' => 'Permit Search Result Notification',
            'subject' => 'Permit Search : Admin Notify',
            'body' => $body,
        ];
        try {
            \Mail::to($mail_data['to_email'])->send(new AdminNotificationSendMail($mail_data));
        } catch (Exception $e) {
            // dd($e);
        }

    }
}
