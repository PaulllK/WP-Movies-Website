<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <title>Best Movies</title>
    
</head>
<body>
    <header class="fixed-top">
        
        <nav id="nav-menu" class="row navbar navbar-expand-md navbar-dark" role="navigation">

            <div class="pl-2 pr-0 col-1">
                <!--
                <img src="<?php echo get_stylesheet_directory_uri().'/logo.png' ?>" class="rounded mx-auto d-block" style="height:70px;" alt="DN logo">
                -->
                <?php the_custom_logo(); ?>
            </div>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbarSupportedContent" class="col-md-10 collapse navbar-collapse">
                <?php
                    wp_nav_menu( array(
                        'theme_location'  => 'main-menu',
                        'depth'           => 2, // 1 = no dropdowns, 2 = with dropdowns.
                        'container'       => false,
                        'menu_class'      => 'navbar-nav mx-auto custom_menu',
                        'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                        'walker'          => new WP_Bootstrap_Navwalker(),
                    ) );
                ?>
            </div>
            <div class="col-md-1"></div>
            
        </nav>
    </header>
    
    <div id="content" class="container pt-3 pb-3">
