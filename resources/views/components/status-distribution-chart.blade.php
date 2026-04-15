<div style="background:#FFF;border:1px solid #E5E5E5;border-radius:12px;padding:24px;">
    <p style="font-size:14px;font-weight:600;color:#000000;margin-bottom:20px;">Appointment Status Distribution</p>
    <div style="display:flex;gap:32px;align-items:center;">
        <div style="flex:1;position:relative;height:220px;">
            <canvas id="statusChart"></canvas>
        </div>
        <div style="flex:1;min-width:0;">
            @foreach([
                'completed' => $statusData['completed'] ?? 0,
                'confirmed' => $statusData['confirmed'] ?? 0,
                'scheduled' => $statusData['scheduled'] ?? 0,
                'no_show' => $statusData['no_show'] ?? 0,
                'cancelled' => $statusData['cancelled'] ?? 0,
            ] as $status => $count)
            @php
                $total = array_sum($statusData);
                $percentage = $total > 0 ? round(($count / $total) * 100) : 0;
                $statusColors = [
                    'completed' => '#000000',
                    'confirmed' => '#333333',
                    'scheduled' => '#666666',
                    'cancelled' => '#999999',
                    'no_show' => '#CCCCCC',
                ];
            @endphp
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <div style="width:12px;height:12px;background:{{ $statusColors[$status] }};border-radius:3px;flex-shrink:0;"></div>
                <p style="font-size:12px;color:#666666;flex:1;">{{ ucfirst(str_replace('_', ' ', $status)) }}</p>
                <p style="font-size:12px;font-weight:600;color:#000000;">{{ $count }} ({{ $percentage }}%)</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('statusChart');
    if (ctx && typeof Chart !== 'undefined') {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Confirmed', 'Scheduled', 'No Show', 'Cancelled'],
                datasets: [{
                    data: [
                        {{ $statusData['completed'] ?? 0 }},
                        {{ $statusData['confirmed'] ?? 0 }},
                        {{ $statusData['scheduled'] ?? 0 }},
                        {{ $statusData['no_show'] ?? 0 }},
                        {{ $statusData['cancelled'] ?? 0 }},
                    ],
                    backgroundColor: [
                        '#000000',
                        '#333333',
                        '#666666',
                        '#CCCCCC',
                        '#999999',
                    ],
                    borderColor: '#FFF',
                    borderWidth: 2,
                    borderRadius: 4,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.9)',
                        titleFont: { size: 13, weight: '600' },
                        bodyFont: { size: 12 },
                        padding: 12,
                        borderRadius: 6,
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + ' appointments';
                            }
                        }
                    },
                },
            }
        });
    }
});
</script>
