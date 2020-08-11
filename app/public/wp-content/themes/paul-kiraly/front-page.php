<?php get_header(); ?> 
    <div class="container mt-4 mb-5">
        <h3 class="h3 font-weight-light">

            Our website provides you with a list of
            <?php echo wp_count_posts( 'dn_movies' )->publish; ?> 
            movies divided into
            <a href="<?php echo get_permalink( get_page_by_path( 'genres' ) ); ?>" class="homepage_links">
                <?php echo wp_count_terms('dn_genres'); ?> genres
            </a>.
            You can also see the filmography of
            <a href="<?php echo get_post_type_archive_link('dn_actors'); ?>" class="homepage_links">
                <?php echo wp_count_posts( 'dn_actors' )->publish; ?> actors
            </a>
            or
            <a href="<?php echo get_post_type_archive_link('dn_directors'); ?>" class="homepage_links">
                <?php echo wp_count_posts( 'dn_directors' )->publish; ?> directors
            </a>.

        </h3>
    </div>
    <?php

        $loop = new WP_Query( array( 
            'post_type' => 'dn_movies',
            'nopaging' => true, //to get all movies
            'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1
        ));

        usort( $loop->posts , function($movie1 , $movie2){

            // get release years for every movie
            $movie1_year = get_the_terms( $movie1 , 'dn_movies-years');
            $movie2_year = get_the_terms( $movie2 , 'dn_movies-years');

            if($movie1_year[0]->name === $movie2_year[0]->name )return 0;

            return ($movie1_year[0]->name < $movie2_year[0]->name) ? -1 : 1 ; 

        });
                
    ?>

    <div class="page" id="page-<?php the_ID(); ?>">
        <div class="row">
            
            <div class="col-xl-6 col_border">
                <h2 class="tax_title text-center">10 oldest movies</h2>
                <?php
                    $i = 1;       
                    while ( $loop->have_posts() && $i <= 10) {           
                        $loop->the_post();           
                        require('template-parts/loop-movies.php');
                        $i++;        
                    } 
                ?>
            </div>

            <?php                  
                $loop->rewind_posts(); //reset index from the loop
                $loop->posts = array_reverse($loop->posts); //latest movies first              
            ?>
                
            <div class="col-xl-6 col_border">
                <h2 class="tax_title text-center">10 latest movies</h2>
                <?php       
                    while ( $loop->have_posts() && $i <= 20) {           
                        $loop->the_post();           
                        require('template-parts/loop-movies.php');
                        $i++;        
                    } 
                ?>
            </div>

        </div>
    </div>
      
<?php get_footer(); ?>