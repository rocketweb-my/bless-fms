<?php

namespace App\Http\Controllers;

use App\Models\SettingEmail;
use App\Models\SettingGeneral;
use App\Models\LookupPriority;
use Illuminate\Http\Request;
use Svg\Tag\Rect;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SettingController extends Controller
{
    public function general()
    {
        $general_setting = SettingGeneral::first();
        $priorities = LookupPriority::active()->orderBy('priority_value')->get();

        return view('pages.setting_general', compact('general_setting', 'priorities'));
    }

    public function general_store(Request $request)
    {
        if ($request->logo)
        {
            $this->validate($request, [
                'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048|dimensions:width=290,height=75',
            ]);
        }

        if ($request->favicon)
        {
            $this->validate($request, [
                'favicon' => 'required|image|mimes:jpeg,png,jpg|max:2048|dimensions:ratio=1/1',
            ]);
        }

        if ($request->id == null)
        {
            $favicon = '';
            $logo = '';
            if($request->has('logo')) {
                $logo = $request->logo->hashName();
                $path = $request->logo->storeAs('public/image/logo',$logo);
            }
            if($request->has('favicon')) {
                $favicon = $request->favicon->hashName();
                $path = $request->favicon->storeAs('public/image/favicon',$favicon);
            }

            SettingGeneral::create([
                'website_title' => $request->website_title,
                'website_description' => $request->website_description,
                'help_desk_title' => $request->help_desk_title,
                'webmaster_email' => $request->webmaster_email,
                'from_email' => $request->from_email,
                'from_name' => $request->from_name,
                'language' => $request->language,
                'logo' => $logo,
                'favicon' => $favicon,
                'overdue'   => $request->overdue,
            ]);
        }else{
            $setting  = SettingGeneral::find($request->id);
            $setting->website_title     = $request->website_title;
            $setting->website_description     = $request->website_description;
            $setting->help_desk_title   = $request->help_desk_title;
            $setting->webmaster_email   = $request->webmaster_email;
            $setting->from_email    = $request->from_email;
            $setting->from_name     = $request->from_name;
            $setting->language      = $request->language;
            $setting->overdue  = $request->overdue;

            if($request->has('logo')) {
                $logo = $request->logo->hashName();
                $path = $request->logo->storeAs('public/image/logo',$logo);
                $setting->logo = $logo;
            }

            if($request->has('logo_public')) {
                $logo_public = $request->logo_public->hashName();
                $path = $request->logo_public->storeAs('public/image/logo_public',$logo_public);
                $setting->logo_public = $logo_public;
            }

            if($request->has('favicon')) {
                $favicon = $request->favicon->hashName();
                $path = $request->favicon->storeAs('public/image/favicon',$favicon);
                $setting->favicon = $favicon;
            }

            $setting->save();
        }


        // toastr()->success('General Setting Successfully Saved', 'Success');
        flash('General Setting Successfully Saved', 'success');

        return redirect()->back();
    }

    public function priority_store(Request $request)
    {
        $request->validate([
            'priorities' => 'required|array',
            'priorities.*.duration_days' => 'required|integer|min:1',
        ]);

        foreach ($request->priorities as $priorityData) {
            LookupPriority::where('priority_value', $priorityData['priority_value'])
                ->update([
                    'duration_days' => $priorityData['duration_days']
                ]);
        }

        flash('Priority Settings Successfully Saved', 'success');
        return redirect()->back();
    }

    public function email()
    {
        $setting_imap = SettingEmail::first();
        return view('pages.setting_email',compact(['setting_imap']));
    }

    public function email_store(Request $request)
    {
        $setting_email_old = SettingEmail::all();
        foreach($setting_email_old as $old)
        {
            $old->delete();
        }
        SettingEmail::updateOrCreate([
            'mail_method' => 'smtp',
        ],[
            'smtp_host' => $request->smtp_host,
            'smtp_port' => $request->smtp_port,
            'smtp_username' => $request->smtp_username,
            'smtp_password' => $request->smtp_password,
            'ssl_protocol' => $request->ssl_protocol,
            'tls_protocol' => $request->tls_protocol,
            'smtp_from_email' => $request->smtp_from_email,
            'smtp_from_name' => $request->smtp_from_name,
        ]);

        // toastr()->success('Email Setting Successfully Saved', 'Success');
        flash('Email Setting Successfully Saved', 'success');
        return redirect()->back();
    }

    public function email_test()
    {

        // $settings = SettingEmail::first();

        //     Config::set('mail.mailers.smtp.host', $settings->smtp_host);
        //     Config::set('mail.mailers.smtp.port', $settings->smtp_port);
        //     Config::set('mail.mailers.smtp.username', $settings->smtp_username);
        //     Config::set('mail.mailers.smtp.password', $settings->smtp_password);
        //     Config::set('mail.mailers.smtp.encryption', $settings->ssl_protocol == 'on' ? 'ssl' : null);
        //     // Config::set('mail.mailers.smtp.timeout', $settings->smtp_timeout);
        //     Config::set('mail.mailers.smtp.from.address', $settings->smtp_from_email);
        //     Config::set('mail.mailers.smtp.from.name', $settings->smtp_from_name);

        try {
            Mail::raw('Test email from system', function($message) {
                $message->to('syafiqchenor@gmail.com')
                        ->subject('SMTP Test');
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
        return redirect()->back()->with('success', 'Test email sent successfully');
    }
}
