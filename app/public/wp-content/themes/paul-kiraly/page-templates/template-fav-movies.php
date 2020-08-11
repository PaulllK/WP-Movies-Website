<?php /* Template Name: Display favourite movies */ ?>
<?php  get_header(); ?>

    <div class="page expanded-div" id="page-<?php the_ID(); ?>">
       
        <div id="loader" class="d-flex justify-content-center"> 

            <div class="spinner-border custom_spinner" style="color: palevioletred;" role="status">
                    <span class="sr-only">Loading...</span>
            </div>

            <div style="font-size: 1.5rem; padding-left: 1rem;">
                Loading...
            </div>

        </div>
          
    </div> 
<?php get_footer(); ?>