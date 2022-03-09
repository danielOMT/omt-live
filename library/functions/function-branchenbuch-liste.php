<?php
function branchenbuch_liste(string $typ = "stadt") { ?>
<ul class="branchenbuch-liste plus">
                                <?php
                                $args = array(
                                    'posts_per_page'    => -1,
                                    'post_type'         => 'branchenbuch',
                                    'meta_key'          => 'zuordnung_stadt_oder_branche',
                                    'meta_value'        => $typ,
                                    'orderby'	        => 'title',
                                    'order'             => 'ASC'
                                );
                                $loop = new WP_Query( $args ); //*args and query all "
                                while ( $loop->have_posts() ) : $loop->the_post(); ?>
                                    <?php
                                    $branchenbuch_name = get_the_title();
                                    $zuordnung_stadt_oder_branche = get_field('zuordnung_stadt_oder_branche');
                                    ?>
                                    <li class="branchenbuch"><a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a></li>
                                    <?php
                                endwhile; //*****now we have array full with all
                                wp_reset_postdata();
                                ?>
</ul>

<?php } ?>