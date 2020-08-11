<?php
    $movie_title = get_the_title();
    $movie_ID = get_the_ID();
?>
<div id="<?php echo $movie_ID; ?>" class="row mx-md-4"> 
    <div class="film-thumbnail col-lg-4 col-md-5">
        <?php
        if ( has_post_thumbnail() ) {
            the_post_thumbnail();
        }else { ?>
            <img src="<?php bloginfo('template_directory'); ?>/images/movie-placeholder-image.png" alt="<?php echo $movie_title; ?>" />
        <?php } ?>
    </div>

    <div class="col-lg-8 col-md-7 pt-5 pb-3">

        <ul class="list-group list-group-flush">

            <li class="list-group-item">
                <div class="row">
                    <div class="col-10">
                        <h2 class="text-danger font-weight-light"><?php echo $movie_title; ?></h2>
                    </div>
                    <div class="col-2 favourite-movie">
                        <i id="<?php echo $movie_ID; ?>" class="far fa-heart fav" data-toggle="tooltip" data-placement="top" title=""></i>
                    </div>
                </div>
                <?php 
                    the_content();
                ?>  
            </li>

            <li class="list-group-item">
                <?php
                    $runtime_in_mins = get_post_meta( get_the_ID(), 'Runtime', true);               
                ?>
                <h4 class="movie-details font-italic">
                    Runtime: <span class="highlighted-number"><?php echo mins_in_h_and_min($runtime_in_mins);?></span>
                </h4>               
            </li>

            <li class="list-group-item">
                <?php $terms = get_the_terms( $movie_ID , 'dn_movies-years' ); ?>
                <h4 class="movie-details font-italic">Released in <span class="highlighted-number"><?php echo $terms[0]->name; ?></span></h4>
            </li> 

            <li class="list-group-item">
                <h4 class="movie-details font-italic">Actors: </h4>
                <?php
                    $actors_in_the_movie = new WP_Query( [
                        'relationship' => [
                            'id' => 'movies_to_actors',
                            'from' => $movie_ID, // You can pass object ID or full object
                        ],
                        'nopaging'     => true,
                    ] );

                $nr_actors = count($actors_in_the_movie->posts); 

                for ( $i = 0 ; $i < $nr_actors - 1 ; $i ++ ){
                    echo "{$actors_in_the_movie->posts[$i]->post_title}, ";
                }

                echo $actors_in_the_movie->posts[$i]->post_title;                   
                ?>               
            </li>

            <li class="list-group-item">
                <h4 class="movie-details font-italic">Directed by: </h4>
                <?php
                    $directors_in_the_movie = new WP_Query( [
                        'relationship' => [
                            'id' => 'movies_to_directors',
                            'from' => $movie_ID, // You can pass object ID or full object
                        ],
                        'nopaging'     => true,
                    ] );

                $nr_directors = count($directors_in_the_movie->posts); 

                for ( $i = 0 ; $i < $nr_directors - 1 ; $i ++ ){
                    echo "{$directors_in_the_movie->posts[$i]->post_title}, ";
                }

                echo $directors_in_the_movie->posts[$i]->post_title;                   
                ?>
                
            </li>

            <li class="list-group-item">
                <h4 class="movie-details font-italic">Genres: </h4>
                <?php
                    $terms = get_the_terms( $movie_ID , 'dn_genres' );

                    $l = count($terms);
                    for($i = 0 ; $i < $l - 1 ; $i++){
                        echo "{$terms[$i]->name}, ";
                    }
                    echo $terms[$i]->name; //last genre should not have comma after it
                ?>

            </li>

        </ul>

    </div>

    

</div>