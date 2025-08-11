<?php

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use App\Models\Category;


if (! function_exists('checkPermission')) {
    function checkPermission($feature)
    {
        if (Session::exists('isadmin') && Session::get('isadmin') != null) {
            //Admins have full access to all features//
            return true;
        }

        /* Check other staff for permissions */
        if (Session::exists('privileges') && strpos(Session::get('privileges'), $feature) === false) {
            // No permission //
            return false;
        } else {
            return true;
        }
    }
}

if (! function_exists('replyTimer')) {
    function replyTimer($in)
    {
        $in = trim($in);

        /* If everything is OK this simple check should return true */
        if ( preg_match('/^([0-9]{2,3}):([0-5][0-9]):([0-5][0-9])$/', $in) )
        {
            return $in;
        }

        /* No joy, let's try to figure out the correct values to use... */
        $h = 0;
        $m = 0;
        $s = 0;

        /* How many parts do we have? */
        $parts = substr_count($in, ':');

        switch ($parts)
        {
            /* Only two parts, let's assume minutes and seconds */
            case 1:
                list($m, $s) = explode(':', $in);
                break;

            /* Three parts, so explode to hours, minutes and seconds */
            case 2:
                list($h, $m, $s) = explode(':', $in);
                break;

            /* Something other was entered, let's assume just minutes */
            default:
                $m = $in;
        }

        /* Make sure all inputs are integers */
        $h = intval($h);
        $m = intval($m);
        $s = intval($s);

        /* Convert seconds to minutes if 60 or more seconds */
        if ($s > 59)
        {
            $m = floor($s / 60) + $m;
            $s = intval($s % 60);
        }

        /* Convert minutes to hours if 60 or more minutes */
        if ($m > 59)
        {
            $h = floor($m / 60) + $h;
            $m = intval($m % 60);
        }

        /* MySQL accepts max time value of 838:59:59 */
        if ($h > 838)
        {
            return '838:59:59';
        }

        /* That's it, let's send out formatted time string */
        return str_pad($h, 2, "0", STR_PAD_LEFT) . ':' . str_pad($m, 2, "0", STR_PAD_LEFT) . ':' . str_pad($s, 2, "0", STR_PAD_LEFT);
    }
}






