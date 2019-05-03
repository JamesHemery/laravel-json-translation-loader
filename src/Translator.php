<?php

namespace Jamesh\JsonTranslationLoader;

use Illuminate\Translation\Translator as IlluminateTranslator;

/**
 * Class Translator
 * @package Jamesh\JsonTranslationLoader
 */
class Translator extends IlluminateTranslator
{

    /**
     * @inheritDoc
     */
    protected function parseBasicSegments(array $segments)
    {
        if (count($segments) > 1) {
            $group = array_shift($segments);
            $item = implode('.', $segments);
        } else {
            $group = '*';
            $item = $segments[0];
        }

        return [null, $group, $item];
    }

    /**
     * @inheritDoc
     */
    protected function parseNamespacedSegments($key)
    {
        [$namespace, $keyRest] = explode('::', $key);

        // First we'll just explode the first segment to get the namespace and rest of key
        // since the group and item should be in the remaining segments. Once we have these
        // pieces of data we can proceed with parsing out the item's value.
        $segments = explode('.', $keyRest);

        // If there are several pieces in the segments, we consider that the first is the
        // group and the item should be in the remaining segments. Else, the only piece
        // is the item so we associate the global group.
        if (count($segments) > 1) {
            $group = $segments[0];
            $item = implode('.', array_slice($segments, 1));
        } else {
            $group = '*';
            $item = $segments[0];
        }

        return [$namespace, $group, $item];
    }

}