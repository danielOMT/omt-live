<div x-data="xDeleteToolTrackingLink()">
    <div x-show="error" class="x-text-left x-mb-4 x-pl-2 x-pr-2 x-pt-2 x-pb-2 x-rounded x-items-center x-shadow x-flex x-w-full x-text-red-600 x-bg-red-50">
        <div class="x-flex">
            <svg xmlns="http://www.w3.org/2000/svg" class="x-fill-current x-w-5" viewBox="0 0 24 24">
                <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/>
            </svg>
        </div>

        <div class="x-text-red-800 x-flex-1 x-ml-4" x-text="message"></div>
    </div>

    <?php if (WP_ENV === 'development') : ?>
        <div class="x-border-solid x-mb-4 x-pb-2 x-pl-2 x-pr-2 x-pt-2 x-rounded x-text-left x-text-red-600 x-w-full">
            <strong>Development Mode:</strong>
            <div>Please be SURE you DO NOT delete PRODUCTION ClickMeter links.</div>
        </div>
    <?php endif ?>

    <div class="x-flex">
        <div class="x-self-center">Möchten Sie <?php echo $this->tool->post_title ?> Tracking-Link wirklich löschen?</div>

        <button 
            type="button"
            class="button button-red x-ml-4"
            @click="destroy(<?php echo $this->tool->ID ?>, <?php echo (int) $this->link->category_id ?>, '<?php echo $this->link->type ?>')"
            :disabled="loading"
        >
            <svg x-show="loading" class="x-animate-spin x-h-5 x-w-5 x-align-middle x-mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="x-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="x-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>

            Löschen
        </button>
    </div>
</div>