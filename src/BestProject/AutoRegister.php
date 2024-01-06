<?php

namespace BestProject;

use ReflectionClass;

/**
 * Helper class executing all its public methods on register() method call.
 */
abstract class AutoRegister
{

    /**
     * Call all public methods in this class.
     *
     * @return void
     */
    public static function register(): void
    {
        $reflection = new ReflectionClass(static::class);

        foreach( $reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method ) {
            if( $method->name==='register' ) {
                continue;
            }

            static::{$method->name}();
        }
    }

}