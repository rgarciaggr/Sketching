$(function(){
    $('#searchNav').autocomplete({
        data: {
            "Apple": null,
            "Microsoft": null,
            "Google": 'https://placehold.it/250x250',
        },
        minLength : 3,
    });
});

$("#searchNav").on('keyup', function(e) {
    if(e.which !== 13){
    let busqueda = $("#searchNav").val();
    if(busqueda.length > 3) {
        $.ajax({
            type: "POST",
            dataType: "json",
            data: {"busqueda": busqueda},
            url: "/persistencia/getBusqueda",
            success: function (response) {
                let userArray = response;
                let dataUser = {};
                for (let i = 0; i < userArray.length; i++) {
                    dataUser[userArray[i].username] = '/interfaz/profile_images/profile_' + userArray[i].profile_image;
                    console.log(dataUser);
                }
                $("#searchNav").autocomplete({
                    data: dataUser,
                    limit: 5
                });
            },
            async: false
        });
    }}
});