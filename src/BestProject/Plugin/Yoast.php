<?php

namespace BestProject\Plugin;

/**
 * YoastSEO plugin hooks.
 */
class Yoast
{
    public static function changeBreadcrumbSeparator(): string
    {
        return '<i class="breadcrumb-separator mx-2" aria-hidden="true">/</i>';
    }

}