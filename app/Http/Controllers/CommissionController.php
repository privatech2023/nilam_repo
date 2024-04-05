<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\commissions;
use App\Models\groups;
use App\Models\upline;
use App\Models\User;
use App\Models\user_clients;
use App\Models\user_groups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class CommissionController extends Controller
{
    public function index()
    {
        $commissionGroups = commissions::join('groups', 'commissions.group_id', '=', 'groups.id')
            ->select('commissions.*', 'groups.group_name')
            ->orderBy('created_at', 'desc')
            ->get();
        $groups = groups::where('permissions', 'LIKE', '%commissionYes%')->get();
        return view('frontend.admin.pages.commission.index')->with(['commissions' => $commissionGroups, 'groups' => $groups]);
    }

    public function index_earning_users()
    {
        $upline_data = [];
        $direct_data = [];

        $upline_all = upline::all();
        foreach ($upline_all as $u) {
            $group1 = user_groups::where('g_id', $u->upline_id)->get();
            foreach ($group1 as $g1) {
                $data = User::where('id', $g1->u_id)->first();
                $upline_data[] = [
                    'user_id' => $data->id,
                    'user_name' => $data->name
                ];
            }
        }

        $group2 = groups::where('permissions', 'LIKE', '%commissionYes%')->get();
        foreach ($group2 as $g2) {
            $users = user_groups::where('g_id', $g2->id)->get();
            foreach ($users as $u) {
                $data2 = User::where('id', $u->u_id)->first();
                $direct_data[] = [
                    'user_id' => $data2->id,
                    'user_name' => $data2->name
                ];
            }
        }
        return view('frontend.admin.pages.commission.pay')->with(['upline' => $upline_data, 'directs' => $direct_data]);
    }

    public function create_commission(Request $request)
    {
        $validatedData =  Validator::make($request->all(), [
            'amount' => 'required',
        ]);
        if ($validatedData->fails()) {
            Session::flash('error', $validatedData->errors());
            return redirect()->back();
        } else {
            $commission = new commissions();
            $commission->group_id = $request->role;
            $commission->commission = $request->amount;
            $commission->save();
            Session::flash('success', 'Commission created successfully');
            return redirect()->back();
        }
    }

    public function delete(Request $request)
    {
        $data = commissions::find($request->input('id'))->first();
        $data->delete();
        Session::flash('success', 'Commission deleted successfully');
        return redirect()->back();
    }

    // distribute new clients
    public function distribute_clients($ids)
    {
        $groups = groups::where('permissions', 'LIKE', '%commissionYes%')->get();
        $user_list = [];
        $iterate_count = 1;
        if (!$groups->isEmpty()) {
            $groupIds = $groups->pluck('id')->toArray();
            $users = user_groups::whereIn('g_id', $groupIds)->get();
            if (!$users->isEmpty()) {
                $user_count = count($users);
                $this->loop_iterate($users, $ids, $iterate_count, $user_count);
            }
            return 1;
        } else {
            return 0;
        }
        return;
    }

    public function loop_iterate($users, $client_ids, $iterate_count, $user_count)
    {
        for ($i = 0; $i <= count($users); $i++) {
            $data = user_clients::all();
            if ($data->isEmpty()) {
                user_clients::create([
                    'user_id' => $users[$i]->id,
                    'client_id' => $client_ids,
                    'flag' => 1
                ]);
                return;
            } else {
                $find_flag = user_clients::where('flag', 1)->first();
                $index = array_search($find_flag->user_id, $users->pluck('id')->toArray());
                if ($index !== false) {
                    user_clients::where('flag', 1)->where('user_id', $find_flag->user_id)->update(['flag' => 0]);
                    if (!isset($users[$index + 1])) {
                        user_clients::create([
                            'user_id' => $users[0]->id,
                            'client_id' => $client_ids,
                            'flag' => 1
                        ]);
                    } else {
                        user_clients::create([
                            'user_id' => $users[$index + 1]->id,
                            'client_id' => $client_ids,
                            'flag' => 1
                        ]);
                    }
                }
                return;
            }
        }
    }


    // distibute old clients
    public function distribute_clients_old()
    {
        $groups = groups::where('permissions', 'LIKE', '%commissionYes%')->get();
        $groupIds = $groups->pluck('id')->toArray();
        $users = user_groups::whereIn('g_id', $groupIds)->get();
        $client_ids = clients::pluck('client_id')->toArray();
        $user_count = count($users);

        $this->test($users, $client_ids, $user_count);
        return redirect()->back();
    }

    public function test($users, $client_ids, $user_count)
    {
        for ($i = 0; $i <= $user_count; $i++) {
            if (empty($client_ids)) {
                return true;
            }
            $client_id = array_shift($client_ids);
            $existingEntry = user_clients::where('user_id', $client_id)
                ->first();
            if ($existingEntry == null) {
                if (count($client_ids) == 0) {
                    user_clients::create([
                        'user_id' => $users[$i]->id,
                        'client_id' => $client_id,
                        'flag' => 1
                    ]);
                } else {
                    user_clients::create([
                        'user_id' => $users[$i]->id,
                        'client_id' => $client_id
                    ]);
                }
            }
            if (!isset($users[$i + 1])) {
                $i = 0 - 1;
            }
        }
    }
}
