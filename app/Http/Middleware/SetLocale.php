<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\SettingGeneral;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check session first for locale
        $locale = Session::get('locale');
        
        // If no locale in session, get from database setting_general table
        if (!$locale) {
            try {
                $setting = SettingGeneral::first();
                $locale = $setting->language ?? 'en';
            } catch (\Exception $e) {
                // Fallback to English if database query fails
                $locale = 'en';
            }
        }
        
        // Ensure locale is valid (only allow 'en' or 'ms')
        if (!in_array($locale, ['en', 'ms'])) {
            $locale = 'en';
        }
        
        app()->setLocale($locale);

        return $next($request);
    }
}