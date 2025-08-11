<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\SettingEmail;

class EmailConfigServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        try {
            $settings = SettingEmail::first();

            if ($settings) {
                // Set the mail driver/transport
                Config::set('mail.default', 'smtp');
                
                // Configure SMTP settings
                // Config::set('mail.mailers.smtp', [
                //     'transport' => 'smtp',
                //     'host' => $settings->smtp_host,
                //     'port' => $settings->smtp_port,
                //     'encryption' => $settings->ssl_protocol == 'on' ? 'ssl' : 
                //                   ($settings->tls_protocol == 'on' ? 'tls' : null),
                //     'username' => $settings->smtp_username,
                //     'password' => $settings->smtp_password,
                //     'timeout' => $settings->smtp_timeout,
                //     'auth_mode' => null,
                // ]);
                Config::set('mail.mailers.smtp.host', $settings->smtp_host);
                Config::set('mail.mailers.smtp.port', $settings->smtp_port);
                Config::set('mail.mailers.smtp.username', $settings->smtp_username);
                Config::set('mail.mailers.smtp.password', $settings->smtp_password);
                Config::set('mail.mailers.smtp.encryption', $settings->ssl_protocol == 'on' ? 'ssl' : null);
                // Config::set('mail.mailers.smtp.timeout', $settings->smtp_timeout);
                Config::set('mail.mailers.smtp.from.address', $settings->smtp_from_email);
                Config::set('mail.mailers.smtp.from.name', $settings->smtp_from_name);

                // Set default from address
                Config::set('mail.from.address', $settings->smtp_username);
                Config::set('mail.from.name', config('app.name'));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to load email settings: ' . $e->getMessage());
        }
    }
}