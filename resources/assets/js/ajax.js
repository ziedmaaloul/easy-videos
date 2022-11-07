function loadMore(){
    $('#loadMoreIcon').show();
	$('#loadMoreContainer'). prop('disabled', true);
    $.ajax({
        headers : 
           {
               "X-WP-NONCE" : window.trHelpers.nonce
           },
       method: "POST",
       url: "/fetch-more-videos",
       data: { token: $('#loadMore').data('token'), channelId: $('#loadMore').data('channelId') }
     })
       .done(function( msg ) {
        $('#loadMoreContainer').remove();
        $('.video-element:last-child').after(msg);
        loadMoreButtonAction();
   });
}

function loadMoreButtonAction(){
    $('#loadMore').on('click' , () => {
        loadMore();
    });
}



$(document).ready(function(e) {   
    loadMoreButtonAction();
 });