<?php

namespace Jamesh\JsonTranslationLoader;

use Illuminate\Translation\TranslationServiceProvider as IlluminateTranslationServiceProvider;

/**
 * Class TranslationServiceProvider
 * @package Jamesh\JsonTranslationLoader
 */
class TranslationServiceProvider extends IlluminateTranslationServiceProvider
{

    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        $this->registerLoader();

        $this->app->singleton('translator', function ($app) {
            $loader = $app['translation.loader'];

            // When registering the translator component, we'll need to set the default
            // locale as well as the fallback locale. So, we'll grab the application
            // configuration so we can easily get both of these values from there.
            $locale = $app['config']['app.locale'];

            $trans = new Translator($loader, $locale);

            $trans->setFallback($app['config']['app.fallback_locale']);

            return $trans;
        });
    }

    /**
     * Overload parent method to use custom FileLoader
     * @inheritDoc
     */
    protected function registerLoader()
    {
        $this->app->singleton('translation.loader', function ($app) {
            return new FileLoader($app['files'], $app['path.lang']);
        });
    }

}
