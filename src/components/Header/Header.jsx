import React from 'react';

import './Header.scss';

const Header = () => {
	return (
		<header className="directory-info-header">
			<nav className="navbar">
				<div className="container">
					<div className="navbar-brand">
						<a href="/directory/?df">Directory</a>
					</div>
				</div>
			</nav>
		</header>
	);
};

export default Header;
