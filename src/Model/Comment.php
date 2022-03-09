<?php

namespace OMT\Model;

class Comment extends Model
{
    public function count(int $postId)
    {
        return (int) $this->db->get_var(
            'SELECT COUNT(`comment_ID`) FROM ' . $this->db->comments . ' WHERE `comment_post_ID` = ' . $postId . ' AND `comment_approved` = 1 AND `comment_type` = "comment"'
        );
    }
}
