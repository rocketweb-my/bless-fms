<?php

namespace App\Providers;

// use ConsoleTVs\Charts\Registrar as Charts;
use App\Models\LookupPriority;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $charts->register([
        //     \App\Charts\DashboardChart::class
        // ]);

        if(systemGeneralSetting() != null && systemGeneralSetting()->language != null)
        {
            $language = systemGeneralSetting()->language;
        }else{
            $language = 'en';
        }
        $this->app->setLocale($language);

        // Share active priorities with all views
        View::composer('*', function ($view) {
            $activePriorities = LookupPriority::active()->orderBy('priority_value')->get();
            $view->with('activePriorities', $activePriorities);
        });
    }
}
