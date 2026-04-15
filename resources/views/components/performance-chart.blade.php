<div style="background:#FFF;border:1px solid #E5E5E5;border-radius:12px;padding:24px;">
    <p style="font-size:14px;font-weight:600;color:#000000;margin-bottom:20px;">Staff Performance Metrics</p>
    <div style="position:relative;height:280px;">
        <canvas id="performanceChart"></canvas>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('performanceChart');
    if (ctx && typeof Chart !== 'undefined') {
        const staffNames = {!! json_encode(array_keys($staffPerformance)) !!};
        const completionRates = staffNames.map(name => {
            const data = {!! json_encode($staffPerformance) !!};
            return data[name]?.rate || 0;
        });

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: staffNames,
                datasets: [{
                    label: 'Completion Rate (%)',
                    data: completionRates,
                    backgroundColor: completionRates.map(rate => {
                        if (rate >= 80) return '#000000';
                        if (rate >= 60) return '#555555';
                        return '#AAAAAA';
                    }),
                    borderColor: '#E5E5E5',
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
                                return context.parsed.x + '% completion rate';
                            }
                        }
                    },
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 100,
                        grid: {
                            color: '#E5E5E5',
                            drawBorder: false,
                        },
                        ticks: {
                            color: '#666666',
                            font: { size: 12 },
                            callback: function(value) {
                                return value + '%';
                            }
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
