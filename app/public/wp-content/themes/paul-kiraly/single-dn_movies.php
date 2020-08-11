<?php get_header(); ?>
    <div class="page" id="page-<?php the_ID(); ?>">
        <?php while( have_posts() ){
            the_post(); 
            require_once('template-parts/one-movie.php'); ?>                   
        <?php } ?>
        <hr class="mb-4">
        <div id="box" class="row justify-content-center"> 
            <div id="movie_form_container" class="col-md-10 mb-5">
                <form>
                    <h4 class="py-4" style="color:#bf004b;">What did you like about the movie?</h4>
                    <div class="row">

                        <div class="col-md-6 form-group">
                            <label for="name_input">Name</label>
                            <input type="text" class="form-control" id="name_input" placeholder="Paul">
                            <div class="invalid-feedback" style="width: 100%;">
                                Please use between 2-30 letters!
                            </div>
                        </div>
                        
                        <div class="col-md-6 form-group">
                            <label for="email_input">Email address</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@</span>
                                </div>
                                <input type="text" class="form-control" id="email_input" placeholder="name@example.com">
                                <div class="invalid-feedback" style="width: 100%;">
                                    Please enter a valid email address!
                                </div>        
                            </div>                           
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="message_input">Comment</label>
                        <textarea class="form-control" id="message_input" rows="3" placeholder="Write..."></textarea>
                        <div class="invalid-feedback" style="width: 100%;">
                            Please use between 20-1000 characters!
                        </div>
                    </div>

                    <div id="submit_container" class="d-flex justify-content-center my-4">
                        <button id="submit_button" class="btn details-button" type="submit">Send</button>
                    </div>
                </form>
            </div>  
        </div>
<?php 
        $comments = new WP_Query([
            'relationship' => [
                'id' => 'movies_to_comments',
                'from' => $movie_ID, // You can pass object ID or full object
            ],
            'nopaging'     => true,
        ]);

        define("COMMENTS_NUMBER" , count($comments->posts));

        if( COMMENTS_NUMBER == 0 ){
?>
            <h4 class="py-4" style="color:#bf004b;">No comments yet</h4>
<?php
        }else{
?>
            <h4 class="py-4" style="color:#bf004b;">Comments(<?php echo COMMENTS_NUMBER; ?>)</h4>
            <div class="mx-2 mx-md-3">
<?php           
                while ( $comments->have_posts() ) {           
                    $comments->the_post();
                    $user_information = get_post_meta( get_the_ID() );
?>
                    <div class="comment mb-5 p-3">
                        <div class="mb-4">
                            <h4 class="mb-0" style="color:#a53860;"><?php echo $user_information['name'][0]; ?></h4>
                            <span style="color:#777;font-size:0.8rem;"><?php echo $user_information['email'][0]; ?></span>
                        </div>
                        <div class="pr-2">
<?php
                            the_content();                           
?>
                        </div>
                    </div>      
<?php   
                }   
?>
        </div>
<?php   } ?>
    </div>
<?php get_footer(); ?>