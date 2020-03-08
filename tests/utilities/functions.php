<?php

namespace Tests\utilities;

use Illuminate\Database\Eloquent\Model;

    /**
     * Used to simplify and mock factory creation method
     *
     * @param $class
     * @param array $attributes
     *
     * @return Model
     */
    function create($class, $attributes = [])
    {
        return factory($class)->create($attributes);
    }

    /**
     * Used to simplify and mock factory make method
     *
     * @param $class
     * @param array $attributes
     *
     * @return Model
     */
    function make($class, $attributes = [])
    {
        return factory($class)->make($attributes);
    }
