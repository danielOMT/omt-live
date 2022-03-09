<?php

namespace OMT\Filters;

class ArticleExpert extends Filter
{
    public function getImplemented()
    {
        return [
            'article'
        ];
    }

    protected function article($articleId)
    {
        return $this->expressionIN('article_id', $articleId);
    }
}
