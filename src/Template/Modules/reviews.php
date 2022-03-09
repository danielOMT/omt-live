<?php

use OMT\View\View;

?>
<div class="reviews-section <?php echo $this->fixedTopRight ? 'fixed-reviews-section' : '' ?>">
    <?php foreach ($this->items as $review) : ?>
        <?php echo View::loadTemplate(['Elements' => 'review'], [
            'review' => $review['review'],
            'name' => $review['name'],
            'position' => $review['position'],
            'avatar' => $review['predefined_avatar'] 
                ? $this->avatarUrls[$review['predefined_avatar']] 
                : $review['avatar']['sizes']['140-72']
        ]) ?>
    <?php endforeach ?>
</div>