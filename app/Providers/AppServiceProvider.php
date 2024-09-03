<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades;
use App\View\Composers\SidebarComposer;
use Illuminate\Support\Facades\View;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Facades\View::composer('layouts.sidebar', SidebarComposer::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $route_name = explode('/',\Request::getRequestUri());
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
        
        View::share('route_index', $route.'.index');
        View::share('route_create', $route.'.create');
        View::share('route_store', $route.'.store');
        View::share('route_show', $route.'.show');
        View::share('route_edit', $route.'.edit');
        View::share('route_update', $route.'.update');
        View::share('route_destroy', $route_url);
        View::share('url_ajax_datatable', $route_url.'/ajax_datatable');
    }
}
