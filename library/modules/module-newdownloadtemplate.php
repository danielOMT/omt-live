<?php
use OMT\Services\Date;
use OMT\View\Components\ModalView;
use OMT\View\View;

$bild = $zeile["inhaltstyp"][0]["bild"];
$text_rechte_seite = $zeile["inhaltstyp"][0]["text_rechte_seite"];
$hubspot_formular_id = $zeile["inhaltstyp"][0]["hubspot_formular_id"];
$button_label = $zeile["inhaltstyp"][0]["button_label"];
$autoren_headline = $zeile["inhaltstyp"][0]["autoren_headline"];
$autoren_slider = $zeile["inhaltstyp"][0]["downloads_people"];
?>
    <div class="entry-content x-mt-8 x-flex x-justify-between" itemprop="articleBody">
        <div class="left-image">
            <img class="download-image" alt="<?php echo $bild['alt']; ?>" title="<?php echo $bild['alt'] ?>" src="<?php echo $bild['sizes']['large']; ?>" loading="lazy" />
        </div>
        <div>
            <div class="x-mb-10 downloads-content-section">
                <?php echo $text_rechte_seite; ?>
            </div>
            <div class="downloads-sticky-buttons x-bg-white">
                <div class="downloads-sticky-buttons-wrap x-pt-2 x-pb-2">
                    <div class="x-flex downloads-buttons downloads-buttons-top x-flex-col">
                        <?php if (!empty($hubspot_formular_id)) : ?>
                            <div class="x-mb-2">
                                <!--[if lte IE 8]>
                                <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2-legacy.js"></script>
                                <![endif]-->
                                <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>
                                <?php echo ModalView::loadTemplate('default', [
                                    'title' => $button_label,
                                    'buttonTitle' => $button_label,
                                    'buttonClass' => 'button downloads-button button-red x-text-base x-w-full',
                                    'content' => '<script>hbspt.forms.create({ portalId: "3856579", formId: "' . $hubspot_formular_id . '" });</script>'
                                ]) ?>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php if (!empty($autoren_headline)) : ?>
    <div class="x-mt-16">
        <h2><?php echo $autoren_headline ?></h2>
    </div>
<?php endif ?>

<?php if (is_array($autoren_slider) && count($autoren_slider)) : ?>
    <div class="x-bg-gray-200 x-flex x-flex-wrap x-justify-between x-pl-6 x-pr-6 x-pt-6 x-pb-6 downloads-people-container">
        <?php
        $key=0;
        foreach ($autoren_slider as $person) : ?>
            <?php
                $key++;
                $personID = $person['person']->ID;
                $profilbild_img = get_field('profilbild', $personID);
                $profilbild = $profilbild_img['sizes']['140-72'];
                $person_title = get_the_title($personID);
            ?>
            <div class="x-text-center x-pl-10 x-pr-10 x-flex-25 person-section slick-slide">
                <div class="x-rounded-full x-overflow-hidden x-border-6 x-border-white x-border-solid x-ml-4 x-mr-4">
                    <img
                            class="x-m-0 x-w-full"
                            alt="<?php echo $person_title; ?>"
                            title="<?php echo $person_title; ?>"
                            src="<?php echo $profilbild; ?>"
                    />
                </div>
                <div class="x-pt-4">
                    <a href="<?php echo get_the_permalink($personID); ?>">
                        <?php echo $person_title; ?>
                    </a>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php endif ?>