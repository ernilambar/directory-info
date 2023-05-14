import App from './App';

import { createRoot } from '@wordpress/element';

import './img/favicon.png';

const diAppElement = document.getElementById( 'di-app' );

if ( diAppElement ) {
	const root = createRoot( diAppElement );

	root.render( <App /> );
}
