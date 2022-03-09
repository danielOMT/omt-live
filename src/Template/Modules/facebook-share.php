<a
    href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($this->url) ?>&quote=<?php echo urlencode($this->description) ?>"
    title="<?php echo $this->sharingTitle ?>" 
    aria-label="<?php echo $this->sharingTitle ?>" 
    class="x-border-0"
    role="button" 
    rel="nofollow" 
    target="_blank"
>
    <div class="x-flex x-items-center">
        <div class="x-bg-blue-700 x-flex x-mr-4 x-pb-1 x-pt-1 x-text-white x-rounded">
            <svg width="32px" height="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 32">
                <path class="x-fill-current" d="M17.1 0.2v4.7h-2.8q-1.5 0-2.1 0.6t-0.5 1.9v3.4h5.2l-0.7 5.3h-4.5v13.6h-5.5v-13.6h-4.5v-5.3h4.5v-3.9q0-3.3 1.9-5.2t5-1.8q2.6 0 4.1 0.2z"></path>
            </svg>
        </div>
        
        <div>
            <?php echo $this->sharingTitle ?>
        </div>
    </div>
</a>