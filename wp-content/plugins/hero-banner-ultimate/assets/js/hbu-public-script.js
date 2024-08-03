(function($) {

	"use strict";

		$( '.hbupro-hero-banner' ).each(function( index ) {

			var player_id		= $(this).find('.hbu-container-player').attr('id');
			var video_conf		= JSON.parse( jQuery(this).find('.hbu-container-player').attr('data-conf') );

			if( video_conf.banner_video_url != '' ) {
				$('#'+player_id).ContainerPlayer({
					youTube: {  
						videoId: video_conf.banner_video_url,
					}
				});
			} else {
				$('#'+player_id).ContainerPlayer({
					vimeo: {  
						videoId: video_conf.banner_vmvideo_url,
					}
				});
			}
		});
})(jQuery);