<?php get_header(); ?>
<div class="container pt-5 pb-5">
    <section class="contentSection">
        <h1><?php single_cat_title(); ?></h1>
        <?php     
            if(have_posts()) : 
                while(have_posts()) : 
                    the_post(); 
        ?>
                    <h3><?php the_title(); ?></h3>
        <?php
                    the_excerpt();
                endwhile; 
            endif;
        ?>
    </section>
</div>
<?php get_footer(); ?>