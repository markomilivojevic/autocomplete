<?php

namespace Ducha\Autocomplete\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Autocomplete
 * 
 * @method static bool addTerm(string $bucket, string $term)
 * @method static int addTerms(string $bucket, array $terms)
 * @method static bool removeTerm(string $bucket, string $term)
 * @method static array complete(string $bucket, string $prefix)
 * @method static array all(string $bucket)
 *
 * @see \Ducha\Autocomplete\Autocomplete
 * 
 * @package Ducha\Autocomplete\Facades
 */
class Autocomplete extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'autocomplete';
    }
}
