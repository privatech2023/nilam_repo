<?php

namespace App\Http\Controllers;

use App\Models\activation_codes;
use App\Models\clients;
use App\Models\coupons;
use App\Models\groups;
use App\Models\invoice;
use App\Models\packages;
use App\Models\roles;
use App\Models\transactions;
use App\Models\User;
use App\Models\user_groups;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class adminController extends Controller
{
    public function index()
    {
             $query1 = DB::table('clients')
            ->select(DB::raw('(SELECT COUNT(*) FROM subscriptions WHERE subscriptions.client_id = clients.client_id AND subscriptions.ends_on >= NOW()) as subscription'))
            ->get();
        $query2 = DB::table('clients')
            ->select('clients.client_id', 'clients.name', 'clients.mobile_number', 'clients.email', 'clients.status', 'subscriptions.status as subscription')
            ->leftJoin('subscriptions', function ($join) {
                $join->on('clients.client_id', '=', 'subscriptions.client_id');
            })
            ->where('subscriptions.status', 1)
            ->where('subscriptions.ends_on', '>=', date('Y-m-d'))
            ->groupBy('clients.client_id', 'clients.name', 'clients.mobile_number', 'clients.email', 'clients.status', 'subscriptions.status');
        $query3 = DB::table('clients')
            ->select('clients.client_id', 'clients.name', 'clients.mobile_number', 'clients.email', 'clients.status')
            ->leftJoin('subscriptions', function ($join) {
                $join->on('clients.client_id', '=', 'subscriptions.client_id')
                    ->where('subscriptions.validity_days', null);
            })
            ->havingRaw('COUNT(subscriptions.client_id) > 0')
            ->groupBy('clients.client_id', 'clients.name', 'clients.mobile_number', 'clients.email', 'clients.status', 'subscriptions.status');
        $query4 = DB::table('clients')
            ->select('clients.client_id', 'clients.name', 'clients.mobile_number', 'clients.email', 'clients.status')
            ->leftJoin('subscriptions', function ($join) {
                $join->on('clients.client_id', '=', 'subscriptions.client_id')
                    ->where('subscriptions.ends_on', '<', date('Y-m-d'));
            })
            ->havingRaw('COUNT(subscriptions.client_id) > 0')
            ->groupBy('clients.client_id', 'clients.name', 'clients.mobile_number', 'clients.email', 'clients.status', 'subscriptions.status');
            $total_count_all = $query1->toArray();
        $total_count_active = $query2->get();
        $total_count_pending = $query3->get();
        $total_count_expired = $query4->get();
        $transactions = transactions::all();
        $packages = packages::all();
        $activation_codes = activation_codes::count(); 
        
        $coupons = coupons::all();
        return view('frontend.admin.dashboard')->with([
            'transactions' => count($transactions),
            'packages' => count($packages),
            'activation_codes' => $activation_codes,
            'coupons' => count($coupons),
            'allClients' => count($total_count_all),
            'activeClients' => count($total_count_active),
            'pendingClients' => count($total_count_pending),
            'expiredClients' => count($total_count_expired)
        ]);
       
    }

    public function login_index()
    {
        return view('frontend.admin.auth.login');
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $credentials['email'])->first();
            
            if ($user && password_verify($credentials['password'], $user->password)) {
                $request->session()->put('admin_id', $user->id);
                $request->session()->put('admin_name', $user->name);
                $group = user_groups::where('u_id', $user->id)->first();
                $permissions = groups::where('id', $group->g_id)->first();
                $unserializedPermissions = unserialize($permissions->permissions);
                session(['user_permissions' => $unserializedPermissions]);
                return redirect('/admin')->with('success', 'Login successful');
            } else {
                Log::info('Login failed for email: ' . $credentials['email']);
                return redirect()->back()->withErrors(['error' => 'Invalid credentials'])->withInput();
            }
        } catch (\Exception $e) {
            Log::error('Error during login: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'An error occurred. Please try again.'])->withInput();
        }
    }
    public function logout()
    {
        Session::flush();
        return Redirect::to('/');
    }

    public function roles()
    {
        $data = groups::all();
        return view('frontend.admin.pages.roles.index')->with(['data' => $data]);
    }

    public function create_roles()
    {
        $data = groups::all();
        return view('frontend.admin.pages.roles.create-roles')->with(['data' => $data]);
    }


    public function roleNameByID($role)
    {
        $group = groups::select('group_name')->where('id', $role)->first();

        return $group ? $group->group_name : null;
    }

    public function profile_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'mobile_number' => 'required|numeric',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|same:password',
        ]);

        if ($validator->fails()) {
            $data = User::where('id', $request->input('id'))
                ->first();
            Session::flash('error', $validator->errors());
            return view('frontend.admin.pages.profile.index')->with(['data' => $data]);
        }
        // Find the user by ID
        $user = User::find($request->input('id'));

        if (!$user) {
            $data = User::where('id', $request->input('id'))
                ->first();
            return view('frontend.admin.pages.profile.index')->with(['data' => $data]);
        }

        // Update the user
        $user->name = $request->input('name');
        $user->mobile = $request->input('mobile_number');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        $data = User::where('id', $request->input('id'))
            ->first();
        Session::flash('success', 'Updated credentials');
        return view('frontend.admin.pages.profile.index')->with(['data' => $data]);
    }

    public function profile($id)
    {
        $data = User::where('id', $id)
            ->first();
        return view('frontend.admin.pages.profile.index')->with(['data' => $data]);
    }

    public function test_api()
    {
        return view('frontend.admin.pages.test-api');
    }

    public function invoice($id)
    {
        $frontend = new frontendController;
        $data['gst_rate'] = $frontend->getSettings('gst_rate');

        $txn = transactions::where('txn_id', $id)->first();

        if ($txn->txn_mode != 'MANUAL') {
            if ($txn->package_id == null) {
                $validity =  $txn->plan_valdity_days;
                $v = packages::where('duration_in_days', $validity)->first();
                if ($v == null) {
                    $product = 'PRIVATECH PACKAGE(ACTIVATION CODE)';
                } else {
                    $product = $v->name;
                }
            } else {
                $product = $txn->package_name;
            }
        } else {
            $product =  'SPECIAL PACK';
        }


        $client = clients::where('client_id', $txn->client_id)->first();

        $check_invoice = invoice::where('txn_id', $id)->first();
        if ($check_invoice != null) {
            return view('invoice-print', $data)->with(['txn' => $txn, 'client' => $client, 'invoice' => $check_invoice, 'product' => $product]);
        } else {
            $latestInvoice = invoice::orderBy('id', 'desc')->first();
            $invoiceNumber = $latestInvoice ? intval($latestInvoice->invoice_number) + 1 : 1000;

            $invoice = new invoice();
            $invoice->invoice_number = $invoiceNumber;
            $invoice->txn_id = $id;
            $invoice->client_id = $txn->client_id;
            $invoice->invoice_date = now();
            $invoice->billing_date = Carbon::parse($txn->updated_at)->toDateString();
            $invoice->total_amount = $txn->paid_amt;
            $invoice->save();

            return view('invoice-print', $data)->with(['txn' => $txn, 'client' => $client, 'invoice' => $invoice, 'product' => $product]);
        }
    }

    public function client_print(Request $request)
    {
        $tableData = $request->input('tableData');
        return response()->json($tableData);
    }

    public function client_print_view(Request $request)
    {
        $tableData = json_decode($request->input('tableData'));
        return view('clients-print', ['tableData' => $tableData]);
    }
}
