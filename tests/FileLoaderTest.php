<?php

namespace Jamesh\JsonTranslationLoader\Test;

use Illuminate\Support\Facades\App;

class FileLoaderTest extends TestCase
{

    public function test_basic(){
        $excepted = __('hello');
        $this->assertEquals('Hello!', $excepted);

        $excepted = __('messages.welcome');
        $this->assertEquals('Welcome developper!', $excepted);

        App::setLocale('fr');

        $excepted = __('hello');
        $this->assertEquals('Bonjour !', $excepted);

        $excepted = __('messages.welcome');
        $this->assertEquals('Bienvenue développeur !', $excepted);
    }


    public function test_namespaced(){
        $excepted = __('dummy::loading');
        $this->assertEquals('Loading...', $excepted);

        $excepted = __('dummy::messages.error');
        $this->assertEquals('An error occurred.', $excepted);

        App::setLocale('fr');

        $excepted = __('dummy::loading');
        $this->assertEquals('Chargement...', $excepted);

        $excepted = __('dummy::messages.error');
        $this->assertEquals('Une erreur est survenue.', $excepted);
    }

    public function test_namespaced_overrides(){

        $excepted = __('dummy::messages.required');
        $this->assertEquals('This is required.', $excepted);

        $excepted = __('dummy::save');
        $this->assertEquals('Save!', $excepted);

        App::setLocale('fr');

        $excepted = __('dummy::messages.required');
        $this->assertEquals('Requis.', $excepted);

        $excepted = __('dummy::save');
        $this->assertEquals('Sauvegarder', $excepted);
    }

    public function test_nested()
    {
        // Without namespace
        $excepted = __('*.nested.basic');
        $this->assertEquals("Basic test", $excepted);

        $excepted = __('nested');
        $this->assertArrayHasKey('basic', $excepted);

        // Without name and with group
        $excepted = __('messages.nested.test');
        $this->assertEquals('Nested group', $excepted);

        $excepted = __('messages.nested');
        $this->assertArrayHasKey('test', $excepted);

        // With namespace
        $excepted = __('dummy::*.nested.work');
        $this->assertEquals("It's work!", $excepted);

        $excepted = __('dummy::nested');
        $this->assertArrayHasKey('work', $excepted);
        $this->assertArrayHasKey('test', $excepted);

        // With namespace and group
        $excepted = __('dummy::messages.nested.test');
        $this->assertEquals("Nested group with namespace", $excepted);

        $excepted = __('dummy::messages.nested');
        $this->assertArrayHasKey('test', $excepted);
    }

    public function test_nested_override()
    {
        $excepted = __('dummy::*.nested.test');
        $this->assertEquals("Overrided", $excepted);

        $excepted = __('dummy::messages.nested.override');
        $this->assertEquals("Overrided", $excepted);
    }

}
