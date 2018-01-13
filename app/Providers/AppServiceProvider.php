<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Session;
use App\Manager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        view()->composer('*', function ($view) 
        {
            $view->with('manager_id', \Session::get('manager_id') );    

            $navs = [];
            $manager_id = $view->manager_id;

            if ($manager_id != null || !empty($manager_id)) {

                $manager = Manager::findOrFail($manager_id);

                foreach ($manager->games as $value) {

                    if (!$value->event->is_open) {
                        continue;
                    }

                    if (!in_array($value->game, $navs)) {
                        $navs[$value->id] = $value->game;
                    }
                }

            }
            
            view()->share('navs', $navs);
        
        }); 


        //
        // $manager_id = Session::all('manager_id');
        // dd($manager_id);
        // $manager = Manager::findOrFail($manager_id);

        // dd($manager);

        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if ($this->app->environment() == 'local') {
            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
        }
    }
}
