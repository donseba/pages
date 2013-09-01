<?php namespace Micro\Pages;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class PagesServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;


    public function boot()
    {
        $this->package('micro/pages');

        Pages::$languages    = Config::get('pages::languages');

        Pages::$segments     = \Request::segments();

        Pages::$baseURL      = url( head( array_keys( Pages::$languages ) ) );

        Pages::$driver       = Config::get('pages::driver');

        Pages::$driverConfig = Config::get('pages::driverConfig');
    }



    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('pages');
    }


	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app['pages'] = $this->app->share(function($app)
        {
            return Pages::listen();
        });
	}

}