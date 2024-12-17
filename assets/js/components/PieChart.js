// assets/js/components/PieChart.js
import React, { useEffect, useRef } from 'react';
import { Chart } from 'chart.js';

function PieChart({ chartData }) {
    const chartRef = useRef(null);

    useEffect(() => {
        const ctx = chartRef.current.getContext('2d');
        const data = JSON.parse(chartData);
        const labels = Object.keys(data);
        const values = Object.values(data);
        
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56', '#2ecc71']
                }]
            },
            options: {
                responsive: true
            }
        });
    }, [chartData]);

    return (
        <canvas ref={chartRef}></canvas>
    );
}

export default PieChart;
