ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );

$(document).ready(function(){

    $('#selectAllBoxes').click(function(event){
        if(this.checked){
            $('.checkBoxes').each(function(){
                this.checked = true;
            });
        } else {
            $('.checkBoxes').each(function(){
                this.checked = false;
            });
        }

    });

});

function loadUsersOnline() {
    $.get("functions.php?usersonline=result", function(data){
        $(".usersonline").text(data);

    });
}

setInterval(function(){

    loadUsersOnline();

}, 500);
loadUsersOnline();

// $(document).ready(function(){
//         var a = document.forms["post_comment_form"]['a'].value;
//         var b = document.forms["post_comment_form"]['b'].value;
//         var c = document.forms["post_comment_form"]['c'].value;
//         console.log(a);
// });

var div_box = "<div id='load-screen'><div id='loading'></div></div>";
$("body").prepend(div_box);
$('#load-screen').delay(700).fadeOut(600, function(){
    $(this.remove());
});