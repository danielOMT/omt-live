<?php

use OMT\Ajax\FilterArticles;
use OMT\Enum\Magazines;

FilterArticles::getInstance()->enqueueScripts();
?>
<div 
    x-data="xArticleFilter()"
    class="header-omt-filter"
>
    <div class="header-omt-filter-inner">
        <div class="omt-filter">
            <select
                @change="fetch"
                x-model="post_type"
                class="omt-filter-dropdown"
            >
                <option value="0" disabled>Zu welchen Themen suchst Du Artikel?</option>

                <?php foreach (Magazines::all() as $postType => $label) : ?>
                    <option value="<?php echo $postType ?>"><?php echo $label ?></option>
                <?php endforeach ?>
            </select>
        </div>
    </div>
</div>