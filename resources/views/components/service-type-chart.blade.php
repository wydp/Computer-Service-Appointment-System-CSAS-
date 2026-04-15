<div style="background:#FFF;border:1px solid #E5E5E5;border-radius:12px;padding:24px;">
    <p style="font-size:14px;font-weight:600;color:#000000;margin-bottom:20px;">Service Type Distribution</p>
    <div style="position:relative;height:280px;">
        <canvas id="serviceTypeChart"></canvas>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('serviceTypeChart');
    if (ctx && typeof Chart !== 'undefined') {
        const services = {!! json_encode(array_keys($serviceTypes)) !!};
        const total = {!! json_encode(array_sum($serviceTypes)) !!};
        const counts = {!! json_encode(array_values($serviceTypes)) !!};

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: services,
                datasets: [{
                    label: 'Service Count',
                    data: counts,
                    backgroundColor: '#000000',
                    borderColor: '#333333',
                    borderWidth: 1,
                    borderRadius: 6,
                    borderSkipped: false,
                }],
            },
            options: {
                indexAxis: 'y',
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
                                const count = context.parsed.x;
                                const percentage = total > 0 ? Math.round((count / total) * 100) : 0;
                                return count + ' service' + (count !== 1 ? 's' : '') + ' (' + percentage + '%)';
                            }
                        }
                    },
                },
                scales: {
                    x: {
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
                    y: {
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
