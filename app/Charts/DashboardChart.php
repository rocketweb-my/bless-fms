<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Ticket;
use Carbon\Carbon;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class DashboardChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
//    public function handler(Request $request): Chartisan
//    {
//        $open = [
//            $this->calculate_total_open(1),
//            $this->calculate_total_open(2),
//            $this->calculate_total_open(3),
//            $this->calculate_total_open(4),
//            $this->calculate_total_open(5),
//            $this->calculate_total_open(6),
//            $this->calculate_total_open(7),
//            $this->calculate_total_open(8),
//            $this->calculate_total_open(9),
//            $this->calculate_total_open(10),
//            $this->calculate_total_open(11),
//            $this->calculate_total_open(12)
//        ];
//        $close = [
//            $this->calculate_total_close(1),
//            $this->calculate_total_close(2),
//            $this->calculate_total_close(3),
//            $this->calculate_total_close(4),
//            $this->calculate_total_close(5),
//            $this->calculate_total_close(6),
//            $this->calculate_total_close(7),
//            $this->calculate_total_close(8),
//            $this->calculate_total_close(9),
//            $this->calculate_total_close(10),
//            $this->calculate_total_close(11),
//            $this->calculate_total_close(12)
//        ];
//
//        return Chartisan::build()
//            ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'])
//            ->dataset('Open', $open)
//            ->dataset('Close', $close);
//    }
    public function handler(Request $request): Chartisan
    {
        $label = [];
        for($i = 30; $i > -1; $i--)
        {

            $label[] = date("M-d", strtotime("-$i days"));
            $open[] = $this->calculate_total_open(date("Y-m-d", strtotime("-$i days")));
            $close[] = $this->calculate_total_close(date("Y-m-d", strtotime("-$i days")));

        }

        return Chartisan::build()
            ->labels($label)
            ->dataset('Open', $open)
            ->dataset('Close', $close);
    }

    public function calculate_total_open($date)
    {
        $date = Carbon::parse($date);

//        $open = Ticket::whereNotIn('status',['3'])->where('owner', User()->id)->whereDate('dt', '=', $date)->get();
        $open = Ticket::whereDate('dt', '=', $date)->where('owner', User()->id)->get();

        if ($open !== null)
        {
            return $open->count();
        }else{
            return 0;
        }
    }
    public function calculate_total_close($date)
    {
        $date = Carbon::parse($date);

//        $close = Ticket::whereIn('status',['3'])->where('owner', User()->id)->whereDate('closedat', '=', $date)->get();
        $close = Ticket::whereDate('closedat', '=', $date)->where('owner', User()->id)->get();

        if ($close !== null)
        {
            return $close->count();
        }else{
            return 0;
        }
    }
//    public function calculate_total_open($month)
//    {
//        $year = date('Y');
//        $start = new Carbon($month.'/01/'.$year);
//        $end = new Carbon($month.'/01/'.$year);
//
//        $start = $start->startOfMonth();
//        $end = $end->endOfMonth();
//
//        $open = Ticket::whereNotIn('status',['3'])->where('owner', User()->id)->whereBetween('dt',[$start, $end])->get();
//
//        if ($open !== null)
//        {
//            return $open->count();
//        }else{
//            return 0;
//        }
//    }
//    public function calculate_total_close($month)
//    {
//        $year = date('Y');
//        $start = new Carbon($month.'/01/'.$year);
//        $end = new Carbon($month.'/01/'.$year);
//
//        $start = $start->startOfMonth();
//        $end = $end->endOfMonth();
//
//        $close = Ticket::whereIn('status',['3'])->where('owner', User()->id)->whereBetween('dt',[$start, $end])->get();
//
//        if ($close !== null)
//        {
//            return $close->count();
//        }else{
//            return 0;
//        }
//    }
}
