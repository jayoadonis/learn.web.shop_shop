


//REM: [TODO] .|. Create public end points for user CRUD.

window.document.addEventListener( "DOMContentLoaded", function() {

    const btnSignUp = window.document.querySelector(`button[id="html-btn-sign-up"][data-store]`);

    if( btnSignUp ) {

        btnSignUp.addEventListener('click', async function() {

            const txtFirstName = window.document.querySelector(`input[name="first_name"]`).value;

            alert(`Sign-up button clicked! data: [${txtFirstName}]`);
        },{passive:true});
    }

});