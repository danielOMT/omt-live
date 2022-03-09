<?php if (!empty($this->url)) : ?>
    <a href="<?php echo $this->url ?>">
<?php endif ?>
    <div class="x-flex x-pl-6 x-pr-6 x-pt-6 x-pb-6 x-rounded-2xl x-shadow-lg profile-section-content">
        <div class="x-mr-4 profile-image-section">
            <div class="x-rounded-full x-overflow-hidden">
                <img 
                    class="x-m-0 profile-image" 
                    src="<?php echo $this->image['sizes']['thumbnail'] ?>" 
                    alt="<?php echo $this->title ?>" 
                    title="<?php echo $this->title ?>"
                >
            </div>
        </div>
        <div class="x-flex-1 x-ml-4">
            <div class="x-text-xl profile-headline">
                <strong><?php echo $this->title ?></strong>
            </div>
            <div class="x-text-lightblue">
                <?php echo $this->text ?>
            </div>
        </div>
    </div>
<?php if (!empty($this->url)) : ?>
    </a>
<?php endif ?>