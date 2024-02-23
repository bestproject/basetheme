<?php

namespace BestProject\Plugin;

use WPCF7_ContactForm;
use WPCF7_FormTag;
use WPCF7_FormTagsManager;

class ContactForm7
{

    /**
     * Add default Bootstrap classes to contact form output.
     *
     * @param   array  $attributes
     * @param    $replace
     *
     * @return array
     */
    public static function addBootstrapAttributes($attributes, $replace): array
    {
        if( self::tagTypeMatches($attributes['type'], ['textarea','text','email','tel','select','url','number','date']) ) {
            $attributes['options'][] = 'class:form-control';
        } else if (self::tagTypeMatches($attributes['type'], ['select'])) {
            $attributes['options'][] = 'class:form-select';
        } else if (self::tagTypeMatches($attributes['type'], ['submit'])) {
            $attributes['options'][] = 'class:btn';
            $attributes['options'][] = 'class:btn-primary';
            $attributes['options'][] = 'class:px-lg-70';
            $attributes['options'][] = 'class:py-4';
            $attributes['options'][] = 'class:rounded-0';
        }

        return $attributes;
    }

    protected static function tagTypeMatches(string $tagType, array $tags): bool
    {
        $added_tags = [];
        array_walk($tags, static function($value) use (&$added_tags){

            if( $value[-1]==='*' ) {
                return;
            }

            $added_tags[] = $value.'*';
        });

        array_push($tags, ...$added_tags);

        return in_array($tagType, $tags, true);
    }
}