$(function(){
    //http://www.phpcluster.com/infinite-scroll-in-php-using-jquery-ajax-and-mysql/
        $(window).scroll(function () {
            //check if the users are at bottom of the window
            //scroll to returns 0
            if ($(window).scrollTop() + $(window).height() >= $(document).height())
            {
                let ids = $('.vikash:last').attr("id");
                let autor = $('#need').attr("aria-valuenow");
                //Hay que pasar el id del autor
                $.ajax({
                    type: 'post',
                    asynch: false,
                    url: 'persistencia/get_moredata',
                    cache: false,
                    data: {
                        getdata: ids,
                        autor: autor
                    },
                    success: function (response) {
                        //appending the result get_moredata page result with div id alldata
                        $('#alldata').append(response);
                    }
                });
            }
        });
})(jQuery); // end of jQuery name space