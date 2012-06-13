Drupal.behaviors.centenarySearch = function(context) {
  $("#block-search-0 h2").addClass('centenary-search').click(function() {
    $("#block-search-0 input").focus();
  });
  $("#block-search-0 input").focus(function() {
    $("#block-search-0 h2").hide();
  })
  .blur(function() {
    if ($(this).val() == "") {
      $("#block-search-0 h2").show();
    }
  })
}
