$(function(){

    let bolUser = true;
    let bolEmail = true;
    let bolBirth = true;
    let bolImage = true;
    const username = $('#user_modify').val();
    const email = $('#email_modify').val();

    $('#user_modify').on('blur', function() {

        if($('#user_modify').val() === '' || $('#user_modify').val().indexOf(' ') !== -1) {
            $('#user_modify_label').text('Username invalid!').css("color", "red");
            bolUser = false;

        }else {
            $.ajax({type: "GET", url: "/persistencia/getUserRegistrado?nameUser=" + $('#user_modify').val(),
                success: function(response) {
                    if (response.indexOf('true') === -1 || $('#user_modify').val() === username) {
                        $('#user_modify_label').text('Username Valid!').css("color", "green");
                        bolUser = true;
                    }else{
                        $('#user_modify_label').text('Username there is already a user with the same name!').css("color", "red");
                        bolUser = false;
                    }
                    valirForm();
                },
                error: function (response) {
                }
            });
        }
    });

    $('#email_modify').on('blur', function() {

        $.ajax({type: "GET", url: "/persistencia/getEmailRegistrado?email=" + $('#email_modify').val(),
            success: function (response) {
                if(( (response.indexOf('true') !== -1 ) || ( $('#email_modify').val().indexOf('@', 0) === -1 || $('#email_modify').val().indexOf('.', 0) === -1))
                    && $('#email_modify').val() !== email ){
                    $('#email_modify_label').text('E-mail Invalid!').css("color", "red");
                    bolEmail = false;
                }else{
                    $('#email_modify_label').text('E-mail Valid!').css("color", "green");
                    bolEmail = true;

                }
                valirForm();
            },
            error: function (response) {
            }
        });
    });

    $('#birth_modify').on('blur', function() {
        let birth = new Date($('#birth_modify').val());
        let now = new Date();
        if((now.getFullYear() - birth.getFullYear()) < 18){
            $('#birth_modify_label').text('Birth Date Yo must be over 18!').css("color", "red");
            bolBirth = false;
        }else{
            $('#birth_modify_label').text('Birth Date').css("color", "#9e9e9e");
            bolBirth = true;
        }
        valirForm();
    });

    const image = $('#image_modify');
    image.on('change', function () {
        let posPunto = image.val().indexOf('.') + 1;
        if((image.val().indexOf('jpg', posPunto) !== -1) || (image.val().indexOf('jpeg', posPunto) !== -1) || (image.val().indexOf('png', posPunto) !== -1) || (image.val().indexOf('gif', posPunto) !== -1) ){
            $('#image_modify_label').text('');
            bolImage = true;
        }else{
            $('#image_modify_label').text('Invalid file!');
            bolImage = false;
        }
        valirForm();
    });

    function valirForm(){
        if(bolUser && bolEmail && bolBirth && bolImage){
            $('#submit_modify').prop("disabled",false);
        }else{
            $('#submit_modify').prop("disabled",true);
        }
    }
})(jQuery); // end of jQuery name space
