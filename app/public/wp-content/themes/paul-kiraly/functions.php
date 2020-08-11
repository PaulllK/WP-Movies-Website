<?php

function enqueue_my_scripts(){
    //bootstrap styles and scripts
    wp_enqueue_style('bootstrap_style' , get_stylesheet_directory_uri().'/inc/bootstrap/css/bootstrap.min.css' , '' , filemtime( get_stylesheet_directory().'/inc/bootstrap/css/bootstrap.min.css' ) );

    //jquery required for bootstrap JS scripts to work (check console error)
    wp_enqueue_script('bootstrap_jQuery' , get_stylesheet_directory_uri().'/inc/jquery/jquery-3.4.1.min.js' , '' , filemtime( get_stylesheet_directory().'/inc/jquery/jquery-3.4.1.min.js' ) , true);

    wp_enqueue_script('bootstrap_JSscript' , get_stylesheet_directory_uri().'/inc/bootstrap/js/bootstrap.bundle.min.js' , '' , filemtime( get_stylesheet_directory().'/inc/bootstrap/js/bootstrap.bundle.min.js' ) , true);

    //font-awesome JS script
    wp_enqueue_script('font-awesome-script' , "https://kit.fontawesome.com/09fb39ead0.js" , '' , null , true);

    //custom styles and scripts
    wp_enqueue_style('custom_style' , get_stylesheet_directory_uri().'/style.css' , '' , filemtime( get_stylesheet_directory().'/style.css' ) );

    if( !is_page(1231) ){ // prevent this script from loading if user is on favourite movies page 
      wp_enqueue_script('favMoviesHeartScript' , get_stylesheet_directory_uri().'/custom_js/favourite-movies.js' , '' , filemtime( get_stylesheet_directory().'/custom_js/favourite-movies.js' ) , true);
    }

    if( is_singular('dn_movies') ){ //script loads only on single-post movies pages
      wp_enqueue_script('moviesHistory' , get_stylesheet_directory_uri().'/custom_js/movies_history.js' , '' , filemtime( get_stylesheet_directory().'/custom_js/movies_history.js' ) , true);
      wp_enqueue_script('form-validation' , get_stylesheet_directory_uri().'/custom_js/form-validation.js' , '' , filemtime( get_stylesheet_directory().'/custom_js/form-validation.js' ) , true);
    }

    if( is_page(1241) ){ // load this script only on movies history page 
      wp_enqueue_script('deleteHistory' , get_stylesheet_directory_uri().'/custom_js/delete-history.js' , '' , filemtime( get_stylesheet_directory().'/custom_js/delete-history.js' ) , true);
    }
} 

add_action('wp_enqueue_scripts' ,'enqueue_my_scripts');

/**
 * Register Custom Navigation Walker
 */
if ( ! file_exists( get_template_directory() . '/class-wp-bootstrap-navwalker.php' ) ) {
    // File does not exist... return an error.
    return new WP_Error( 'class-wp-bootstrap-navwalker-missing', __( 'It appears the class-wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker' ) );
} else {
    // File exists... require it.
    require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}

//enables post thumbnails..I think:)
add_theme_support('post-thumbnails');

register_nav_menus( 
	array(
		'main-menu' => 'Primary Menu' 
	)
);

function register_widget_areas() {

    register_sidebar( array(
      'name'          => 'Footer area',
      'id'            => 'footer_area',
      'description'   => 'Footer widget',
      'before_widget' => '<div class="col-md-4 mb-4 mt-5">',
      'after_widget'  => '</div>',
      'before_title'  => '<h4>',
      'after_title'   => '</h4>',
    ));
    
  }
  
add_action( 'widgets_init', 'register_widget_areas' );

function themename_custom_logo_setup() {
  $defaults = array(
  //'height'      => 100,
  //'width'       => 400,
  'flex-height' => true,
  'flex-width'  => true,
  //'header-text' => array( 'site-title', 'site-description' ),
  );
  add_theme_support( 'custom-logo', $defaults );
 }
 add_action( 'after_setup_theme', 'themename_custom_logo_setup' );

function my_custom_post_type($dn_post_type , $post_type_supports = ['title', 'editor', 'thumbnail', 'excerpt', 'author' , 'revisions' , 'custom-fields' ] ){

  $uc_post = ucfirst($dn_post_type); //Movie
  $pl_post = $dn_post_type . 's'; //movies
  $pl_uc_post = $uc_post . 's'; //Movies

  $labels = array(
    'name'               => _x( $pl_uc_post , 'post type general name' ),
    'singular_name'      => _x( $uc_post , 'post type singular name' ),
    'add_new'            => _x( 'Add New', $dn_post_type ),
    'add_new_item'       => __( "Add New $uc_post" ),
    'edit_item'          => __( "Edit $uc_post" ),
    'new_item'           => __( "New $uc_post" ),
    'all_items'          => __( "All $pl_uc_post" ),
    'view_item'          => __( "View $uc_post" ),
    'search_items'       => __( "Search $pl_uc_post"  ),
    'not_found'          => __( "No $pl_post found" ),
    'not_found_in_trash' => __( "No $pl_post found in the Trash" ), 
    //'parent_item_colon'  => ’,
    'menu_name'          => $pl_uc_post
  );

  $args = array(
    'labels'        => $labels,
    'description'   => "Holds our $pl_post and $dn_post_type specific data",
    'public'        => true,
    'menu_position' => 5,
    'supports'      => $post_type_supports,
    'has_archive'   => true,
    'rewrite'       => array('slug' => $pl_post)
  );
  register_post_type( "dn_$pl_post", $args );

}

//call the function my_custom_post_type() with a string as its parameter inside this function to add a new post type
function add_custom_post_types(){
  my_custom_post_type('movie');
  my_custom_post_type('actor');
  my_custom_post_type('director');
  my_custom_post_type('comment' , [ 'title' , 'editor' , 'author' , 'revisions' , 'custom-fields' ]);
}

add_action( 'init', 'add_custom_post_types' );

function my_custom_taxonomy($tax /*ex. genre */ , $post_types , $slug){

  $uc_tax = ucfirst($tax); //Genre, Movies Year
  $pl_tax = $tax . 's'; //genres, movies
  $pl_uc_tax = $uc_tax . 's'; //Genres, Movies Years

  $labels = array(
    'name'              => _x( $pl_uc_tax , 'taxonomy general name'),
    'singular_name'     => _x( $uc_tax , 'taxonomy singular name'),
    'search_items'      => __("Search $pl_uc_tax"),
    'all_items'         => __("All $pl_uc_tax"),
    'parent_item'       => __("Parent $uc_tax"),
    'parent_item_colon' => __("Parent $uc_tax:"),
    'edit_item'         => __("Edit $uc_tax"),
    'update_item'       => __("Update $uc_tax"),
    'add_new_item'      => __("Add new $uc_tax"),
    'new_item_name'     => __("New $uc_tax name"),
    'not_found'          => __( "No $pl_tax found" ),
    'not_found_in_trash' => __( "No $pl_tax found in the Trash" ), 
    'menu_name'         => __($pl_uc_tax),
  );

  $args = array(
    'hierarchical'      => true, // make it hierarchical (like categories)
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => ['slug' => $slug],
    'has_archive'       => true
  );

  register_taxonomy( "dn_$slug", $post_types , $args);

}

//call the function my_custom_taxonomy() inside this function to add a new taxonomy
function add_custom_taxonomies(){
  my_custom_taxonomy('genre' , ['dn_movies' , 'dn_actors' , 'dn_directors'] , 'genres' );
  my_custom_taxonomy('movies Year' , ['dn_movies'] , 'movies-years');
}

add_action('init', 'add_custom_taxonomies');

//Meta Box and MB Relationships plugins code to create the relationships movies->actors, movies->directors and viceversa
add_action( 'mb_relationships_init', function() {
  MB_Relationships_API::register( [
      'id'   => 'movies_to_actors',
      'from' => [
          'post_type' => 'dn_movies',
          'meta_box'    => [
              'title' => 'Actors',
          ],
      ],
      'to'   => [
          'post_type'   => 'dn_actors',
          'meta_box'    => [
              'title' => 'Movies',
          ],
      ],
  ] );

  MB_Relationships_API::register( [
      'id'   => 'movies_to_directors',
      'from' => [
          'post_type' => 'dn_movies',
          'meta_box'    => [
              'title' => 'Directors',
          ],
      ],
      'to'   => [
          'post_type'   => 'dn_directors',
          'meta_box'    => [
              'title' => 'Movies',
          ],
      ],
  ] );

  MB_Relationships_API::register( [
    'id'   => 'movies_to_comments',
    'from' => [
      'post_type' => 'dn_movies',
      'meta_box'    => [
          'title' => 'Comments',
      ]
    ],
    'to'   => [
      'post_type'   => 'dn_comments',
      'meta_box'    => [
          'title' => 'Movies',
      ]
    ],
  ] );

} );

//custom fct to change movies runtime format
function mins_in_h_and_min($runtime){
  $ore = floor($runtime / 60);
  $minute = $runtime % 60;

  if( $ore ){
    $runtime = "$ore ";
    if( $ore == 1 )$runtime .= 'hour';
    else $runtime .= 'hours';
  }

  if( $minute ){
    if( $ore )$runtime .= " and $minute ";
    else $runtime = "$minute ";

    if( $minute == 1 )$runtime .= 'minute';
    else $runtime .= 'minutes';
  }

  return $runtime;
}

//used for wp_pagenavi() function which doesn't work with multiple posts-per-page limitations
function custom_type_archive_display($query) {
  if ( is_post_type_archive( ['dn_actors' , 'dn_directors'] ) ) {
    $query->set('posts_per_page',19);
    $query->set('orderby', 'date' );
    $query->set('order', 'DESC' );
    return;
  }
  else{
    $query->set('posts_per_page',10);
    $query->set('orderby', 'date' );
    $query->set('order', 'DESC' );
    return;
  }     
}
add_action('pre_get_posts', 'custom_type_archive_display');

require_once( wp_normalize_path( get_template_directory() . '/ajax_requests.php' ) );

//adds custom classes to anchor elements in nav menu
/*
function add_link_atts($atts) {
    $atts['class'] = "nav-link";
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_link_atts');

//adds custom classes to li elements (list items) in nav menu; this can also be performed from WP menu editting section
add_filter( 'nav_menu_css_class', function($classes) {
    $classes[] = 'nav-item';
    return $classes;
}, 10, 1 );
*/