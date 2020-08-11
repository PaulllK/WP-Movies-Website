<div class="row mx-md-4"> 

    <div class="film-thumbnail col-lg-4 col-md-6">
        <?php
        $movie_title = get_the_title();
        $movie_ID = get_the_ID();

        if ( has_post_thumbnail() ) {
            the_post_thumbnail();
        }else { ?>
            <img src="<?php bloginfo('template_directory'); ?>/images/movie-placeholder-image.png" alt="<?php echo $movie_title; ?>" />
        <?php } ?>
    </div>
                                              
    <div class="col-lg-8 col-md-6 pt-5 pb-3">

        <ul class="list-group list-group-flush">

            <li class="list-group-item">
            <?php if( isset($fav_movies_page) ){ ?>
                <h2 class="text-danger font-weight-light"><?php echo $movie_title; ?></h2>
            <?php }else{ ?> 
                <div class="row">
                    <div class="col-10">
                        <h2 class="text-danger font-weight-light"><?php echo $movie_title; ?></h2>
                    </div>
                    <div class="col-2 favourite-movie">
                        <i id="<?php echo $movie_ID; ?>" class="far fa-heart fav" data-toggle="tooltip" data-placement="top" title=""></i>
                    </div>
                </div>
            <?php } 

                the_content();           
            ?>
            </li>

            <li class="list-group-item">
                <?php
                    $runtime_in_mins = get_post_meta( $movie_ID, 'Runtime', true);               
                ?>
                <h4 class="movie-details font-italic">
                    Runtime: <span class="highlighted-number"><?php echo mins_in_h_and_min($runtime_in_mins);?></span>
                </h4>
            </li>

            
        </ul>
        <div class="button-container">
            <a href="<?php the_permalink(); ?>">
                <button class="details-button"><i class="fas fa-film"></i> More details here</button>
            </a>
        </div>
    </div>

</div>