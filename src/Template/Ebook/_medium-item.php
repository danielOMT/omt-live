<div class="teaser teaser-medium teaser-matchbuttons ebook-teaser-item">
    <?php include '_image.php' ?>

    <h2 class="h4 article-title no-ihv teaser-two-lines-title">
        <a
            x-data="xLinesClamping()"
            x-init="clamp(2)"
            href="<?php echo get_the_permalink($ebook->ID) ?>" 
            title="<?php echo htmlspecialchars($ebook->extra->original_title) ?>"
        >
            <?php echo $ebook->extra->title ?>
        </a>
    </h2>

    <?php if (empty($ebook->extra->category->associated_theme_page) || $ebook->extra->category->associated_theme_page == get_the_permalink(get_the_ID())) : ?>
        <span class="teaser-cat category-link"><?php echo $ebook->extra->category->name ?></span>
    <?php else : ?>
        <a class="teaser-cat category-link" href="<?php echo $ebook->extra->category->associated_theme_page ?>"><?php echo $ebook->extra->category->name ?></a>
    <?php endif; ?>

    <?php if ($this->showExpert && $ebook->extra->expert) : ?>
        <p class="experte no-margin-top no-margin-bottom">
            <?php if ($ebook->extra->expert->ID == get_the_ID()) : ?>
                <span><?php echo $ebook->extra->expert->post_title ?></span>
            <?php else : ?>
                <a href="<?php echo get_the_permalink($ebook->extra->expert->ID) ?>"><?php echo $ebook->extra->expert->post_title ?></a>
            <?php endif ?>
        </p>
    <?php endif; ?>
    
    <?php if (!empty($ebook->extra->description)) : ?>
        <div class="vorschautext">
            <?php echo $ebook->extra->description ?>
        </div>
    <?php endif; ?>
</div>