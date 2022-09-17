import './sass/directory.scss';

jQuery( function( $ ) {
	const generateThemesMarkup = ( themes ) => {
		if ( themes.length === 0 ) {
			return;
		}

		let markup = `<tr>
		<th>Sn</th>
		<th>Name</th>
		<th>Version</th>
		<th>Last Updated</th>
		<th>Downloads</th>
		<th>Thumbnail</th>
		</tr>`;

		let cnt = 1;

		themes.forEach( function( theme ) {
			markup += `<tr>
			<td>${ cnt }</td>
			<td><a href="https://wordpress.org/themes/${ theme.slug }/" target="_blank">${ theme.name }</a></td>
			<td>${ theme.version }</td>
			<td>${ theme.last_updated }</td>
			<td>${ theme.downloaded }</td>
			<td><img class="thumb" src="${ theme.screenshot_url }" alt="${ theme.name }"/></td>
			</tr>`;

			cnt++;
		} );

		return `<table>${ markup }</table>`;
	};

	const generatePluginsMarkup = ( plugins ) => {
		if ( plugins.length === 0 ) {
			return;
		}

		let markup = `<tr>
		<th>Sn</th>
		<th>Name</th>
		<th>Version</th>
		<th>Last Updated</th>
		<th>Downloads</th>
		<th>Thumbnail</th>
		</tr>`;

		let cnt = 1;

		plugins.forEach( function( plugin ) {
			let thumbnailUrl = '';

			if ( plugin.screenshots ) {
				const first = Object.values( plugin.screenshots )[ 0 ];

				if ( first ) {
					thumbnailUrl = first.src;
				}
			}

			let thumb = ' ';

			if ( thumbnailUrl ) {
				thumb = `<img class="thumb" src="${ thumbnailUrl }" alt="${ plugin.name }"/>`;
			}

			markup += `<tr>
			<td>${ cnt }</td>
			<td><a href="https://wordpress.org/plugins/${ plugin.slug }/" target="_blank">${ plugin.name }</a></td>
			<td>${ plugin.version }</td>
			<td>${ plugin.last_updated }</td>
			<td>${ plugin.downloaded }</td>
			<td>${ thumb }</td>
			</tr>`;

			cnt++;
		} );

		return `<table>${ markup }</table>`;
	};

	$( '#frm-directory-info' ).on( 'submit', function() {
		const wporgId = $( '#wporg_id' ).val();

		if ( '' === wporgId ) {
			return false;
		}

		const $loading = $( '#di-loading' );

		$.ajax( {
			url: ajaxurl,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'get_wporg_id_detail',
				wporg_id: wporgId,
			},

			beforeSend() {
				$loading.show();
			},

			complete( jqXHR ) {
				const response = JSON.parse( jqXHR.responseText );

				if ( true === response.success ) {
					const themesMarkup = generateThemesMarkup( response.data.themes );
					$( '#di-themes-output' ).html( themesMarkup );

					const pluginsMarkup = generatePluginsMarkup( response.data.plugins );
					$( '#di-plugins-output' ).html( pluginsMarkup );
				}

				$loading.hide();
			},

		} );

		return false;
	} );
} );

// (function( $ ) {

// 	jQuery(document).ready(function() {
// 		jQuery("time.timeago").timeago();

// 		$('.lazy').Lazy({
// 			onError: function(element) {
// 				var data_src = $( element ).attr( 'data-src' );
// 				var new_url = data_src.replace( '.png', '.jpg' );
// 				$( element ).attr( 'data-src', new_url );
// 				$( element ).attr( 'src', new_url );
// 			}
// 		});

// 	});

// })( jQuery );
