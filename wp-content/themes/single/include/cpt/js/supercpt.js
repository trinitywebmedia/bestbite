jQuery( function( $ ){
	if ( $( "input[type='date'].scpt-field" ).length )
		$( "input[type='date'].scpt-field" ).datepicker( { dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true } );

	$( '#post-body' ).on( 'click', '.scpt-remove-thumbnail', function(e) {
		e.preventDefault();
		$( this ).parents( '.scpt-field-wrap' ).find( '.scpt-media-id' ).val( '' );
		$( this ).parents( '.scpt-field-wrap' ).find( '.scpt-add-media' ).show();
		$( this ).parents( '.scpt-field-wrap' ).find( '.scpt-media-preview' ).html( '' );
	});

	$( '#post-body' ).on( 'click', '.scpt-add-media', function() {
		var old_send_to_editor = wp.media.editor.send.attachment;
		var input = this;
		wp.media.editor.send.attachment = function( props, attachment ) {
			props.size = 'thumbnail';
			props = wp.media.string.props( props, attachment );
			props.align = null;
			var preview = '<span class="scpt-image_holder">';
			$(input).parents( '.scpt-field-wrap' ).find( '.scpt-media-id' ).val( attachment.id );
			if ( attachment.type == 'image' ) {
				preview += '<img src="' + props.src + '" />';
			} else {
				preview += wp.media.string.link( props );
			}
			preview += '<a class="button scpt-remove-thumbnail" href="#">X</a>';
			preview += '<a href="#" class="button scpt-add-media" style="">Add Image</a>';
			preview += '</span>';
			$( input ).parents( '.scpt-field-wrap' ).find( '.scpt-media-preview' ).html( preview );
			$( input ).parents( '.scpt-field-wrap' ).find( '.scpt-add-media' ).hide();
			wp.media.editor.send.attachment = old_send_to_editor;
		}
		wp.media.editor.open( input );
	} );
	
	// for multiple media upload
	$( '#post-body' ).on( 'click', '.scpt-remove-multiple_media-thumbnail', function(e) {
		e.preventDefault();
		
		// get all the ids
		var ids = $(this).parents( '.scpt-field-wrap' ).find( '.scpt-multiple_media-ids' ).val();
		
		//get img id 
		var img_id = $( this ).parents( '.zp_image_holder' ).find( 'img' ).attr('class');
		
		// update ids
		ids = ids.replace(img_id+",","");
		
		$(this).parents( '.scpt-field-wrap' ).find( '.scpt-multiple_media-ids' ).val( ids );

		$( this ).parents( '.zp_image_holder' ).remove();

	});

	$( '#post-body' ).on( 'click', '.scpt-add-multiple_media', function() {
		var old_send_to_editor = wp.media.editor.send.attachment;
		var input = this;
		wp.media.editor.send.attachment = function( props, attachment ) {
			props.size = 'thumbnail';
			props = wp.media.string.props( props, attachment );
			props.align = null;
			
			var value = $(input).parents( '.scpt-field-wrap' ).find( '.scpt-multiple_media-ids' ).val( );
			if( value.length > 0 ){
				ids = value+','+attachment.id+',';
				$(input).parents( '.scpt-field-wrap' ).find( '.scpt-multiple_media-ids' ).val( ids );
			}else{
				$(input).parents( '.scpt-field-wrap' ).find( '.scpt-multiple_media-ids' ).val( attachment.id );
			}

			if ( attachment.type == 'image' ) {
				var img_tag = '<div class="zp_image_holder"><img class="'+attachment.id+'" src="' + props.src + '" /><a class="button scpt-remove-multiple_media-thumbnail" href="#">X</a></div>';
				
				$( input ).parents( '.scpt-field-wrap' ).find( '.scpt-multiple_media-preview' ).append(img_tag);

			}else{
				$( input ).parents( '.scpt-field-wrap' ).find( '.scpt-multiple_media-preview' ).append('Oops, you must upload an image.');
			}

			wp.media.editor.send.attachment = old_send_to_editor;
		}
		wp.media.editor.open( input );
	} );

	$( '#post-body' ).on( 'click', '.scpt-clear-multiple_media', function(e) {
		e.preventDefault();
		$( '.scpt-multiple_media-ids' ).val('');
		$('.zp_image_holder').remove();
	} );

	//ColorPicker
	$('.scpt-field-color').wpColorPicker();

} );