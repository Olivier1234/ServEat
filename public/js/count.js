$(() => {

  $.ajax({
    url: "/messages/count/envoyé",
  })
  .done(function(json) {
    $('.msg-badge').text(json)
    if(json == 0) $('.msg-badge').hide()

  })
  .fail(function(err) {
    console.log(err)
  });

})
