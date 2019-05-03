<?php

namespace Jamesh\JsonTranslationLoader\Test;

use Illuminate\Support\ServiceProvider;

class DummyServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->app['translator']->addNamespace('dummy', __DIR__ . '/fixtures/dummy/lang');
    }

}
