jQuery( document ).ready( function() {
  var spotlights = JSON.parse( $('#info').attr('data-attr') );
  $('.spotlight').on('click', function() {
      var clicked = $(this).attr('data');
      var replace = $('#full-spot img').attr('data');
      $(this).attr('data', replaced);
      $('#full-spot img').attr('data', clicked);
      $('spotlight').html('<h2>' + spotlights.clicked.title + '</h2><p>' + spotlights.clicked.content + '</p><a href="' + spotlights.clicked.permalink + '">Read More</a>');
  }).trigger();
});
