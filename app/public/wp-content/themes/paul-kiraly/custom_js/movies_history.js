document.addEventListener("DOMContentLoaded", () => { 
    
    let cookies = document.cookie,
        index = cookies.indexOf("accessedMovies="),
        movieID = document.querySelector(".fa-heart").id, //getting movie ID from heart icon
        moviesHistoryList;

    function moviesHistoryExpiration(days){
        let date = new Date();
        date.setTime( date.getTime() + (days * 24 * 60 * 60 * 1000) );
        let expires = "expires="+ date.toUTCString();
        return expires;
    }   

    if(index >= 0){

        let endIndex = cookies.indexOf("]" , index + 15); //find index of movies array end

        moviesHistoryList = JSON.parse( cookies.slice(index + 15 , endIndex + 1) ); //convert string to array

        if( !moviesHistoryList.includes(movieID) ){
            moviesHistoryList.push(movieID);
            document.cookie = "accessedMovies=" + JSON.stringify(moviesHistoryList) + ";" + moviesHistoryExpiration(2) + ";path=/";
        }

    }else document.cookie = "accessedMovies=" + JSON.stringify( [movieID] ) + ";" + moviesHistoryExpiration(2) + ";path=/";

});