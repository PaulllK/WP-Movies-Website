jQuery(document).ready(function($){

    function hideLoading(){ 
        $('#loader').removeClass('d-flex');
        $('#loader').addClass('d-none');                
    }

    function doOnSuccess(result){
        if( !result ){
            $('#page-1231').addClass('font-weight-light empty-page alert alert-warning');
            $('#page-1231').text("It looks like you haven't hearted any of our movies!");
        }else{
            $('#page-1231').removeClass('expanded-div');
            $('#page-1231').html(result);
        }
    }

    function doOnFail(){
        $('#page-1231').html('<h3 class="alert alert-danger">An error occured, please reload the page.</h3>');
    }

    $.post(website.adminAjaxUrl , {
        action : 'display_fav_movies',
        favourite_movies_list : JSON.parse( localStorage['favourite_movies'] )
    })
    .done(doOnSuccess)
    .fail(doOnFail)
    .always(hideLoading);

});