//Image gallery
$(document).ready(function() {
    $(".image-row:not(:first)").hide();
  
    $("#gallery-button").on('click', function(event) {
      event.preventDefault();
      
      var $hiddenRow = $(".image-row:hidden:first");
      if ($hiddenRow.length > 0) {
        $hiddenRow.fadeIn(800);
      }
      
      if ($(".image-row:hidden").length === 0) {
        $(this).fadeOut();
      }
    });
  });

  //Mobile nav
  $(document).ready(function() {
    $(".has-submenu-mobile").on('click', function(event) {
        event.stopPropagation(); 
        $(this).find(".hide-mobile").toggleClass("show");
    });
});
  
