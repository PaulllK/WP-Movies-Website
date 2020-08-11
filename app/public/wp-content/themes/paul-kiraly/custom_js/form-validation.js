jQuery(document).ready(function($){

    const form = document.querySelector('form');
    const name = document.querySelector('#name_input');
    const email = document.querySelector('#email_input');
    const message = document.querySelector('#message_input');

    let valid;

    function prettify(string){
        return string.substr(0,1).toUpperCase() + string.substr(1).toLowerCase();
    }

    function turnValid(input){
        input.classList.remove('is-invalid'); // prima data se sterge is-invalid daca exista
        input.classList.add('is-valid'); // apoi se adauga is-valid daca nu exista
    }

    function turnInvalid(input){
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
    }

    function validateFields(){

        // validare nume
        let regexp = /^[a-zA-Z]+$/;
        if( regexp.test(name.value) && name.value.length >= 2 && name.value.length <= 30 ){
            name.value = prettify(name.value);
            turnValid(name);
        }
        else turnInvalid(name);

        // validare email
        regexp = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if( regexp.test(email.value) )turnValid(email);
        else turnInvalid(email);

        // validare mesaj
        if(message.value.length >= 20  &&  message.value.length <= 1000)turnValid(message);
        else turnInvalid(message);

    }

    function changeInputsState(state){
        if(state){
            name.setAttribute('disabled' , state);
            email.setAttribute('disabled' , state);
            message.setAttribute('disabled' , state);
        }
        else{
            name.removeAttribute('disabled');
            email.removeAttribute('disabled');
            message.removeAttribute('disabled');
        }
    }

    // if user has given a message before
    if( localStorage.hasOwnProperty('messageUserName') )name.value = localStorage['messageUserName'];
    if( localStorage.hasOwnProperty('messageUserEmail') )email.value = localStorage['messageUserEmail'];

    form.addEventListener('submit' , function(event){

        event.preventDefault();

        // remove submit button and add loading

        let btnContainer = $('#submit_container');

        btnContainer.attr('style','font-size:1.5rem;color:#b60036;');

        btnContainer.html(           
               '<div class="spinner-border" role="status">\
                    <span class="sr-only">Loading...</span>\
                </div>\
                <div style="padding-left: 0.5rem;">\
                    Sending...\
                </div>'
        );

        // disable inputs and textarea{
        changeInputsState(true);

        function doOnSuccess(result){
            if( result ){
                valid = true;
            }
            else{
                valid = false;
                validateFields();
                form.addEventListener('input' , function(){ // activate live validation on client side
                    validateFields();         
                });
            }
        }
    
        function doOnFail(){
            $('<h3 class="alert alert-danger">An error occured while trying to validate the form, please reload the page.</h3>').insertAfter( "form" );
        }

        function changeFormBack(){
            btnContainer.html('<button id="submit_button" class="btn details-button" type="submit">Send</button>');
            changeInputsState(false);
        }

        function theRequest(){
        
            return $.post(website.adminAjaxUrl , {
                action : 'validate_movie_form',
                data:
                {
                    name: name.value,
                    email: email.value,
                    message: message.value,
                    movieID: website.movieID
                }
            })
            .done(doOnSuccess)
            .fail(doOnFail)
            .always(changeFormBack);

        }

        $.when( theRequest() ).done( function(){
            if( valid ){

                $('#movie_form_container').animate({opacity:'0.1', bottom:'200px'} , 'slow' , function(){

                    $('hr').addClass('d-none');
                    $('#box').attr('class' , 'alert alert-success');
                    $('#box').text('Your comment was registered!');

                    if( !localStorage.hasOwnProperty('messageUserName') )localStorage.setItem('messageUserName', prettify(name.value) );
                    if( !localStorage.hasOwnProperty('messageUserEmail') )localStorage.setItem('messageUserEmail', email.value);

                    setTimeout(function(){
                        $("#box").fadeOut(2500);
                    },2000);

                });
            }
        } );

    });

});