<?php get_header(); ?>

    <?php if( have_posts() ){
        $director_id = get_the_ID();
        the_post(); ?>
        <div class="page" id="page-<?php echo $director_id; ?>">
            <h2 class="highlighted-number"><?php the_title(); ?></h2>
            <?php the_content(); ?>                  
        </div>
    <!-- movies which were directed by him/her -->
    <?php } 
    
        $directed_movies = new WP_Query( [
            'relationship' => [
                'id' => 'movies_to_directors',
                'to' => $director_id, // You can pass object ID or full object
            ],
            'nopaging'     => true,
        ] );
    
        while ( $directed_movies->have_posts() ) {           
            $directed_movies->the_post();           
            require('template-parts/loop-movies.php');        
        } 
                
        wp_pagenavi();


    ?>

<?php get_footer(); ?>