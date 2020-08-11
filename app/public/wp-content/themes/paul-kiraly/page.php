<?php get_header(); ?>
        
    <?php while(have_posts()){

        the_post(); ?>
        <div class="page" id="page-<?php the_ID(); ?>">
            <div class="row"> 
                                        
                <div class="col-lg-8 col-md-6">
                    <h2 class="text-danger font-weight-light"><?php the_title(); ?></h2>
                    <?php the_content(); ?>
                </div>
                
                <div class="col_cu_poza col-lg-4 col-md-6 order-md-first">
                    <?php
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail();
                    }
                    ?>
                </div>

            </div>                    
        </div>

    <?php } ?>
        

<?php get_footer(); ?>