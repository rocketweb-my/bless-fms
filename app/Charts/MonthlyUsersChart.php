<?php

namespace App\Charts;

use App\Models\Ticket;
use Carbon\Carbon;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyUsersChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build()
    {
        $label = [];
        for($i = 30; $i > -1; $i--)
        {

            $label[] = date("M-d", strtotime("-$i days"));
            $open[] = $this->calculate_total_open(date("Y-m-d", strtotime("-$i days")));
            $close[] = $this->calculate_total_close(date("Y-m-d", strtotime("-$i days")));



        }

        return $this->chart->barChart()
            ->addData('Open', $open)
            ->addData('Close', $close)
            ->setXAxis($label);
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
}
