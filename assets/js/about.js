$( document ).ready(function() {
    $("#load").fadeOut(800);


});

$('body').on('click', '.login', function() {
  $("#login_form").fadeIn(500);

});

$('body').on('click', '.register', function() {
  $("#register_form").fadeIn(500);

});


$("#close_form").click(function(){
 $("#login_form").fadeOut(500);

})

$("#close_recover").click(function(){
 $("#forgot_form").fadeOut(500);

})

$("#close_register").click(function(){
 $("#register_form").fadeOut(500);

})



$("#switch_log").click(function(){

  $("#register_form").fadeOut(500);
  $("#login_form").fadeIn(500);

});

$(".switch_reg").click(function(){

  $("#login_form").fadeOut(500);
  $("#forgot_form").fadeOut(500);
  $("#register_form").fadeIn(500);

});

$("#switch_recover").click(function(){

  $("#login_form").fadeOut(500);
  $("#forgot_form").fadeIn(500);

});


var burger_clicked = false;
/* Burger Click event  430 100*/
$("#burger").click(function(){

  if (!burger_clicked){
    $("#get_started").fadeOut();
    $("#bc").fadeIn(0);
    $("#bc").animate({height: "615px",width: "100%"});
    $("#bc").animate({"border-bottom-left-radius" : "0%"});
    $("#burger").empty();
    $("#burger").append('<svg width="25" height="25" class="bi bi-x" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 010 .708l-7 7a.5.5 0 01-.708-.708l7-7a.5.5 0 01.708 0z" clip-rule="evenodd"/> <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 000 .708l7 7a.5.5 0 00.708-.708l-7-7a.5.5 0 00-.708 0z" clip-rule="evenodd"/></svg>');
    $("#burger_content").fadeIn();
    burger_clicked = true;
  }
  else{
    $("#get_started").fadeIn();
    $("#bc").animate({height: "0",width: "0%"});
    $("#bc").animate({"border-bottom-left-radius" : "50%"});
    $("#burger").empty();
    $("#burger").append('<span class="navbar-toggler-icon"></span>');
    $("#burger_content").fadeOut();
    $("#bc").fadeOut(0);
    burger_clicked = false;
  }

  });