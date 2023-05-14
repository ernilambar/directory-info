import React from 'react';

import Header from './components/Header/Header';
import Footer from './components/Footer/Footer';
import Dashboard from './components/Dashboard/Dashboard';

import { library } from '@fortawesome/fontawesome-svg-core';
import { fab } from '@fortawesome/free-brands-svg-icons';
import { fas } from '@fortawesome/free-solid-svg-icons';

library.add( fab, fas );

const App = () => {
	return (
		<div className="directory-info">
			<Header />
			<Dashboard />
			<Footer />
		</div>
	);
};

export default App;
