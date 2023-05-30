(function () {

    /**
     * This script handles the login functionality
     * Users will be redirected to the Videoke Player if using a Desktop or Large Screens
     * Else, will be redirected to the Song Selection page if using a mobile phone or small screens
     * */


    //select the login button
    let loginBtn = document.querySelector('.jk-login-btn');
    //select the access code input element
    let inputElement = document.querySelector('#accessCodeInput');

    //handle login functionality
    loginBtn.onclick = function () {
        //disable the login button and access code input first
        loginBtn.setAttribute('disabled', true);
        inputElement.setAttribute('disabled', true);

        $.ajax({
            url: 'auth/login',
            method: 'POST',
            type: 'JSON',
            data: { code: inputElement.value },
            success: function (data) {
                if (data.status == 'success') {
                    //if logged in successfully, check if the device is mobile or not
                    toastr.success('Logged in successfully.');
                    if (window.mobileCheck()) {
                        //if mobile, redirect to the song selection page
                        window.location.href = JKGlobals.baseURL + '/select';
                    } else {
                        //if not, redirect to the videoke player
                        window.location.href = JKGlobals.baseURL + '/player';
                    }
                } else {
                    toastr.error('Access code invalid. Please contact IT to get valid access code.');
                }

                //re-enable the button and input elements 
                loginBtn.removeAttribute('disabled');
                inputElement.removeAttribute('disabled');
            },
            error: function (e1, e2, e3) {
                console.log(e1);
                console.log(e2);
                console.log(e3);

                toastr.error('Network error. Please contact IT.');

                //re-enable the button and input elements if an error is encountered
                loginBtn.removeAttribute('disabled');
                inputElement.removeAttribute('disabled');
            }
        });
    }

})();