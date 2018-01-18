<?php

namespace Bluewren\SESChecker;

use Illuminate\Support\ServiceProvider;

class SESCheckerServiceProvider extends ServiceProvider
{

	/**
	* Check to see if we're using lumen or laravel.
	*
	* @return bool
	*/
	public function isLumen()
	{
		$lumenClass = 'Laravel\Lumen\Application';
		return ($this->app instanceof $lumenClass);
	}

	/**
	* Bootstrap the application services.
	*
	* @return void
	*/
	public function boot()
	{
		// Publish the config file
		$this->publishConfig();

        // Hook into the mailer
        $this->registerSwiftPlugin();
	}

	/**
	* Register the application services.
	*
	* @return void
	*/
	public function register()
	{
		//
	}

	/**
	* Publish the configuration files
	*
	* @return void
	*/
	protected function publishConfig()
	{
		if (!$this->isLumen()) {
			$this->publishes([
				__DIR__.'/../config/ses-checker.php' => config_path('ses-checker.php')
			], 'config');
		}
	}

	/**
     * Register the Swift plugin
     *
     * @return void
     */
    protected function registerSwiftPlugin()
    {
        $this->app['mailer']->getSwiftMailer()->registerPlugin(new SESChecker());
    }
}
