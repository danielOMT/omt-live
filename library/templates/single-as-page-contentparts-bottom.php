<?php if (1 == $kommentarfunktion_aktivieren) { ?>
    <section class="omt-row color-area-weiss">
        <?php
        comments_template();
        ?>
    </section>
<?php } ?>
    <?php if ($has_sidebar != false) { ?>
    </main>
    <?php get_sidebar($sidebar_welche);?>
    </div> <?php //end of omt-main ?>
<?php } ?>
    </div> <?php //end of #content ?>