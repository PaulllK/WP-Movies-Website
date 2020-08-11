<?php /* Template Name: Display Taxonomy */ ?>
<?php get_header(); ?>

    <?php if( have_posts() ){ ?>
        <div class="page" id="page-<?php the_ID(); ?>">

            <?php $tax_title = get_the_title(); ?>
            <h1 class="text-danger font-weight-light"><?php echo $tax_title; ?></h1>

            <?php
            if( $tax_title === 'Genres' ){
                $dn_terms = get_terms( array(
                    'taxonomy' => 'dn_genres',
                    'hide_empty' => false,
                ) );
            }
            else {
                $dn_terms = get_terms( array(
                    'taxonomy' => 'dn_movies-years',
                    'hide_empty' => false,
                ) );
            }
            $nr_terms = count($dn_terms);
            ?>
            <div class="list-group my-3">
                <?php
                    $dark = 0;
                    for($i = 0 ; $i < $nr_terms ; $i ++) {           
                ?>
                        <a 
                            href="<?php echo $dn_terms[$i]->slug; ?>"
                            class="list-group-item d-flex justify-content-between align-items-center list-group-item-action list-group-item-<?php if($dark % 2 === 0){echo 'dark';}else echo 'light'; ?>"              
                        >
                            <h3 class="m-0"><?php  echo $dn_terms[$i]->name; ?></h3> 
                            <span class="h4 m-0 badge-danger badge-pill"><?php echo $dn_terms[$i]->count; ?></span>                     
                        </a>      
                <?php 
                        $dark++;  
                    }   
                ?>
            </div>
        </div>
    <?php } ?>

<?php get_footer(); ?>