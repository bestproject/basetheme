<?php

namespace BestProject\Helper;

/**
 * Media helper.
 */
class MediaHelper
{

    /**
     * Get image tag.
     *
     * @param   int     $attachment_id  Attachment ID.
     * @param   array   $attribs        HTMl tag attributes.
     * @param   string  $size           Image size to return.
     *
     * @return string
     */
    public static function getImageTag(int $attachment_id, array $attribs = [], string $size = 'original'): string
    {
        $details = wp_get_attachment_image_src($attachment_id, $size);

        $attributes['src'] = $details[0];
        $attributes['alt'] = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
        $attributes['width'] = $details[1];
        $attributes['height'] = $details[2];
        $attributes = array_merge($attributes, $attribs);

        return '<img '.ArrayHelper::toAttributes($attributes).' />';
    }
}