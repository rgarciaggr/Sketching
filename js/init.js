(function($){
    
    $(function(){
        $('.tabs').tabs();
    });
    
    $(function(){
        $('.sidenav').sidenav();
    });
        $('select').formSelect();

    $(function(){
        $('.datepicker').datepicker({
            format: 'yyyy'
        });
    });

})(jQuery); // end of jQuery name space
