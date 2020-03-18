<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use URL;
use App\Models\cashier\Cashiers;
use App\Models\master_data\Shift;
class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */

    public function boot()
    {
        $route_name = explode('/',$this->app->request->getRequestUri());
        $route      = null;
        $route_url  = null;
        // local
        if( isset($route_name[2]) && $route_name[2] === 'public' && count($route_name) > 4)
        {
            $route      = $route_name[3].'.'.$route_name[4];
            $route_url  = URL::to($route_name[3].'/'.$route_name[4]);
        } elseif(count($route_name) === 3 || count($route_name) === 4) {
            $route      = $route_name[1].'.'.$route_name[2];
            $route_url  = URL::to($route_name[1].'/'.$route_name[2]);
        }

        view()->share('route_index', $route.'.index');
        view()->share('route_create', $route.'.create');
        view()->share('route_store', $route.'.store');
        view()->share('route_show', $route.'.show');
        view()->share('route_edit', $route.'.edit');
        view()->share('route_update', $route.'.update');
        view()->share('route_destroy', $route_url);
        view()->share('url_ajax_datatable', $route_url.'/ajax_datatable');

        // share cashier status to sidebar
        view()->composer('layouts.sidebar', function ($view){
            $id_cashiers = Cashiers::with('employee', 'shift')->where('opened', true)->where('closed', false)->first();
            $shift       = Shift::whereTime('start_time', '<', date("H:i:s"))
                                ->whereTime('end_time', '>', date("H:i:s"))
                                ->first();
            $shift = $shift ?? Shift::latest('id')->first(); // if null then shift malam
            $view->with('id_cashiers', json_encode($id_cashiers));
            $view->with('shift', $shift);
        });
 
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
