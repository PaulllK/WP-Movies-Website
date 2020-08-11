<?php get_header(); ?>

        <?php if( have_posts() ){
            $actor_id = get_the_ID();
            the_post(); ?>
            <div class="page" id="page-<?php echo $actor_id; ?>">
                <h2 class="highlighted-number"><?php the_title(); ?></h2>
                <?php the_content(); ?>                  
            </div>
        <!-- movies the actor/actress played in -->
        <?php } 
        
            $played_in_movies = new WP_Query( [
                'relationship' => [
                    'id' => 'movies_to_actors',
                    'to' => $actor_id, // You can pass object ID or full object
                ],
                'nopaging'     => true,
            ] );
        
            while ( $played_in_movies->have_posts() ) {           
                $played_in_movies->the_post();           
                require('template-parts/loop-movies.php');        
            } 
                    
            wp_pagenavi();


        ?>

<?php get_footer(); ?>