$( document ).ready(function() {
    $("#load").fadeOut(800);
    
});


$('body').on('click', '.send_surv', function() {
   $("#send_form").fadeIn(500);
});

$('body').on('click', '#close_form', function() {

  $("#send_form").fadeOut(500);

})


$('body').on('click', '#logo_perso', function() {

  $("#edit_pp").fadeIn(500);

})


$('body').on('click', '#close_edit', function() {

  $("#edit_pp").fadeOut(500);

})




/* IMAGE INPUT HANDLE*/

$("input[type='image']").click(function() {
  $("input[id='my_file']").click();
});

function copyFunction() {
  /* Get the text field */
  var copyText = document.getElementById("link");

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

  /* Copy the text inside the text field */
  document.execCommand("copy");

  var button = $('#copy-btn');
  button.html('Copied !').show('slow');

  setTimeout(function(){
    button.html('Copy Link').show('slow');
  },3000);

}