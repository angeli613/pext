import React from 'react';
import ReactDOM from 'react-dom';

const NavBar = () => {
    return ( 
        <nav> 
            <ul> 
                <li><a href="/">Home</a></li> 
                <li><a href="/about">About</a></li> 
                <li><a href="/contact">Contact</a></li> 
            </ul> 
        </nav> 
        ); 
    };

    const app = () => ( <div> <h1>Hello, React!</h1> <NavBar /> </div>);

ReactDOM.render(<app />, document.getElementById('root'));