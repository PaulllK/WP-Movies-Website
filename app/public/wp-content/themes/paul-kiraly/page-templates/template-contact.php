<?php /* Template Name: Display Contact */ ?>
<?php get_header(); ?>

    <?php while(have_posts()){

        the_post(); ?>
        <div class="page" id="page-<?php the_ID(); ?>">
            <h2 class="text-danger font-weight-light"><?php the_title(); ?></h2>
            <?php the_content(); ?>                             
        </div>

    <?php } ?>

<?php get_footer(); ?>