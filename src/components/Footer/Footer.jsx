import React from 'react';

import './Footer.scss';

const Footer = () => {
	return (
		<footer className="directory-info-footer">
			<div className="container">
				<p>
					&copy; Copyright &middot;{ ' ' }
					<a
						href="https://www.nilambar.net/"
						target="_blank"
						rel="noreferrer"
					>
						Nilambar
					</a>
				</p>
			</div>
		</footer>
	);
};

export default Footer;
