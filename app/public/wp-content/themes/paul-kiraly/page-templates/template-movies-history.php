<?php /* Template Name: Display Movies History */ ?> 
<?php  

get_header(); 

if( isset( $_COOKIE['accessedMovies'] ) && !empty( $_COOKIE['accessedMovies'] ))$visited = true;
else $visited = false;

?>

<div class="page <?php if( !$visited )echo "expanded-div empty-page font-weight-light alert alert-warning"; ?>" id="page-<?php the_ID(); ?>">
    <?php
        if( $visited ){

            $IDs = json_decode( wp_unslash($_COOKIE['accessedMovies']) );

            remove_all_actions('pre_get_posts'); // makes post__in and orderby work in $loop and keep the visited movies order

            $loop = new WP_Query( array( 
                'post_type' => 'dn_movies',
                'nopaging'  => true,
                'post__in'  => $IDs,
                'orderby'   => 'post__in',
            ));

            $loop->posts = array_reverse($loop->posts); // last movie visited displays first
    ?>
           
            <h1 class="tax_title font-weight-normal" style="display:flex;"> <?php the_title(); ?> </h1>                    
            <ul class="list-group list-group-flush">
            <?php 
                    while ( $loop->have_posts() ) {           
                        $loop->the_post();   ?>            
                        <li class="list-group-item">   
            <?php           require(__DIR__ . '/../template-parts/loop-movies.php'); ?>
                        </li>      
            <?php   } ?>       
            </ul>
            <div id="trash_button_container" class="mb-3 mb-md-4 mr-3 mr-md-5">
                <button id="trash"><i class="far fa-trash-alt"></i> <div class="d-none d-md-inline-block">Clear history</div></button>
            </div>
<?php   }else{ ?> 
            <div>
                You haven't visited any of our movies yet! Go to the
                <a href="<?php echo get_home_url(); ?>" class="homepage_links">home page</a>
                and check some of them out, you won't regret it!
            </div>
<?php   } ?>    
</div> 



<?php get_footer(); ?>