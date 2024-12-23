import {useState, useEffect, useRef} from "react";
import React from 'react';
import ReactDOM from 'react-dom/client';

function FavColor(){
	const [color, setColor] = useState("red");
	
	return (
		<>
			<h1>My favourite colour is {color}!</h1>
			<button onClick={()=>setColor("blue")}>Blue</button>
			<button onClick={()=>setColor("purple")}>Purple</button>
			<button onClick={()=>setColor("black")}>Black</button>
		</>
	);
}

const container = document.getElementById('root');
const root = ReactDOM.createRoot(container);
root.render(<FavColor />);

/*import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';
import './css/app.css';

const Modal = () => {
	const [show, setShow] = useState(false); 
	const handleShow = () => setShow(true); 
	const handleClose = () => setShow(false); 
	return ( 
		<> 
			<button type="button" className="btn btn-primary" onClick={handleShow}> Create New moneygone </button> 
			<div className={`modal fade ${show ? 'show' : ''}`} id="memodal" style={{ display: show ? 'block' : 'none' }}> 
				<div className="modal-dialog"> <div className="modal-content"> 
					<div className="modal-header"> 
						<h4 className="modal-title">Record your expense</h4> 
						<button type="button" className="btn-close" onClick={handleClose}></button> 
					</div> 
					<div className="modal-body"> 
						<form> 
							<div className="form-group"> 
								<label>Category</label> 
								<input type="text" className="form-control" /> 
								</div> 
							<div className="form-group"> 
								<label>Title</label> 
								<input type="text" className="form-control" /> 
							</div> 
							<div className="form-group"> 
								<label>Amount</label> 
								<input type="number" className="form-control" /> 
								</div> 
							<div className="form-group"> 
								<label>Date</label> 
								<input type="date" className="form-control" /> 
								</div> 
							<div className="form-group"> 
								<label>Notes</label> 
								<textarea className="form-control"></textarea> 
								</div> 
							<button type="submit" className="btn btn-primary">Save ME!</button> 
							</form> 
					</div> 
					<div className="modal-footer"> 
						<button type="button" className="btn btn-danger" onClick={handleClose}>Close</button> 
					</div> 
				</div>
			</div>
		</div> </> ); 
	}; 
	const container = document.getElementById('react-modal'); 
	if (container) { 
		const root = createRoot(container); 
root.render(<Modal />); }

try {
	// Parse the global variable set in the Twig template
	const categoryData = JSON.parse(window.categoryData);

	const tableColumns = [
		{
			Header: 'Category Name',
			accessor: 'name',
		},
	];

	// Find the root element
	const rootElement = document.getElementById('datatable-root');
	if (rootElement) {
		// Create a root
		const root = createRoot(rootElement);

		// Render the DataTable component with the parsed data
		root.render(<DataTable columns={tableColumns} data={categoryData} />);
	}
} catch (error) {
	console.error('Error parsing category data:', error);
}*/


/*import React from 'react';
import ReactDOM from 'react-dom';
import DataTable from './js/components/DataTable.js';

// Assuming chartData is passed from the server as a global variable
//const chartData = JSON.stringify(window.chartData);
//const categoryData = JSON.parse(window.categoryData);


try { 

	const data = JSON.parse(window.categoryData); 
	ReactDOM.render(
		<DataTable columns={tableColumns} data={data} />, 
		document.getElementById('datatable-root') 
	); 
	} 
catch (error) { 
	console.error('Error parsing category data:', error); 
}

let categoryData = [];
const tableColumns = [{
	Header: 'Category Name',
	accessor: 'name',
}, ];
try {
	
	if (window.categoryData) {
		categoryData = JSON.parse(window.categoryData);
	} else {
		console.error('categoryData is not defined.');
	}
} catch (error) {
	console.error('Error parsing category data:', error);
}

ReactDOM.render(
	<DataTable columns={tableColumns} data={categoryData} />,
	document.getElementById('datatable-root')
);*/