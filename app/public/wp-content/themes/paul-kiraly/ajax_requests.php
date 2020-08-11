<?php

//favourite movies request
function my_ajax_scripts(){

    if( is_page(1231) ){ //script is only loaded on favourite movies page
        wp_enqueue_script('favMoviesPageAjaxScript' , get_stylesheet_directory_uri().'/custom_js/ajax-fav_movies.js' , '' , filemtime( get_stylesheet_directory().'/custom_js/ajax-fav_movies.js' ) , true);
        wp_localize_script('favMoviesPageAjaxScript' , 'website' , array('adminAjaxUrl' => admin_url('admin-ajax.php') ) );
    }

    if( is_singular('dn_movies') ){ //script loads only on single-post movies pages
        global $wp_query;
        $postID = $wp_query->post->ID;
        wp_enqueue_script('form-validation' , get_stylesheet_directory_uri().'/custom_js/form-validation.js' , '' , filemtime( get_stylesheet_directory().'/custom_js/form-validation.js' ) , true);
        wp_localize_script('form-validation' , 'website' , array(
            'adminAjaxUrl' => admin_url('admin-ajax.php'),
            'movieID'      => $postID // will be sent by this script, to the server, using AJAX, to process a request 
        ));
    }

}
add_action('wp_enqueue_scripts' , 'my_ajax_scripts');

function display_fav_movies(){ 

    if( !empty($_POST['favourite_movies_list']) ){

        $loop = new WP_Query( array( 
            'post_type' => 'dn_movies',
            'nopaging' => true,
            'post__in' => $_POST['favourite_movies_list'] //will get movies whose IDs are in $_POST array       
        )); 
        
        $fav_movies_page = 1;
?>
        <h1 id="fav_mov_title" class="tax_title font-weight-normal"><?php echo get_the_title(1231); ?></h1>            
        <ul id="fav_movies_list" class="list-group list-group-flush">  
<?php
            if( $loop->have_posts() ){
                while ( $loop->have_posts() ) {           
                    $loop->the_post();   ?>            
                    <li class="list-group-item">   
<?php                   require('template-parts/loop-movies.php'); ?>
                    </li>      
<?php           } 
            }
?>
        </ul>
<?php

    }else{
        echo false;
    }

    wp_die();

}

add_action( 'wp_ajax_display_fav_movies', 'display_fav_movies' );
add_action( 'wp_ajax_nopriv_display_fav_movies', 'display_fav_movies' );

function validate_movie_form(){

    $data = $_POST['data'];
    define('EMAIL_REGEXP' , "/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/");
    
    if( preg_match("/^[a-zA-Z]+$/" , $data['name']) && preg_match(EMAIL_REGEXP , $data['email']) ){
        if( strlen($data['message']) >= 20  &&  strlen($data['message']) <= 1000 )$is_valid = true;
        else $is_valid = false;
    }
    else $is_valid = false;

    if( $is_valid ){
        echo true;

        // creates new comment post
        $new_comment_id = wp_insert_post([
            'post_type'    => 'dn_comments',
        ]);

        // set comment title to 'commentID'
        wp_insert_post([
            'ID' => $new_comment_id,
            'post_type'    => 'dn_comments',
            'post_title' => 'comment' . $new_comment_id,
            'post_content' => $data['message'],
            'post_status'  => 'publish',
            'meta_input'   => [
                'name'  => ucfirst( strtolower($data['name']) ),
                'email' => $data['email']
            ]
        ]);

        // creates relation between comment and the movie
        MB_Relationships_API::add( $data['movieID'] , $new_comment_id , 'movies_to_comments' );

        // sends mails to the user's and to the admin's addresses
        mail("paul.kiraly@digitalexplorer.ro" , 'New comment on the ' . get_the_title($data['movieID']) . ' movie' , $data['message'] , 'From: kiralypaul6@gmail.com' );

    }else{
        echo false;
    }

    wp_die();

}

add_action( 'wp_ajax_validate_movie_form', 'validate_movie_form' );
add_action( 'wp_ajax_nopriv_validate_movie_form', 'validate_movie_form' );