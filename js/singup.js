$(function(){

    let bolUser = false;
    let bolEmail = false;
    let bolPass = false;
    let bolBirth = false;
    let bolImage = true;

    $('#user_singup').on('blur', function() {

        if($('#user_singup').val() === '' || $('#user_singup').val().indexOf(' ') !== -1){
            $('#user_singup_label').text('Username invalid!').css("color", "red");
            bolUser = false;
        } else {
            $.ajax({
                type: "GET", url: "/persistencia/getUserRegistrado?nameUser=" + $('#user_singup').val(),
                success: function (response) {
                    if (response.indexOf('true') !== -1) {
                        $('#user_singup_label').text('Username there is already a user with the same name!').css("color", "red");
                        bolUser = false;
                    } else {
                        $('#user_singup_label').text('Username Valid!').css("color", "green");
                        bolUser = true;
                    }
                    valirForm();
                },
                error: function (response) {
                }
            });
        }
    });

    $('#email_singup').on('blur', function() {

        $.ajax({type: "GET", url: "/persistencia/getEmailRegistrado?email=" + $('#email_singup').val(),
            success: function (response) {
                if(( response.indexOf('true') !== -1 ) || ( $('#email_singup').val().indexOf('@', 0) === -1 || $('#email_singup').val().indexOf('.', 0) === -1) ){
                    $('#email_singup_label').text('E-mail Invalid!').css("color", "red");
                    bolEmail = false;
                }else{
                    $('#email_singup_label').text('E-mail Valid!').css("color", "green");
                    bolEmail = true;
                }
                valirForm();
            },
            error: function (response) {

            }
        });
    });

    $('#pass_singup').on('blur', function() {
        if($('#pass_singup').val() === $('#pass2_singup').val() && $('#pass_singup').val().length !== 0 ){
            $('#pass2_singup_label').text('Password Match!').css("color", "green");
            bolPass = true;
        }else{
            $('#pass2_singup_label').text('Repeat Password              Passwords Don´t match!').css("color", "red");
            bolPass = false;
        }
        valirForm();
    });

    $('#pass2_singup').on('blur', function() {
        if($('#pass_singup').val() === $('#pass2_singup').val() && $('#pass2_singup').val().length !== 0){
            $('#pass2_singup_label').text('Password Match!').css("color", "green");
            bolPass = true;
        }else{
            $('#pass2_singup_label').text('Repeat Password              Passwords Don´t match!').css("color", "red");
            bolPass = false;
        }
        valirForm();
    });

    $('#birth_singup').on('blur', function() {
        let birth = new Date($('#birth_singup').val());
        let now = new Date();
        if((now.getFullYear() - birth.getFullYear()) < 18){
            $('#birth_singup_label').text('Birth Date Yo must be over 18!').css("color", "red");
            bolBirth = false;
        }else{
            $('#birth_singup_label').text('Birth Date').css("color", "#9e9e9e");
            bolBirth = true;
        }
        valirForm();
    });

    const image = $('#image_singup');
    image.on('change', function () {
        let posPunto = image.val().indexOf('.') + 1;
        if((image.val().indexOf('jpg', posPunto) !== -1) || (image.val().indexOf('jpeg', posPunto) !== -1) || (image.val().indexOf('png', posPunto) !== -1) || (image.val().indexOf('gif', posPunto) !== -1) ){
            $('#image_singup_label').text('');
            bolImage = true;
        }else{
            $('#image_singup_label').text('Invalid file!');
            bolImage = false;
        }
        valirForm();
    });

    function valirForm(){
        if(bolUser && bolEmail && bolPass && bolBirth && bolImage){
            $('#submit_singup').prop("disabled",false);
        }else{
            $('#submit_singup').prop("disabled",true);
        }
    }
})(jQuery); // end of jQuery name space
