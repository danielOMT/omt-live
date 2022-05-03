<div class="x-flex x-mt-10 x-mb-10 review-section">
    <div class="x-flex-1">
        <div class="x-bg-gray-200 x-pl-16 x-pr-16 x-pt-10 x-pb-10 x-rounded-5xl x-relative review-content-section">
            <strong><?php echo $this->review ?></strong>
        </div>
    </div>

    <div class="x-relative review-avatar-container">
        <div class="x-absolute review-avatar-section">
            <div class="x-pl-10 x-pr-10 avatar-image-section">
                <div class="x-rounded-full x-overflow-hidden">
                    <?php if (strlen($this->avatar)>0) { ?>
                    <img
                        class="x-m-0" 
                        src="<?php echo $this->avatar ?>" 
                        loading="lazy" 
                        alt="<?php echo $this->name ?>" 
                        title="<?php echo $this->name ?>" 
                    />
                    <?php } ?>
                </div>
            </div>
            <div class="x-text-center x-mt-2">
                <strong><?php echo $this->name ?></strong>
            </div>
            <div class="x-text-center x-text-gray x-text-xs x-mb-4">
                <?php echo $this->position ?>
            </div>
        </div>
    </div>
</div>