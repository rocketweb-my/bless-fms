<?php

namespace App\Http\Controllers;

use App\Models\BanIP;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BanIPController extends Controller
{
    public function index(Request $request){


        if ($request->ajax()) {
            $data = BanIP::orderBy('ip_from', 'ASC')->get();
            //Datatable

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('ip_range', function ($data) {

                    if ($data->ip_from == $data->ip_to)
                    {
                        return long2ip($data->ip_from);
                    }
                    else{
                        return long2ip($data->ip_from). ' - ' .long2ip($data->ip_to);
                    }
                })
                ->addColumn('ban_by', function ($data) {

                    $banned_by = findUser($data->banned_by);
                    if ($banned_by == null)
                    {
                        return '';
                    }
                    else{
                        return $banned_by->name;
                    }
                })
                ->addColumn('date', function ($data) {
                        return Carbon::parse($data->dt)->format('d-m-Y H:m:s');
                })
                ->addColumn('action', function ($data) {
                    if(user()->isadmin == 1 ||userPermissionChecker('can_unban_ips') == true)
                    {
                        $link = '<button class="btn btn-icon btn-danger" data-id="'.$data->id.'" id="delete"><i class="fa fa-trash-o"></i></button>';
                    }else{
                        $link = '';

                    }

                    return $link;
                })


                ->rawColumns(['ip_range','ban_by','date','action'])
                ->make(true);
        }

        return view('pages.ban_ip');

    }

    public function store(Request $request)
    {

        $request->validate([
            'ip' => 'required',
        ]);

        // Get the ip
        $ip = preg_replace('/[^0-9\.\-\/\*]/', '', $request->ip);
        $ip_display = str_replace('-', ' - ', $ip);

        // Convert asterisk to ranges
        if ( strpos($ip, '*') !== false )
        {
            $ip = str_replace('*', '0', $ip) . '-' . str_replace('*', '255', $ip);
        }

        $ip_regex = '(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])';

        // Is this a single IP address?
        if ( preg_match('/^'.$ip_regex.'$/', $ip) )
        {
            $ip_from = ip2long($ip);
            $ip_to   = $ip_from;
        }
        // Is this an IP range?
        elseif ( preg_match('/^'.$ip_regex.'\-'.$ip_regex.'$/', $ip) )
        {
            list($ip_from, $ip_to) = explode('-', $ip);
            $ip_from = ip2long($ip_from);
            $ip_to   = ip2long($ip_to);
        }
        // Is this an IP with CIDR?
        elseif ( preg_match('/^'.$ip_regex.'\/([0-9]{1,2})$/', $ip, $matches) && $matches[4] >= 0 && $matches[4] <= 32)
        {
            list($ip_from, $ip_to) = $this->cidr_to_range($ip);
        }
        // Not a valid input
        else
        {
            return redirect()->back()->withErrors('Enter the IP address or range you wish to ban.');
        }

        if ($ip_from === false || $ip_to === false)
        {
            return redirect()->back()->withErrors('Enter the IP address or range you wish to ban.');
        }

        // Make sure we have valid ranges
        if ($ip_from < 0)
        {
            $ip_from += 4294967296;
        }
        elseif ($ip_from > 4294967296)
        {
            $ip_from = 4294967296;
        }
        if ($ip_to < 0)
        {
            $ip_to += 4294967296;
        }
        elseif ($ip_to > 4294967296)
        {
            $ip_to = 4294967296;
        }

        // Make sure $ip_to is not lower that $ip_from
        if ($ip_to < $ip_from)
        {
            $tmp    = $ip_to;
            $ip_to   = $ip_from;
            $ip_from = $tmp;
        }

        $check_ip = BanIP::whereRaw('? between ip_from and ip_to', [$ip_from])->whereRaw('? between ip_from and ip_to', [$ip_to])->first();

        if ($check_ip != null)
        {
            return redirect()->back()->withErrors('Note: The IP range '.long2ip($ip_from).' - '.long2ip($ip_to).' is already banned.');
        }

        // Delete any duplicate banned IP or ranges that are within the new banned range
        BanIP::where('ip_from', '>=', $ip_from)->where('ip_to', '<=', $ip_to)->delete();


        // Delete temporary bans from logins table // KIV

        BanIP::create([
            'ip_from' => $ip_from,
            'ip_to' => $ip_to,
            'ip_display' => $request->ip,
            'banned_by' => User()->id,
        ]);


        flash('IP Successfully Banned', 'success');
        // toastr()->success('IP Successfully Banned', 'Success');
        return redirect()->back();

    }

    public function store_from_reply_page(Request $request)
    {

        $request->validate([
            'ip' => 'required',
        ]);

        // Get the ip
        $ip = preg_replace('/[^0-9\.\-\/\*]/', '', $request->ip);
        $ip_display = str_replace('-', ' - ', $ip);

        // Convert asterisk to ranges
        if ( strpos($ip, '*') !== false )
        {
            $ip = str_replace('*', '0', $ip) . '-' . str_replace('*', '255', $ip);
        }

        $ip_regex = '(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])';

        // Is this a single IP address?
        if ( preg_match('/^'.$ip_regex.'$/', $ip) )
        {
            $ip_from = ip2long($ip);
            $ip_to   = $ip_from;
        }
        // Is this an IP range?
        elseif ( preg_match('/^'.$ip_regex.'\-'.$ip_regex.'$/', $ip) )
        {
            list($ip_from, $ip_to) = explode('-', $ip);
            $ip_from = ip2long($ip_from);
            $ip_to   = ip2long($ip_to);
        }
        // Is this an IP with CIDR?
        elseif ( preg_match('/^'.$ip_regex.'\/([0-9]{1,2})$/', $ip, $matches) && $matches[4] >= 0 && $matches[4] <= 32)
        {
            list($ip_from, $ip_to) = $this->cidr_to_range($ip);
        }
        // Not a valid input
        else
        {
            return redirect()->back()->withErrors('Enter the IP address or range you wish to ban.');
        }

        if ($ip_from === false || $ip_to === false)
        {
            return redirect()->back()->withErrors('Enter the IP address or range you wish to ban.');
        }

        // Make sure we have valid ranges
        if ($ip_from < 0)
        {
            $ip_from += 4294967296;
        }
        elseif ($ip_from > 4294967296)
        {
            $ip_from = 4294967296;
        }
        if ($ip_to < 0)
        {
            $ip_to += 4294967296;
        }
        elseif ($ip_to > 4294967296)
        {
            $ip_to = 4294967296;
        }

        // Make sure $ip_to is not lower that $ip_from
        if ($ip_to < $ip_from)
        {
            $tmp    = $ip_to;
            $ip_to   = $ip_from;
            $ip_from = $tmp;
        }

        $check_ip = BanIP::whereRaw('? between ip_from and ip_to', [$ip_from])->whereRaw('? between ip_from and ip_to', [$ip_to])->first();

        if ($check_ip != null)
        {
            return redirect()->back()->withErrors('Note: The IP range '.long2ip($ip_from).' - '.long2ip($ip_to).' is already banned.');
        }

        // Delete any duplicate banned IP or ranges that are within the new banned range
        BanIP::where('ip_from', '>=', $ip_from)->where('ip_to', '<=', $ip_to)->delete();


        // Delete temporary bans from logins table // KIV

        BanIP::create([
            'ip_from' => $ip_from,
            'ip_to' => $ip_to,
            'ip_display' => $request->ip,
            'banned_by' => User()->id,
        ]);


        flash('IP Successfully Banned', 'success');
        return response()->json(['success'=>'Ajax request submitted successfully']);


    }

    public function cidr_to_range($cidr)
    {
        $range = array();
        $cidr = explode('/', $cidr);
        $range[0] = (ip2long($cidr[0])) & ((-1 << (32 - (int)$cidr[1])));
        $range[1] = (ip2long($cidr[0])) + pow(2, (32 - (int)$cidr[1])) - 1;
        return $range;
    } // END hesk_cidr_to_range()

    public function delete(Request $request)
    {
        $ip = BanIP::find($request->id);
        $ip->delete();

        flash('IP Successfully Deleted', 'success');
        return redirect()->back();
    }
}
