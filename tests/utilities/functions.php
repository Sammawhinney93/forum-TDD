<?php

namespace Tests\utilities;

use Illuminate\Database\Eloquent\Model;

/**
 * Used to simplify and mock factory creation method
 *
 * @param $class
 * @param array $attributes
 *
 * @param null $times
 * @return Model
 */
    function create($class, $attributes = [], $times = null)
    {
        return factory($class, $times)->create($attributes);
    }

/**
 * Used to simplify and mock factory make method
 *
 * @param $class
 * @param array $attributes
 *
 * @param null $times
 * @return Model
 */
    function make($class, $attributes = [], $times = null)
    {
        return factory($class, $times)->make($attributes);
    }
