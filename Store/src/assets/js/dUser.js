$(document).ready(function(){
    
  $("body").on("click", ".btn-danger", function(){
     $(this).toggle();
     $("#update").toggle();
  });
});