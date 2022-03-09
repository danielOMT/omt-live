<?php

use OMT\Services\Date;
use OMT\View\Components\ModalView;
use OMT\View\View;

?>
<div id="content" class="omt-downloads-content">
    <div class="omt-row hero-header header-flat omt-downloads-header">
        <div class="wrap">
            <h1 class="x-text-center"><?php echo $this->title ?></h1>
        </div>
    </div>
    <div id="inner-content" class="wrap clearfix">
        <div id="main" class="omt-row clearfix" role="main">
            <article <?php post_class(['clearfix', 'x-mb-10']); ?> role="article">
                <div class="entry-content x-mt-8 x-flex x-justify-between" itemprop="articleBody">
                    <div class="left-image">
                        <img class="download-image" alt="<?php echo $this->title ?>" title="<?php echo $this->title ?>" src="<?php echo $this->leftImageUrl['sizes']['large']['url'] ?>" loading="lazy" />
                    </div>
                    <div>
                        <div class="x-mb-10 downloads-content-section">
                            <?php echo $this->content ?>
                        </div>

                        <div class="downloads-sticky-buttons x-bg-white">
                            <div class="downloads-sticky-buttons-wrap x-pt-2 x-pb-2">
                                <div class="x-flex downloads-buttons downloads-buttons-top <?php echo $this->buttonsAsRows ? 'x-flex-col' : 'x-justify-end' ?>">
                                    <?php if (isset($this->firstCheckoutButton) && $this->firstCheckoutButton->product) : ?>
                                        <div x-data class="<?php echo $this->buttonsAsRows ? 'x-mb-2' : '' ?>">
                                            <button
                                                type="button"
                                                @click="$dispatch('open-modal', 'woocommerce-checkout')"
                                                class="button downloads-button button-red x-text-base x-w-full"

                                                <?php if ($this->firstCheckoutButton->onClick) : ?>
                                                    onclick="<?php echo $this->firstCheckoutButton->onClick ?>"
                                                <?php endif ?>
                                            >
                                                <?php echo $this->firstCheckoutButton->label ?>
                                            </button>
                                        </div>
                                    <?php endif ?>

                                    <?php if (isset($this->secondCheckoutButton) && $this->secondCheckoutButton->product) : ?>
                                        <div x-data class="<?php echo $this->buttonsAsRows ? 'x-mb-2' : 'x-ml-4' ?>">
                                            <button
                                                type="button"
                                                @click="$dispatch('open-modal', 'woocommerce-checkout')"
                                                class="button downloads-button button-red x-text-base x-w-full"

                                                <?php if ($this->secondCheckoutButton->onClick) : ?>
                                                    onclick="<?php echo $this->secondCheckoutButton->onClick ?>"
                                                <?php endif ?>
                                            >
                                                <?php echo $this->secondCheckoutButton->label ?>
                                            </button>
                                        </div>
                                    <?php endif ?>

                                    <?php if (!empty($this->downloadButton->formId) && (!$this->downloadButton->deactivateUntil || $this->downloadButton->deactivateUntil <= Date::get())) : ?>
                                        <div class="<?php echo $this->buttonsAsRows ? 'x-mb-2' : 'x-ml-4' ?>">
                                            <!--[if lte IE 8]>
                                            <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2-legacy.js"></script>
                                            <![endif]-->
                                            <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>

                                            <?php echo ModalView::loadTemplate('default', [
                                                'title' => $this->downloadButton->label,
                                                'buttonTitle' => $this->downloadButton->label,
                                                'buttonClass' => 'button downloads-button x-text-base x-w-full',
                                                'content' => '<script>hbspt.forms.create({ portalId: "3856579", formId: "' . $this->downloadButton->formId . '" });</script>'
                                            ]) ?>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($this->peopleHeadline)) : ?>
                    <div class="x-mt-16">
                        <h2><?php echo $this->peopleHeadline ?></h2>
                    </div>
                <?php endif ?>

                <?php if (is_array($this->people) && count($this->people)) : ?>
                    <div class="x-bg-gray-200 x-flex x-flex-wrap x-justify-between x-pl-6 x-pr-6 x-pt-6 x-pb-6 downloads-people-container">
                        <?php foreach ($this->people as $key => $person) : ?>
                            <?php $personAvatar = $person['avatar']
                                ? $person['avatar']['sizes']['140-72']['url']
                                : getPost($person['person'])->field('profilbild', 'image_array')['sizes']['140-72']['url'];
                            ?>
                            <div class="x-text-center x-pl-10 x-pr-10 x-flex-25 person-section slick-slide">
                                <div class="x-rounded-full x-overflow-hidden x-border-6 x-border-white x-border-solid x-ml-4 x-mr-4">
                                    <img 
                                        class="x-m-0 x-w-full"
                                        alt="<?php echo getPost($person['person'])->post_title ?>"
                                        title="<?php echo getPost($person['person'])->post_title ?>"

                                        <?php if ($key < 4) : ?>
                                            src="<?php echo $personAvatar ?>"
                                        <?php else : ?>
                                            data-lazy="<?php echo $personAvatar ?>"
                                        <?php endif; ?>
                                    />
                                </div>
                                <div class="x-pt-4">
                                    <a href="<?php echo get_the_permalink($person['person']); ?>">
                                        <?php echo getPost($person['person'])->post_title ?>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>

                <?php if (is_array($this->reviews) && count($this->reviews)) : ?>
                    <div class="x-mt-16 reviews-section">
                        <?php foreach ($this->reviews as $key => $review) : ?>
                            <?php if ($key < 2) : ?>
                                <?php echo View::loadTemplate(['Elements' => 'review'], [
                                    'review' => $review['review'],
                                    'name' => $review['name'],
                                    'position' => $review['position'],
                                    'avatar' => $review['avatar']['sizes']['140-72']['url']
                                ]) ?>
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>

                    <?php if (count($this->reviews) > 2) : ?>
                        <div class="x-text-center" x-data="{}">
                            <button 
                                type="button" 
                                class="x-text-xl x-bg-transparent x-border-0"
                                @click="document.getElementById('more-reviews').scrollIntoView({ behavior: 'smooth' })"
                            >
                                <strong>weitere Rezensionen <span class="x-text-sm x-pl-2 x-font-bold x-align-middle">&#8897;</span></strong>
                            </button>
                        </div>
                    <?php endif ?>
                <?php endif ?>

                <?php if (!empty($this->firstContent) || is_array($this->firstContentImage)) : ?>
                    <div class="x-flex x-gap-2 x-bg-gray-200 x-justify-between x-pl-12 x-pr-12 x-pt-20 x-pb-20 x-mt-16 downloads-content-1">
                        <?php if (!empty($this->firstContent)) : ?>
                            <div class="x-flex-1 downloads-content-section">
                                <?php echo $this->firstContent ?>
                            </div>
                        <?php endif ?>

                        <?php if (is_array($this->firstContentImage)) : ?>
                            <div class="x-flex-1">
                                <img 
                                    class="x-mb-0" 
                                    src="<?php echo $this->firstContentImage['sizes']['large']['url'] ?>"
                                    alt="<?php echo $this->firstContentImage['sizes']['large']['file'] ?>"
                                    loading="lazy"
                                />
                            </div>
                        <?php endif ?>
                    </div>
                <?php endif ?>

                <?php if (!empty($this->secondContent) || is_array($this->secondContentImage)) : ?>
                    <div class="x-flex x-gap-4 x-justify-between x-pl-12 x-pr-12 x-mt-16 x-pt-10 downloads-content-2">
                        <?php if (is_array($this->secondContentImage)) : ?>
                            <div class="x-flex-1">
                                <img 
                                    class="x-mb-0" 
                                    src="<?php echo $this->secondContentImage['sizes']['large']['url'] ?>"
                                    alt="<?php echo $this->secondContentImage['sizes']['large']['file'] ?>"
                                    loading="lazy"
                                />
                            </div>
                        <?php endif ?>

                        <?php if (!empty($this->secondContent)) : ?>
                            <div class="x-flex-1 downloads-content-section">
                                <?php echo $this->secondContent ?>
                            </div>
                        <?php endif ?>
                    </div>
                <?php endif ?>

                <?php if (is_array($this->reviews) && count($this->reviews) > 2) : ?>
                    <div class="x-pt-16 reviews-section" id="more-reviews">
                        <?php foreach ($this->reviews as $key => $review) : ?>
                            <?php if ($key >= 2) : ?>
                                <?php echo View::loadTemplate(['Elements' => 'review'], [
                                    'review' => $review['review'],
                                    'name' => $review['name'],
                                    'position' => $review['position'],
                                    'avatar' => $review['avatar']['sizes']['140-72']['url']
                                ]) ?>
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>

                <?php if (isset($this->firstCheckoutButton) && $this->firstCheckoutButton->product) : ?>
                    <div x-data class="x-flex x-justify-center downloads-buttons">
                        <button
                            type="button"
                            @click="$dispatch('open-modal', 'woocommerce-checkout')"
                            class="button downloads-button button-red x-text-base"

                            <?php if ($this->firstCheckoutButton->onClick) : ?>
                                onclick="<?php echo $this->firstCheckoutButton->onClick ?>"
                            <?php endif ?>
                        >
                            <?php echo $this->firstCheckoutButton->label ?>
                        </button>
                    </div>
                <?php endif ?>

                <?php if ((isset($this->firstCheckoutButton) && $this->firstCheckoutButton->product) || (isset($this->secondCheckoutButton) && $this->secondCheckoutButton->product)) : ?>
                    <?php echo ModalView::loadTemplate('default', [
                        'name' => 'woocommerce-checkout',
                        'title' => 'Kaufen',
                        'content' => '<div class="woocommerce-embed-checkout">' . do_shortcode('[woocommerce_checkout]') . '</div>'
                    ]) ?>
                <?php endif ?>
            </article>
        </div>
    </div>
</div>