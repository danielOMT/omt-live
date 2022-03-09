<?php

namespace OMT\Services\AdvancedCustomFields\Fields;

class ImageUrl extends Field
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

        return $this->getAttachmentUrl($value['file']);
    }
}
