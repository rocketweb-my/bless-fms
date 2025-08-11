<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CustomField;
use App\Models\ReportChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Chartisan\PHP\Chartisan;
use DateTime;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

class ReportController extends Controller
{

    private $chartLetters = 'abcdefghijklmnopqrstuvwxyz';
    private $color = ["#008FFB", "#00E396", "#feb019", "#ff455f", "#775dd0", "#80effe", "#0077B5", "#ff6384", "#c9cbcf", "#0057ff", "00a9f4", "#2ccdc9", "#5e72e4"];
    public function main(Request $request)
    {
        if (systemGeneralSetting() != null)
        {
            if(systemGeneralSetting()->overdue == null || systemGeneralSetting()->overdue == '')
            {
                $overdue_days = 3;
            }else{
                $overdue_days = systemGeneralSetting()->overdue;
            }
        }else{
            $overdue_days = 3;
        }

        $start_label = date("m/d/Y");
        $end_label = date("m/d/Y");


        if ($request->has('date'))
        {
            $date = $request->date;
            $date = explode(' - ', $date);
            $start  = Carbon::parse(Carbon::createFromFormat('m/d/Y', $date[0])->format('d-m-Y'))->startOfDay();
            $end    = Carbon::parse(Carbon::createFromFormat('m/d/Y', $date[1])->format('d-m-Y'))->endOfDay();
            $start_label = $date[0];
            $end_label = $date[1];

            $open_ticket = Ticket::whereNotIn('status',['3'])->whereBetween('dt', [$start, $end])->get()->count();
            $resolved_ticket = Ticket::where('status', '3')->whereBetween('dt', [$start, $end])->get()->count();
            $total_ticket = Ticket::whereBetween('dt', [$start, $end])->get()->count();
            $over_due_ticket = Ticket::whereNotIn('status',['3'])->whereBetween('dt', [$start, $end])->whereDate('dt', '<', Carbon::now()->subDays($overdue_days))->get()->count();

        }else{
            $open_ticket = Ticket::whereNotIn('status',['3'])->get()->count();
            $resolved_ticket = Ticket::where('status', '3')->get()->count();
            $total_ticket = Ticket::all()->count();
            $over_due_ticket = Ticket::whereNotIn('status',['3'])->whereDate('dt', '<', Carbon::now()->subDays($overdue_days))->get()->count();
        }
        $charts = ReportChart::all();

        $custom_fields = CustomField::whereIn('type', ['radio', 'select','checkbox'])->get();

        return view('pages.report_main',compact('total_ticket','open_ticket','resolved_ticket','over_due_ticket','charts','custom_fields','start_label','end_label'));
    }

    public function getData(Request $request){

        if (systemGeneralSetting() != null)
        {
            if(systemGeneralSetting()->overdue == null || systemGeneralSetting()->overdue == '')
            {
                $overdue_days = 3;
            }else{
                $overdue_days = systemGeneralSetting()->overdue;
            }
        }else{
            $overdue_days = 3;
        }

        $start_date = Carbon::parse($request->yearStart .'-'. $request->monthStart .'-'. $request->dateStart);
        $end_date = Carbon::parse($request->yearEnd .'-'. $request->monthEnd .'-'. $request->dateEnd);

        $open = [
            $this->calculate_total_open(1, $request->yearStart),
            $this->calculate_total_open(2, $request->yearStart),
            $this->calculate_total_open(3, $request->yearStart),
            $this->calculate_total_open(4, $request->yearStart),
            $this->calculate_total_open(5, $request->yearStart),
            $this->calculate_total_open(6, $request->yearStart),
            $this->calculate_total_open(7, $request->yearStart),
            $this->calculate_total_open(8, $request->yearStart),
            $this->calculate_total_open(9, $request->yearStart),
            $this->calculate_total_open(10, $request->yearStart),
            $this->calculate_total_open(11, $request->yearStart),
            $this->calculate_total_open(12, $request->yearStart)
        ];
        $close = [
            $this->calculate_total_close(1, $request->yearStart),
            $this->calculate_total_close(2, $request->yearStart),
            $this->calculate_total_close(3, $request->yearStart),
            $this->calculate_total_close(4, $request->yearStart),
            $this->calculate_total_close(5, $request->yearStart),
            $this->calculate_total_close(6, $request->yearStart),
            $this->calculate_total_close(7, $request->yearStart),
            $this->calculate_total_close(8, $request->yearStart),
            $this->calculate_total_close(9, $request->yearStart),
            $this->calculate_total_close(10, $request->yearStart),
            $this->calculate_total_close(11, $request->yearStart),
            $this->calculate_total_close(12, $request->yearStart)
        ];

        $data['label'] = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $data['open'] = $open;
        $data['close'] = $close;

        $open_ticket = Ticket::whereNotIn('status',['3'])->whereBetween('dt',[$start_date,$end_date])->get()->count();
        $resolved_ticket = Ticket::where('status', '3')->whereBetween('dt',[$start_date,$end_date])->get()->count();
        $total_ticket = Ticket::whereBetween('dt',[$start_date,$end_date])->get()->count();
        $over_due_ticket = Ticket::whereNotIn('status',['3'])->whereDate('dt', '<', Carbon::now()->subDays($overdue_days))->whereBetween('dt',[$start_date,$end_date])->get()->count();

        $data['open_ticket'] = $open_ticket;
        $data['total_ticket'] = $total_ticket;
        $data['over_due_ticket'] = $over_due_ticket;
        $data['resolved_ticket'] = $resolved_ticket ;


//        $data->open = $open;
//        $data->close = $close;
//        dd($data->toArray());

        return json_encode($data);
    }

    public function calculate_total_open($month, $year)
    {
        $start = new Carbon($month.'/01/'.$year);
        $end = new Carbon($month.'/01/'.$year);

        $start = $start->startOfMonth();
        $end = $end->endOfMonth();

        $open = Ticket::whereNotIn('status',['3'])->whereBetween('dt',[$start, $end])->get();

        if ($open !== null)
        {
            return $open->count();
        }else{
            return 0;
        }
    }

    public function calculate_total_close($month, $year)
    {
        $start = new Carbon($month.'/01/'.$year);
        $end = new Carbon($month.'/01/'.$year);

        $start = $start->startOfMonth();
        $end = $end->endOfMonth();

        $close = Ticket::whereIn('status',['3'])->whereBetween('dt',[$start, $end])->get();

        if ($close !== null)
        {
            return $close->count();
        }else{
            return 0;
        }
    }

    // Process Duration Chart //
    public function process_duration_chart_get_data(Request $request)
    {
        $data = Chartisan::build()
            ->labels(['Less than 4 days', 'Between 4 to 7 days', 'More than 7 days'])
            ->dataset('Tickets', [1574,91,19])
            ->toJSON();

        dd(json_decode($data));
        return $data;
    }

    public function add_chart(Request $request)
    {
        $id = substr(str_shuffle(str_repeat($x = $this->chartLetters, ceil(25 / strlen($x)))), 1, 25);

        $data = ReportChart::create([
            'chart_id'      => $id,
            'title'         => $request->title,
            'type'          => $request->type,
            'data_field'    => $request->data_field,
        ]);

        if($request->data_field == 'category' && $request->category != null){
            $data->value = json_encode($request->category);
            $data->save();
        }elseif ($request->data_field == 'custom' && $request->custom != null)
        {
            $data->value = $request->custom;
            $data->save();
        }

        return redirect()->back();
    }

    public function container($id)
    {
        return View::make('components.graph.container', ['id' => $id]);
    }

    public function script($chart_data)
    {
        return View::make('components.graph.script', $chart_data);
    }

    public function delete_chart(Request $request)
    {
        $graph = ReportChart::find($request->id);
        $graph->delete();
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }
}
