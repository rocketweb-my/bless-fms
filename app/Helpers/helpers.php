<?php

use App\Models\CustomField;
use App\Models\KnowledgebaseCategory;
use App\Models\LookupPriority;
use App\Models\Ticket;
use App\Models\User;
use App\Models\SettingGeneral;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use App\Models\BanIP;

if (! function_exists('User')) {
    function User()
    {
        $user = User::find(Session::get('user_id'));
        return $user;
    }
}

if (! function_exists('findUser')) {
    function findUser($id)
    {
        $user = User::find($id);
        return $user;
    }
}

if (! function_exists('allUser')) {
    function allUser()
    {
        $users = User::all();
        return $users;
    }
}

if (! function_exists('systemSetting')) {
    function systemSetting()
    {
        $setting = new Collection();

        $setting->autoassign = 1;
        $setting->attachments_max_size = 6;
        $setting->orderdue_day = 3;

        return $setting;
    }
}

if (! function_exists('userPermissionChecker')) {
    function userPermissionChecker($permission)
    {
        if (user()->isadmin == 1)
        {
            return true;
        }else{
            if (strpos(user()->heskprivileges, $permission) === false)
            {
                return false;
            }else{
                return true;
            }
        }
    }
}

if (! function_exists('systemGeneralSetting')) {
    function systemGeneralSetting()
    {
        $general_setting = SettingGeneral::first();

        if ($general_setting != null)
        {
            return $general_setting;
        }else{
            return null;
        }
    }
}

if (! function_exists('statusName')) {
    function statusName($id)
    {
        $statusLookup = \App\Models\LookupStatusLog::find($id);
        return $statusLookup ? $statusLookup->nama : 'New';
    }
}

if (! function_exists('categoryName')) {
    function categoryName($id)
    {
        $category = Category::find($id);
        return $category;
    }
}

if (! function_exists('kbCategoryName')) {
    function kbCategoryName($id)
    {
        $category = KnowledgebaseCategory::find($id);
        if ($category == null)
        {
            return '';
        }else{
            return  $category->name;
        }
    }
}

if (! function_exists('sliderFileName')) {
    function sliderFile($id)
    {
        $slider= \App\Models\Slider::find($id);
        if ($slider == null)
        {
            return '';
        }else{
            return  $slider->file_name;
        }
    }
}

if (! function_exists('priorityName')) {
    function priorityName($id)
    {
        return getPriorityName($id);
    }
}

if (! function_exists('autoAssignTicket')) {
    function autoAssignTicket($ticket_category)
    {
        if ( systemSetting()->autoassign != 1)
        {
            return false;
        }

//        $autoassign_owner = array();

        /* Get all possible auto-assign staff, order by number of open tickets */
        $data = DB::select("SELECT `t1`.`id`,`t1`.`user`,`t1`.`name`, `t1`.`email`, `t1`.`language`, `t1`.`isadmin`, `t1`.`categories`, `t1`.`notify_assigned`, `t1`.`heskprivileges`, `t1`.`notify_new_my`, `t1`.`is_active`,
					    (SELECT COUNT(*) FROM `".env('DB_PREFIX')."tickets` FORCE KEY (`statuses`) WHERE `owner`=`t1`.`id` AND `status` IN ('0','1','2','4','5') ) as `open_tickets`
						FROM `".env('DB_PREFIX')."users` AS `t1`
						WHERE `t1`.`autoassign`='1' AND `t1`.`is_active`='1' ORDER BY `open_tickets` ASC, RAND()");

        /* Loop through the rows and return the first appropriate one */

        foreach ($data as $myuser)
        {
            /* Is this an administrator? */
            if ($myuser->isadmin == 1)
            {
                $autoassign_owner = $myuser;
                // Tak Faham But Not Using It For Now
                //$hesk_settings['user_data'][$myuser['id']] = $myuser;
                return $autoassign_owner;

            }else{

                /* Not and administrator, check two things: */

                /* --> can view and reply to tickets */
                if (strpos($myuser->heskprivileges, 'can_view_tickets') === false || strpos($myuser->heskprivileges, 'can_reply_tickets') === false) {

                }else{
                    /* --> has access to ticket category */
                    $myuser->categories = explode(',',$myuser->categories);
                    if (in_array($ticket_category,$myuser->categories))
                    {
                        $autoassign_owner = $myuser;
                        // Tak Faham But Not Using It For Now
                        //$hesk_settings['user_data'][$myuser['id']] = $myuser;
                        return $autoassign_owner;
                    }
                }

            }
        }
        return null;
    }
}

if (! function_exists('getCategoryList')) {
    function getCategoryList()
    {
        $categoriest = Category::orderBy('cat_order', 'ASC')->get();
        return $categoriest;
    }
}

if (! function_exists('totalTicketByCategory')) {
    function totalTicketByCategory($category_id)
    {
        $total = Ticket::where('category', $category_id)->get();
        return $total->count();
    }
}

// Custom Field Processor //

if (! function_exists('customFieldProcessor')) {
    function customFieldProcessor($custom_field)
    {
        if ($custom_field->type == 'text')
        {
            if ($custom_field->req == 0)
            {
                $field =  '<div class="form-group">
                                <label class="form-label">'.json_decode($custom_field->name)->English.'</label>
                                <input type="text" class="form-control" name="custom'.$custom_field->id.'" value="'.json_decode($custom_field->value)->default_value.'">
                            </div>';
            }else{
                $field =  '<div class="form-group">
                                <label class="form-label">'.json_decode($custom_field->name)->English.' <small class="text-danger">*</small></label>
                                <input type="text" class="form-control" name="custom'.$custom_field->id.'" value="'.json_decode($custom_field->value)->default_value.'" required>
                            </div>';
            }
        }elseif ($custom_field->type == 'textarea')
        {
            if ($custom_field->req == 0)
            {
                $field =  '<div class="form-group">
                                <label class="form-label">'.json_decode($custom_field->name)->English.'</label>
                                <textarea class="form-control" name="custom'.$custom_field->id.'" rows="'.json_decode($custom_field->value)->rows.'" cols="'.json_decode($custom_field->value)->cols.'"></textarea>
                            </div>';
            }else{
                $field =  '<div class="form-group">
                                <label class="form-label">'.json_decode($custom_field->name)->English.' <small class="text-danger">*</small></label>
                                <textarea class="form-control" name="custom'.$custom_field->id.'" rows="'.json_decode($custom_field->value)->rows.'" cols="'.json_decode($custom_field->value)->cols.'" required></textarea>
                            </div>';
            }

        }elseif ($custom_field->type == 'radio')
        {
            if ($custom_field->req == 0) {
                $field = '<div class="form-group form-elements">
						<div class="form-label">'.json_decode($custom_field->name)->English.'</div>
						<div class="custom-controls-stacked">';
						foreach (json_decode($custom_field->value)->radio_options as $index => $radio)
                        {
                            $field .= '<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" name="custom'.$custom_field->id.'" value="'.$radio.'"';

								if ($index == 0 && json_decode($custom_field->value)->no_default == 0)
                                {
                                    $field .= 'checked >';
                                }else {
                                    $field .= '>';
                                }

                            $field .= '<span class="custom-control-label">'.$radio.'</span>
							</label>';
                        }
                $field .= '</div></div>';
            }else{

                $field = '<div class="form-group form-elements">
						<div class="form-label">'.json_decode($custom_field->name)->English.' <small class="text-danger">*</small></div>
						<div class="custom-controls-stacked">';
                foreach (json_decode($custom_field->value)->radio_options as $index => $radio)
                {
                    $field .= '<label class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" name="custom'.$custom_field->id.'" value="'.$radio.'"';

                    if ($index == 0 && json_decode($custom_field->value)->no_default == 0)
                    {
                        $field .= 'checked >';
                    }else {
                        $field .= '>';
                    }

                    $field .= '<span class="custom-control-label">'.$radio.'</span>
							</label>';
                }
                $field .= '</div></div>';

            }

        }elseif ($custom_field->type == 'select')
        {
            if ($custom_field->req == 0)
            {
                $field =  '<div class="form-group">
                                <label class="form-label">'.json_decode($custom_field->name)->English.'</label>
                                <select name="custom'.$custom_field->id.'"  class="form-control custom-select">';
                foreach (json_decode($custom_field->value)->select_options as $option)
                {
                    $field .= '<option value="'.$option.'">'.$option.'</option>';
                }

                $field .= '</select></div>';

            }else{
                $field =  '<div class="form-group">
                                <label class="form-label">'.json_decode($custom_field->name)->English.' <small class="text-danger">*</small></label>
                                <select name="custom'.$custom_field->id.'"  class="form-control custom-select" required>';

                $field .= '<option value=""></option>';

                foreach (json_decode($custom_field->value)->select_options as $option)
                {
                    $field .= '<option value="'.$option.'">'.$option.'</option>';
                }

                $field .= '</select></div>';
            }

        }elseif ($custom_field->type == 'checkbox')
        {
            $checked = 'checked';
            if ($custom_field->req == 0) {
                $field = '<div class="form-group form-elements">
						<div class="form-label">'.json_decode($custom_field->name)->English.'</div>
						<div class="custom-controls-stacked">';
                foreach (json_decode($custom_field->value)->checkbox_options as $index => $checkbox)
                {
                    $field .= '<label class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" name="custom'.$custom_field->id.'[]" value="'.$checkbox.'">
								<span class="custom-control-label">'.$checkbox.'</span>
							</label>';
                }
                $field .= '</div></div>';
            }else{

                $field = '<div class="form-group form-elements">
						<div class="form-label">'.json_decode($custom_field->name)->English.' <small class="text-danger">*</small></div>
						<div class="custom-controls-stacked">';
                foreach (json_decode($custom_field->value)->checkbox_options as $index => $checkbox)
                {
                    $field .= '<label class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" name="custom'.$custom_field->id.'[]" value="'.$checkbox.'">
                                <span class="custom-control-label">'.$checkbox.'</span>
							</label>';
                }
                $field .= '</div></div>';

            }

        }elseif ($custom_field->type == 'date')
        {

        }elseif ($custom_field->type == 'email')
        {
            if ($custom_field->req == 0)
            {
                $field =  '<div class="form-group">
                                <label class="form-label">'.json_decode($custom_field->name)->English.'</label>
                                <input type="email" class="form-control" name="custom'.$custom_field->id.'" >
                            </div>';
            }else{
                $field =  '<div class="form-group">
                                <label class="form-label">'.json_decode($custom_field->name)->English.' <small class="text-danger">*</small></label>
                                <input type="email" class="form-control" name="custom'.$custom_field->id.'"  required>
                            </div>';
            }
        }
        else{
            //hidden
            if ($custom_field->req == 0)
            {
                $field =  '<input type="hidden" name="custom'.$custom_field->id.'" value="'.json_decode($custom_field->value)->default_value.'">';
            }else{
                $field =  '<input type="hidden"  name="custom'.$custom_field->id.'" value="'.json_decode($custom_field->value)->default_value.'" required>';
            }
        }
        return $field;
    }
}

if (! function_exists('isFeedbackFormPage')) {
    function isFeedbackFormPage()
    {
        $feedbackFormRoutes = [
            'public/*',
            'admin/choose_category',
            'admin/create_ticket'
        ];

        foreach ($feedbackFormRoutes as $route) {
            if (request()->is($route)) {
                return true;
            }
        }

        return false;
    }
}

if (! function_exists('renderCustomScripts')) {
    function renderCustomScripts($location = 'head', $page = null)
    {
        // Auto-detect page type if not specified
        if ($page === null) {
            $page = isFeedbackFormPage() ? 'feedback_form' : 'all_pages';
        }

        $scripts = \App\Models\CustomScript::where('status', true)
            ->where('location', $location)
            ->where(function ($query) use ($page) {
                $query->where('page', 'all_pages')
                      ->orWhere('page', $page);
            })
            ->get();

        $output = '';
        foreach ($scripts as $script) {
            $output .= $script->script_content . "\n";
        }

        return $output;
    }
}

//Taken From Old System

if (! function_exists('generateTicketID')) {
    function generateTicketID()
    {
        /*** Generate tracking ID and make sure it's not a duplicate one ***/

        /* Ticket ID can be of these chars */
        $useChars = 'AEUYBDGHJLMNPQRSTVWXZ123456789';

        /* Set tracking ID to an empty string */
        $trackingID = '';

        /* Let's avoid duplicate ticket ID's, try up to 3 times */
        for ($i = 1; $i <= 3; $i++) {
            /* Generate raw ID */
            $trackingID .= $useChars[mt_rand(0, 29)];
            $trackingID .= $useChars[mt_rand(0, 29)];
            $trackingID .= $useChars[mt_rand(0, 29)];
            $trackingID .= $useChars[mt_rand(0, 29)];
            $trackingID .= $useChars[mt_rand(0, 29)];
            $trackingID .= $useChars[mt_rand(0, 29)];
            $trackingID .= $useChars[mt_rand(0, 29)];
            $trackingID .= $useChars[mt_rand(0, 29)];
            $trackingID .= $useChars[mt_rand(0, 29)];
            $trackingID .= $useChars[mt_rand(0, 29)];

            /* Format the ID to the correct shape and check wording */
            $trackingID = formatTrackingID($trackingID);

            /* Check for duplicate IDs */
            $res = Ticket::where('trackid', $trackingID)->first();

            if ($res == null) {
                /* Everything is OK, no duplicates found */
                return $trackingID;
            }

            /* A duplicate ID has been found! Let's try again (up to 2 more) */
            $trackingID = '';
        }

        /* No valid tracking ID, try one more time with microtime() */
        $trackingID = $useChars[mt_rand(0, 29)];
        $trackingID .= $useChars[mt_rand(0, 29)];
        $trackingID .= $useChars[mt_rand(0, 29)];
        $trackingID .= $useChars[mt_rand(0, 29)];
        $trackingID .= $useChars[mt_rand(0, 29)];
        $trackingID .= substr(microtime(), -5);

        /* Format the ID to the correct shape and check wording */
        $trackingID = formatTrackingID($trackingID);

        $res = Ticket::where('trackid', $trackingID)->first();

        /* All failed, must be a server-side problem... */
        if ($res == null) {
            return $trackingID;
        }

        return false;
    }
}

if (! function_exists('formatTrackingID')) {
    function formatTrackingID($id)
    {
        $useChars = 'AEUYBDGHJLMNPQRSTVWXZ123456789';

        $replace  = $useChars[mt_rand(0,29)];
        $replace .= mt_rand(1,9);
        $replace .= $useChars[mt_rand(0,29)];

        /*
        Remove 3 letter bad words from ID
        Possiblitiy: 1:27,000
        */
        $remove = array(
            'ASS',
            'CUM',
            'FAG',
            'FUK',
            'GAY',
            'SEX',
            'TIT',
            'XXX',
        );

        $id = str_replace($remove,$replace,$id);

        /*
        Remove 4 letter bad words from ID
        Possiblitiy: 1:810,000
        */
        $remove = array(
            'ANAL',
            'ANUS',
            'BUTT',
            'CAWK',
            'CLIT',
            'COCK',
            'CRAP',
            'CUNT',
            'DICK',
            'DYKE',
            'FART',
            'FUCK',
            'JAPS',
            'JERK',
            'JIZZ',
            'KNOB',
            'PISS',
            'POOP',
            'SHIT',
            'SLUT',
            'SUCK',
            'TURD',

            // Also, remove words that are known to trigger mod_security
            'WGET',
        );

        $replace .= mt_rand(1,9);
        $id = str_replace($remove,$replace,$id);

        /* Format the ID string into XXX-XXX-XXXX format for easier readability */
        $id = $id[0].$id[1].$id[2].'-'.$id[3].$id[4].$id[5].'-'.$id[6].$id[7].$id[8].$id[9];

        return $id;
    }

    if (! function_exists('graphContainer')) {
        function graphContainer($chart_detail, $date)
        {
            if ($date != null)
            {
                $date = explode(' - ', $date);
                $start  = Carbon::parse(Carbon::createFromFormat('m/d/Y', $date[0])->format('d-m-Y'))->startOfDay();
                $end    = Carbon::parse(Carbon::createFromFormat('m/d/Y', $date[1])->format('d-m-Y'))->endOfDay();
            }


            $color = ["#008FFB", "#00E396", "#feb019", "#ff455f", "#775dd0", "#80effe", "#0077B5", "#ff6384", "#c9cbcf", "#0057ff", "00a9f4", "#2ccdc9", "#5e72e4"];


            if ($chart_detail->data_field == 'category')
            {
                foreach (json_decode($chart_detail->value) as $value)
                {
                    $labels[] = categoryName($value)->name;
                    if ($date == null)
                    {
                        $dataSet[] = Ticket::where('category',$value)->get();
                    }else{
                        $dataSet[] = Ticket::where('category',$value)->whereBetween('dt', [$start, $end])->get();
                    }


                }

            }elseif ($chart_detail->data_field == 'custom')
            {
                $custom_id = $chart_detail->value;
                $custom_field = CustomField::find($custom_id);

                if ($custom_field->type == 'radio')
                {
                    $values = json_decode($custom_field->value)->radio_options;
                    foreach ($values as $value)
                    {
                        if ($date == null) {
                            $ticket = Ticket::where('custom' . $custom_id, $value)->get();
                        }else{
                            $ticket = Ticket::where('custom' . $custom_id, $value)->whereBetween('dt', [$start, $end])->get();
                        }

                        $labels[] = $value;
                        $dataSet[] = $ticket;
                    }
                }elseif ($custom_field->type == 'select')
                {
                    $values = json_decode($custom_field->value)->select_options;
                    foreach ($values as $value)
                    {
                        if ($date == null) {
                            $ticket = Ticket::where('custom' . $custom_id, $value)->get();
                        }else{
                            $ticket = Ticket::where('custom' . $custom_id, $value)->whereBetween('dt', [$start, $end])->get();
                        }

                        $labels[] = $value;
                        $dataSet[] = $ticket;
                    }
                }elseif ($custom_field->type == 'checkbox')
                {
                    $values = json_decode($custom_field->value)->checkbox_options;
                    foreach ($values as $value)
                    {
                        if ($date == null) {
                            $ticket = Ticket::where('custom' . $custom_id, $value)->get();
                        }else{
                            $ticket = Ticket::where('custom' . $custom_id, $value)->whereBetween('dt', [$start, $end])->get();
                        }

                        $labels[] = $value;
                        $dataSet[] = $ticket;
                    }
                }

            }

            $chart_data = [
                'id' => $chart_detail->chart_id,
                'title' => $chart_detail->title,
                'labels' => $labels,
                'dataSets' => $dataSet,
            ];

            return View::make('components.graph.container', $chart_data);
        }
    }

    if (! function_exists('graphScript')) {
        function graphScript($chart_detail, $date)
        {
            if ($date != null)
            {
                $date = explode(' - ', $date);
                $start  = Carbon::parse(Carbon::createFromFormat('m/d/Y', $date[0])->format('d-m-Y'))->startOfDay();
                $end    = Carbon::parse(Carbon::createFromFormat('m/d/Y', $date[1])->format('d-m-Y'))->endOfDay();
            }


            $color = ["#008FFB", "#00E396", "#feb019", "#ff455f", "#775dd0", "#80effe", "#0077B5", "#ff6384", "#c9cbcf", "#0057ff", "00a9f4", "#2ccdc9", "#5e72e4"];


            if ($chart_detail->data_field == 'category')
            {
                foreach (json_decode($chart_detail->value) as $value)
                {
                    $labels[] = categoryName($value)->name;
                    if ($date == null)
                    {
                        $dataSet[] = Ticket::where('category',$value)->get()->count();
                    }else{
                        $dataSet[] = Ticket::where('category',$value)->whereBetween('dt', [$start, $end])->get()->count();
                    }


                }

            }elseif ($chart_detail->data_field == 'custom')
            {
                $custom_id = $chart_detail->value;
                $custom_field = CustomField::find($custom_id);

                if ($custom_field->type == 'radio')
                {
                    $values = json_decode($custom_field->value)->radio_options;
                    foreach ($values as $value)
                    {
                        if ($date == null) {
                            $ticket = Ticket::where('custom' . $custom_id, $value)->get()->count();
                        }else{
                            $ticket = Ticket::where('custom' . $custom_id, $value)->whereBetween('dt', [$start, $end])->get()->count();
                        }

                        $labels[] = $value;
                        $dataSet[] = $ticket;
                    }
                }elseif ($custom_field->type == 'select')
                {
                    $values = json_decode($custom_field->value)->select_options;
                    foreach ($values as $value)
                    {
                        if ($date == null) {
                            $ticket = Ticket::where('custom' . $custom_id, $value)->get()->count();
                        }else{
                            $ticket = Ticket::where('custom' . $custom_id, $value)->whereBetween('dt', [$start, $end])->get()->count();
                        }

                        $labels[] = $value;
                        $dataSet[] = $ticket;
                    }
                }elseif ($custom_field->type == 'checkbox')
                {
                    $values = json_decode($custom_field->value)->checkbox_options;
                    foreach ($values as $value)
                    {
                        if ($date == null) {
                            $ticket = Ticket::where('custom' . $custom_id, $value)->get()->count();
                        }else{
                            $ticket = Ticket::where('custom' . $custom_id, $value)->whereBetween('dt', [$start, $end])->get()->count();
                        }

                        $labels[] = $value;
                        $dataSet[] = $ticket;
                    }
                }

            }

            $chart_data = [
                'id' => $chart_detail->chart_id,
                'type' => $chart_detail->type,
                'heigh' => 350,
                'colors' => json_encode($color),
                'dataset' => json_encode($dataSet),
                'labels' => json_encode($labels),
                'title' => $chart_detail->title,
            ];

            if ($chart_detail->type == 'bar' || $chart_detail->type == 'row')
            {
                return View::make('components.graph.script_bar_row', $chart_data);

            }
            else{
                return View::make('components.graph.script_pie_donut', $chart_data);
            }
        }
    }

    if (! function_exists('checkBanIP')) {
        function checkBanIP($ip)
        {

            $ip = ip2long($ip) or $ip = 0;

            // We need positive value of IP
            if ($ip < 0)
            {
                $ip += 4294967296;
            }
            elseif ($ip > 4294967296)
            {
                $ip = 4294967296;
            }

            $res = DB::select("SELECT `id` FROM `".env('DB_PREFIX')."banned_ips` WHERE {$ip} BETWEEN `ip_from` AND `ip_to` LIMIT 1");

            return count($res);


        }
    }


}

if (! function_exists('getPriorityOverdueDays')) {
    function getPriorityOverdueDays($priority_value)
    {
        $priority = LookupPriority::getByValue($priority_value);
        return $priority ? $priority->duration_days : 3; // Default to 3 days if not found
    }
}

if (! function_exists('getPriorityName')) {
    function getPriorityName($priority_value, $locale = null)
    {
        $priority = LookupPriority::getByValue($priority_value);
        if (!$priority) {
            return 'Unknown';
        }
        
        $locale = $locale ?: app()->getLocale();
        return $locale === 'ms' ? $priority->name_ms : $priority->name_en;
    }
}

if (! function_exists('getOverdueTicketsQuery')) {
    /**
     * Get query for overdue tickets based on priority-specific overdue days
     */
    function getOverdueTicketsQuery($baseQuery = null)
    {
        if (!$baseQuery) {
            $baseQuery = Ticket::query();
        }

        // Get all priorities with their duration_days
        $priorities = LookupPriority::active()->get();
        
        // Build where conditions for each priority
        $baseQuery->where(function($query) use ($priorities) {
            foreach ($priorities as $priority) {
                $cutoff_date = Carbon::now()->subDays($priority->duration_days)->format('Y-m-d H:i:s');
                $query->orWhere(function($subQuery) use ($priority, $cutoff_date) {
                    $subQuery->where('priority', (string) $priority->priority_value)
                             ->where('dt', '<', $cutoff_date);
                });
            }
        });
        
        return $baseQuery;
    }
}
