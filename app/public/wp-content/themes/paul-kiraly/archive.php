<?php get_header(); ?>
    <div class="page" id="page-<?php the_ID(); ?>">
        <?php the_archive_title( '<h1 class="tax_title font-weight-normal">', '</h1>' ); ?>
        <div class="navigation container-fluid text-center my-2">
            <?php wp_pagenavi(); ?>
        </div>    
        <?php
        if( is_post_type_archive( ['dn_actors' , 'dn_directors'] ) ){
            $loop = new WP_Query( array( 
                'post_type' => ( is_post_type_archive('dn_actors') ) ? 'dn_actors' : 'dn_directors' ,
                'posts_per_page' => 19,
                'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1
            ));
        ?>
            <div class="list-group my-5">
                <?php
                    $danger = 0;
                    while ( $loop->have_posts() ) {           
                        $loop->the_post();
                ?>
                        <a 
                            href="<?php the_permalink(); ?>"
                            class="list-group-item text-center list-group-item-action list-group-item-<?php if($danger % 2 === 0){echo 'danger';}else echo 'light'; ?>"              
                        >
                            <h3 class="m-0"><?php the_title(); ?></h3>                        
                        </a>      
                <?php 
                        $danger++;  
                    }   
                ?>
            </div>
        <?php
        }else{  

            if( is_tax() ){
                $tax = get_queried_object();

                $loop = new WP_Query( array( 
                    'post_type' => 'dn_movies',
                    'tax_query' => array(
                        array(
                            'taxonomy' => $tax->taxonomy,
                            'field' => 'slug',
                            'terms' => $tax->slug,
                        ),
                    ),
                    'posts_per_page' => 10,
                    'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1
                ));
            }else{
                $loop = new WP_Query( array( 
                    'post_type' => 'dn_movies',
                    'posts_per_page' => 10,
                    'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1
                ));
            }
        ?>           
            <ul class="list-group list-group-flush">
                <?php
                    
                    while ( $loop->have_posts() ) {           
                        $loop->the_post();
                ?>
                        <li class="list-group-item">
                <?php
                        require('template-parts/loop-movies.php');                           
                ?>
                        </li>      
                <?php   
                    }   
                ?>
            </ul>

        <?php } ?> 
    </div>

    
<?php get_footer(); ?>