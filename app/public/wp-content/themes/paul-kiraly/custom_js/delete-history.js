jQuery(document).ready(function($){

    document.querySelector('#trash').addEventListener('click' , function(){
        document.cookie = "accessedMovies=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/";
        $('.page').addClass('expanded-div empty-page font-weight-light alert alert-success text-success');
        $('.page').text("History cleared");
    });

});