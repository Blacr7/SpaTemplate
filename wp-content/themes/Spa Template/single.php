<?php get_header(); ?>
<section class="container pt-5 pb-5">
    <h1><?php the_title();?></h1>
    <?php 
        if(have_posts()) : 
            while(have_posts()) : 
                the_post(); 
                the_content();
            endwhile; 
        endif;
    ?>
</section>
<?php get_footer(); ?>