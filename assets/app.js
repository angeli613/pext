// assets/app.js
import React from 'react';
import { createRoot } from 'react-dom/client';
import DataTable from './js/components/DataTable.js';

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
}


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
