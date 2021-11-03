$(document).ready(function(){
    $("#tabList a").click(function(e){
        e.preventDefault();
        $(this).tab("show");
    });
});