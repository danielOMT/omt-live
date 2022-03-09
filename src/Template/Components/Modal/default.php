<?php

$includeScripts = isset($this->scripts) ? $this->scripts : true;

if ($includeScripts) {
    wp_enqueue_script('alpinejs', get_template_directory_uri() . '/library/js/libs/alpine.min.js', ['alpine-modal']);
    wp_enqueue_script('alpine-modal', get_template_directory_uri() . '/library/js/core/modal.js');
}
?>
<span 
    x-data="xModal('<?php echo !empty($this->name) ? $this->name : null ?>')" 
    @open-modal.window="open($event.detail)"
    @close-modal.window="close($event.detail)"
>
    <?php if (!empty($this->buttonTitle)) : ?>
        <button
            type="button"
            @click="open()"
            class="<?php echo $this->buttonClass ?? 'x-bg-transparent x-border-0 x-text-red-600 x-text-sm' ?>"
        >
            <?php echo $this->buttonTitle ?>
        </button>
    <?php endif ?>

    <!-- Modal -->
    <div 
        x-show="showModal" 
        x-cloak 
        class="x-fixed x-left-0 x-bottom-0 x-w-full x-h-full x-z-9999 omt-modal-window"
    >
        <div class="x-flex x-items-center x-justify-center x-min-h-screen">
            <div 
                @mousedown.away="close()"
                class="x-bg-white x-flex x-flex-col x-p-4 x-rounded omt-modal-content"
            >
                <div class="x-flex x-items-center x-w-full">
                    <div class="x-text-lg"><strong><?php echo $this->title ?></strong></div>
                    
                    <button @click="close()" type="button" class="x-ml-auto x-border-0 x-bg-transparent">
                        <svg class="x-w-6 x-h-6 x-align-middle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"/>
                        </svg>
                    </button>
                </div>

                <hr class="x-my-4 x-border-t-0 x-border-b x-border-blue-300 x-w-full">

                <!-- Modal content -->
                <div class="x-overflow-y-auto">
                    <?php echo $this->content ?>
                </div>

                <hr class="x-my-4 x-border-t-0 x-border-b x-border-blue-300 x-w-full">

                <div class="x-flex x-justify-end x-w-full">
                    <button 
                        @click="close()" 
                        class="button button-grey" 
                        type="button"
                    >
                        Schließen
                    </button>
                </div>
            </div>
        </div>
    </div>
</span>
