<?php get_header(); ?>
<?php
wp_enqueue_script('snowfall', get_template_directory_uri() . '/library/js/snowfall.jquery.js');
$post_id = get_the_ID();
$wistia_embed_code= get_field('wistia_embed_code');
$formular_id = get_field('formular_id');
?>
<div id="content" xmlns:background="http://www.w3.org/1999/xhtml" >
    <div id="inner-content" class="wrap clearfix magazin-single-wrap  no-hero">
        <div id="main" class="blog-single magazin-single clearfix" role="main">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" class="omt-row template-themenwelt" role="article">
                <?php if (!empty($h1)) : ?>
                    <header class="article-header">
                        <h1 class="entry-title single-title has-margin-bottom-30" itemprop="headline"><?php print $h1;?></h1>
                    </header>
                <?php endif ?>
                <section class="entry-content clearfix inhaltseditor" itemprop="articleBody">                    
                    <div class="video_wrap">
                        <?php if (strlen($wistia_embed_code)>0) {?>
                            <div class="webinar-video">
                                <?php if (strlen($wistia_embed_code) > 0) { ?>
                                    <div class="video-wrap player-wrap"
                                         data-members="<?php print $wistia_embed_code_mitglieder; ?>">
                                        <script src="//fast.wistia.com/embed/medias/<?php print $wistia_embed_code; ?>.jsonp"
                                                async></script>
                                        <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                                        <div class="wistia_responsive_padding">
                                            <div class="wistia_responsive_wrapper">
                                                <div class="wistia_embed wistia_async_<?php print $wistia_embed_code; ?>">
                                                    &nbsp;
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }

                                if (strlen($wistia_embed_code)<3) { ?>
                                    <div class="webinar-not-available">
                                        <h3>Dieses Video ist nur für eingeloggte Mitglieder verfügbar</h3>
                                    </div>
                                <?php }?>
                            </div>
                        <?php }?>

                        <div class="header-extras x-mt-4">
                            <span></span>
                            <div class="socials-header">
                                <?php echo do_shortcode('[shariff headline="Jetzt Teilen" borderradius="1" buttonsize="small" services="facebook|twitter|googleplus|linkedin|xing" theme="round" orientation="horizontal" align="flex-end"]');?>
                            </div>
                        </div>
                    </div>

                    <?php the_content(); ?>
                    
                    <?php if (strlen($formular_id)>0) {?>
                        <div id="form-<?php print $formular_id; ?>" class="contact-form">
                            <?php echo do_shortcode('[gravityform ajax=true id="' . $formular_id . '" title="false" description="true" tabindex="0"]'); ?>
                        </div>                    
                     <?php }?>
                </section>
            </article>
            <?php endwhile;?>
            <?php endif; ?>
        </div>
    </div>
</div>
<script type='text/javascript'> 
    $(document).ready(function() {		
        $(document).snowfall({deviceorientation : true, round : true, minSize: 1, maxSize:8,  flakeCount : 250});
    });
</script>
<?php get_footer(); ?>