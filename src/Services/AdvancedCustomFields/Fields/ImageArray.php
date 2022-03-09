<?php

namespace OMT\Services\AdvancedCustomFields\Fields;

class ImageArray extends Field
{
    use AttachmentTrait;

    /**
     * Get image meta by attachment_id
     */
    public function getValue(int $postId = null, string $key, $rawValue)
    {
        if (is_numeric($rawValue)) {
            $imageData = get_post_meta((int) $rawValue, '_wp_attachment_metadata', true);

            if (is_array($imageData)) {
                $imageData['attachment_id'] = $rawValue;

                return $imageData;
            }
        }

        return false;
    }

    public function format($value)
    {
        if (!is_array($value) || empty($value['file'])) {
            return false;
        }

        $value['sizes'] ??= [];
        $value['url'] = $this->getAttachmentUrl($value['file']);
        $urlBasename = wp_basename($value['url']);

        foreach (get_intermediate_image_sizes() as $size) {
            if (isset($value['sizes'][$size])) {
                $value['sizes'][$size]['url'] = str_replace($urlBasename, wp_basename($value['sizes'][$size]['file']), $value['url']);
            } else {
                $src = wp_get_attachment_image_src($value['attachment_id'], $size);

                $value['sizes'][$size] = !$src ? null : [
                    'file' => wp_basename($src[0]),
                    'url' => $src[0],
                    'width' => $src[1],
                    'height' => $src[2],
                ];
            }
        }

        return $value;
    }
}
