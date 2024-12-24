import React, { useState } from 'react';
import ReactDOM from 'react-dom/client';

const NavBar = () => { 
	const [showNav, setShowNav] = useState(false); 
	
	return ( 
		<div> 
			<button className="navbar-toggle" onClick={() => setShowNav(!showNav)} 
				style={{ fontSize: '30px', cursor: 'pointer', backgroundColor: '#333', color: 'white', border: 'none', padding: '10px' }}> ☰ 
			</button> 
			{showNav && ( 
				<nav className="navbar-content" style={{ backgroundColor: '#444', color: 'white', padding: '10px' }}> 
					<ul style={{ listStyle: 'none', padding: 0 }}> 
						<li><a href="/" style={{ color: 'white', textDecoration: 'none' }}>Home</a></li> 
						<li><a href="/admin" style={{ color: 'white', textDecoration: 'none' }}>Admin View</a></li> 
						<li><a href="/expenseslist" style={{ color: 'white', textDecoration: 'none' }}>Expenses List</a></li> 
					</ul> 
				</nav>
			)} 
		</div> 
	);
};

ReactDOM.createRoot(document.getElementById('root')).render(<NavBar />);