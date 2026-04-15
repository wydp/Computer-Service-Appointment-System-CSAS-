<div style="background:#FFF;border:1px solid #E5E5E5;border-radius:12px;padding:24px;">
    <p style="font-size:14px;font-weight:600;color:#000000;margin-bottom:20px;">Staff Workload Distribution</p>
    <div style="position:relative;height:280px;">
        <canvas id="staffWorkloadChart"></canvas>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('staffWorkloadChart');
    if (ctx && typeof Chart !== 'undefined') {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($staffWorkload)) !!},
                datasets: [{
                    label: 'Appointments',
                    data: {!! json_encode(array_values($staffWorkload)) !!},
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
                                return context.parsed.x + ' appointment' + (context.parsed.x !== 1 ? 's' : '');
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
                            stepSize: 1,
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
