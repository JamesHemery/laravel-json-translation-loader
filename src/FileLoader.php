<?php

namespace Jamesh\JsonTranslationLoader;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Translation\FileLoader as IlluminateFileLoader;
use RuntimeException;

/**
 * Class FileLoader
 * @package Jamesh\JsonTranslationLoader
 */
class FileLoader extends IlluminateFileLoader
{

    /**
     * Overload parent method to load also json file with namespace
     * @inheritDoc
     */
    public function load($locale, $group, $namespace = null)
    {
        $lines = parent::load($locale, $group, $namespace);

        $filename = (!is_null($group) && $group !== '*')
            ? "{$locale}/{$group}.json"
            : "{$locale}.json";

        if ($namespace !== '*' && !is_null($namespace)) {
            $lines = array_replace_recursive(
                $lines,
                $this->loadJsonPath("{$this->hints[$namespace]}/{$filename}")
            );

            $lines = $this->loadNamespaceJsonOverrides($lines, $namespace, $filename);
        } elseif (!is_null($group) && $group !== '*') {
            $lines = array_replace_recursive(
                $lines,
                $this->loadJsonPath("{$this->path}/{$filename}")
            );
        }

        return $lines;
    }

    /**
     * Load a local namespaced JSON translation for overrides.
     *
     * @param array $lines
     * @param $namespace
     * @param $filename
     * @return array
     * @throws FileNotFoundException
     */
    protected function loadNamespaceJsonOverrides(array $lines, $namespace, $filename)
    {
        $path = "{$this->path}/vendor/{$namespace}/{$filename}";

        $lines = array_replace_recursive(
            $lines,
            $this->loadJsonPath($path)
        );

        return $lines;
    }

    /**
     * Get lines from a JSON translation file
     *
     * @param $path
     * @return array
     * @throws RuntimeException
     * @throws FileNotFoundException
     */
    protected function loadJsonPath($path): array
    {
        if ($this->files->exists($path)) {
            $decoded = json_decode($this->files->get($path), true);

            if (is_null($decoded) || json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException("Translation file [{$path}] contains an invalid JSON structure.");
            }

            return $decoded;
        }

        return [];
    }

}