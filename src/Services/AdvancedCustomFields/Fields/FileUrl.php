<?php

namespace OMT\Services\AdvancedCustomFields\Fields;

class FileUrl extends Field
{
    use AttachmentTrait;

    /**
     * Get file meta by attachment_id
     */
    public function getValue(int $postId = null, string $key, $rawValue)
    {
        if (is_numeric($rawValue)) {
            return [
                'file' => get_post_meta((int) $rawValue, '_wp_attached_file', true),
                'attachment_id' => $rawValue
            ];
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
