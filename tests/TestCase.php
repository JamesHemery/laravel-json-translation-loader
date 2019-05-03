<?php

namespace Jamesh\JsonTranslationLoader\Test;

use Jamesh\JsonTranslationLoader\TranslationServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{

    protected function getPackageProviders($app)
    {
        return [
            TranslationServiceProvider::class,
            DummyServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['path.lang'] = $this->getFixturesDirectory('lang');
    }

    public function getFixturesDirectory(string $path): string
    {
        return __DIR__ . "/fixtures/{$path}";
    }

}
