<div style="background:#FFF;border:1px solid #E5E5E5;border-radius:12px;padding:24px;">
    <p style="font-size:14px;font-weight:600;color:#000000;margin-bottom:20px;">12-Month Appointment Trend</p>
    <div style="position:relative;height:280px;">
        <canvas id="monthlyTrendChart"></canvas>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('monthlyTrendChart');
    if (ctx && typeof Chart !== 'undefined') {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($monthlyTrend)) !!},
                datasets: [{
                    label: 'Total Appointments',
                    data: {!! json_encode(array_values($monthlyTrend)) !!},
                    borderColor: '#000000',
                    backgroundColor: 'rgba(0, 0, 0, 0.15)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#000000',
                    pointBorderColor: '#FFF',
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            font: { size: 12, weight: '600' },
                            color: '#333333',
                            padding: 16,
                        },
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.9)',
                        titleFont: { size: 13, weight: '600' },
                        bodyFont: { size: 12 },
                        padding: 12,
                        borderRadius: 6,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' appointment' + (context.parsed.y !== 1 ? 's' : '');
                            }
                        }
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#E5E5E5',
                            drawBorder: false,
                        },
                        ticks: {
                            color: '#666666',
                            font: { size: 12 },
                        },
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            color: '#666666',
                            font: { size: 12 },
                        },
                    },
                },
            }
        });
    }
});
</script>
