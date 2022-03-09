<?php

namespace OMT\Model\Datahost;

use OMT\Filters\ArticleExpert as ArticleExpertFilters;

class ArticleExpert extends Model
{
    protected function itemsConditions(array $filters = [])
    {
        return (new ArticleExpertFilters($this->getAlias()))->apply($filters);
    }

    protected function getTableName()
    {
        return 'article_expert';
    }
}
