import React, { useState } from 'react';
import ReactDOM from 'react-dom/client';

const NavBar = () => { 
	const [showNav, setShowNav] = useState(false); 
	
	return ( 
		<div> 
			<button className="navbar-toggle" onClick={() => setShowNav(!showNav)} 
				style={{ fontSize: '30px', cursor: 'pointer', backgroundColor: '#fff', color: 'black', border: 'none', padding: '10px' }}> ☰ 
			</button> 
			{showNav && ( 
				<nav className="navbar-content" style={{  backgroundColor: '#fff', color: 'black', padding: '10px' }}> 
					<ul style={{ listStyle: 'none', padding: 0 }}> 
						<li><a href="/" style={{ color: 'black', textDecoration: 'none' }}>Home</a></li> 
						<li><a href="/admin" style={{ color: 'black', textDecoration: 'none' }}>Admin View</a></li> 
						<li><a href="#expenselist" style={{ color: 'black', textDecoration: 'none' }}>Expense List</a></li> 
					</ul> 
				</nav>
			)} 
			<br/>
		</div> 
	);
};

ReactDOM.createRoot(document.getElementById('root')).render(<NavBar />);