jQuery(document).ready(function($){

    let hearts = document.querySelectorAll(".fa-heart");

    if( typeof hearts != 'undefined' && hearts.length > 0 ){
        
        let favMoviesList;  //will be an array with all favourite movies IDs  

        //initialize or get local storage json
        if( localStorage.hasOwnProperty('favourite_movies') ){
            favMoviesList = JSON.parse( localStorage['favourite_movies'] );
        }else{
            localStorage.setItem('favourite_movies', '[]');
            favMoviesList = [];
        } 

        function favTooltip(favrt , heart){
            if(favrt) $(heart).attr('data-original-title', 'Favourite movie');
            else $(heart).attr('data-original-title', 'Add this movie to favourites!');
        }

        //initialize tooltips (check bootstrap documentation: https://getbootstrap.com/docs/4.0/components/tooltips/#example-enable-tooltips-everywhere)
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        for(i = 0 ; i < hearts.length ; i++){

            let heartButton = hearts[i] , movieID = heartButton.id , classes = heartButton.classList;

            //gets current state (favourite or not) for movie; if it's a favourite changes default display for heart button
            if( favMoviesList.includes(movieID) ){
                classes.remove('far');
                classes.add('fas');
                favTooltip(true , heartButton); 
            }else{
                favTooltip(false , heartButton);
            }

            heartButton.addEventListener('click' , function(){

                classes.toggle('far');
                classes.toggle('fas');

                if( favMoviesList.includes(movieID) ){
                    favMoviesList = favMoviesList.filter(function(movie){ //remove movie ID from array of favourite IDs
                        return movie !== movieID; //keep a movie ID if it's different from current movie ID
                    });
                    favTooltip(false , heartButton);
                }
                else{
                    favMoviesList.push(movieID);
                    favTooltip(true , heartButton);
                }

                //transforms array of movie IDs into JSON text, which will be saved to local storage
                localStorage['favourite_movies'] = JSON.stringify(favMoviesList);

            });

        }

    }
});