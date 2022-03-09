<?php

namespace OMT\Model;

use stdClass;

class OmtStudentWork extends PostModel
{
    protected $postType = 'omt_student';

    /**
     * Get student works linked to an author
     *
     * @param int $authorId
     *
     * @return array
     */
    public function authorStudentWorks(int $authorId)
    {
        return $this->withExtraData(
            $this->items(['expert' => $authorId]),
            [
                'title',
                'image'
            ]
        );
    }

    public function withExtraData(array $items = [], array $fields = [])
    {
        foreach ($items as $item) {
            $item->extra ??= new stdClass;

            $item->extra->title = $this->getExtraFieldValue($fields, 'title', 'vorschautitel', $item->ID) ?: get_the_title($item);
            $item->extra->image = $this->getExtraFieldValue($fields, 'image', 'vorschaubild', $item->ID);
        }

        return $items;
    }
}
