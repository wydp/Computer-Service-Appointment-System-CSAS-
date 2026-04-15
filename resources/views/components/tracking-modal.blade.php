<!-- Shopee-Style Tracking Modal -->
<div id="trackingModal" style="display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.5);z-index:1000;padding:20px;overflow-y:auto;">
    <div style="background:#FFFFFF;border-radius:12px;max-width:90%;width:90%;max-height:90vh;margin:20px auto;box-shadow:0 20px 60px rgba(0,0,0,0.15);animation:slideUp 0.3s ease-out;display:flex;flex-direction:column;">
        <!-- Header -->
        <div style="padding:24px;border-bottom:1px solid #E5E5E5;display:flex;align-items:center;justify-content:space-between;background:#FFFFFF;">
            <div>
                <h2 style="font-size:18px;font-weight:700;color:#000000;margin:0;">Appointment Status Tracking</h2>
                <p style="font-size:12px;color:#999999;margin:6px 0 0 0;">Track your appointment progress</p>
            </div>
            <button onclick="closeTrackingModal()" style="background:none;border:none;cursor:pointer;font-size:28px;color:#999999;padding:0;width:32px;height:32px;display:flex;align-items:center;justify-content:center;transition:color 0.2s;" onmouseover="this.style.color='#000000'" onmouseout="this.style.color='#999999'">×</button>
        </div>

        <!-- Appointment Info -->
        <div id="appointmentInfo" style="padding:24px;border-bottom:1px solid #E5E5E5;background:#FFFFFF;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:16px;">
                <div>
                    <p style="font-size:11px;font-weight:600;color:#999999;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Client</p>
                    <p style="font-size:14px;font-weight:600;color:#000000;margin:0;">—</p>
                </div>
                <div>
                    <p style="font-size:11px;font-weight:600;color:#999999;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Service</p>
                    <p style="font-size:14px;font-weight:600;color:#000000;margin:0;">—</p>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                <div>
                    <p style="font-size:11px;font-weight:600;color:#999999;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Date</p>
                    <p style="font-size:14px;font-weight:600;color:#000000;margin:0;">—</p>
                </div>
                <div>
                    <p style="font-size:11px;font-weight:600;color:#999999;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Time</p>
                    <p style="font-size:14px;font-weight:600;color:#000000;margin:0;">—</p>
                </div>
            </div>
        </div>

        <!-- Status Details -->
        <div style="padding:32px;background:#FFFFFF;flex:1;overflow-y:auto;">
            <p style="font-size:12px;font-weight:600;color:#000000;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:24px;">Status Timeline</p>
            <div id="trackingTimeline" style="max-height:100%;">
                <!-- Will be populated by JavaScript -->
            </div>
        </div>

        <!-- Footer -->
        <div style="padding:24px;border-top:1px solid #E5E5E5;text-align:right;background:#F8F9FA;flex-shrink:0;">
            <button onclick="closeTrackingModal()" style="background:#000000;border:none;color:#FFFFFF;padding:12px 32px;border-radius:6px;cursor:pointer;font-weight:600;font-size:14px;transition:all 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">Close</button>
        </div>
    </div>
</div>

<script>
const STATUS_SEQUENCE = ['scheduled', 'confirmed', 'completed', 'cancelled', 'no_show'];
const STATUS_LABELS = {
    'scheduled': 'Order Placed',
    'confirmed': 'Confirmed',
    'completed': 'Completed',
    'cancelled': 'Cancelled',
    'no_show': 'No Show'
};

const STATUS_ICONS = {
    'scheduled': '📋',
    'confirmed': '✓',
    'completed': '✓',
    'cancelled': '✕',
    'no_show': '–'
};

function openTrackingModal(appointmentId) {
    fetch(`/api/appointments/${appointmentId}/tracking`)
        .then(response => response.json())
        .then(data => {
            // Populate appointment info
            const appointmentInfo = document.getElementById('appointmentInfo');
            const dateTime = data.appointment.date_time.split(' at ');
            appointmentInfo.innerHTML = `
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:16px;">
                    <div>
                        <p style="font-size:11px;font-weight:600;color:#999999;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Client</p>
                        <p style="font-size:14px;font-weight:600;color:#000000;margin:0;">${data.appointment.client_name}</p>
                    </div>
                    <div>
                        <p style="font-size:11px;font-weight:600;color:#999999;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Service</p>
                        <p style="font-size:14px;font-weight:600;color:#000000;margin:0;">${data.appointment.service_type}</p>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                    <div>
                        <p style="font-size:11px;font-weight:600;color:#999999;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Date</p>
                        <p style="font-size:14px;font-weight:600;color:#000000;margin:0;">${dateTime[0]}</p>
                    </div>
                    <div>
                        <p style="font-size:11px;font-weight:600;color:#999999;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Time</p>
                        <p style="font-size:14px;font-weight:600;color:#000000;margin:0;">${dateTime[1] || '—'}</p>
                    </div>
                </div>
            `;

            // Populate history timeline
            const timeline = document.getElementById('trackingTimeline');
            timeline.innerHTML = data.tracking.map((item, index) => `
                <div style="display:flex;gap:12px;margin-bottom:${index === data.tracking.length - 1 ? '0' : '16px'};padding-bottom:${index === data.tracking.length - 1 ? '0' : '16px'};border-bottom:${index === data.tracking.length - 1 ? 'none' : '1px solid #E5E5E5'}">
                    <div style="display:flex;flex-direction:column;align-items:center;min-width:24px;">
                        <div style="width:8px;height:8px;background:#000000;border-radius:50%;position:relative;z-index:2;"></div>
                    </div>
                    <div style="flex:1;">
                        <p style="font-size:13px;font-weight:600;color:#000000;margin-bottom:4px;">${item.status_change}</p>
                        <p style="font-size:12px;color:#999999;margin-bottom:4px;">By ${item.changed_by}</p>
                        ${item.service_completed_by ? `<p style="font-size:12px;color:#999999;margin-bottom:4px;">Service by ${item.service_completed_by}</p>` : ''}
                        <p style="font-size:12px;color:#999999;">${item.timestamp}</p>
                        ${item.notes ? `<p style="font-size:12px;color:#666666;margin-top:8px;font-style:italic;">&quot;${item.notes}&quot;</p>` : ''}
                    </div>
                </div>
            `).join('');

            document.getElementById('trackingModal').style.display = 'flex';
            document.getElementById('trackingModal').style.alignItems = 'flex-start';
            document.getElementById('trackingModal').style.justifyContent = 'center';
        })
        .catch(error => console.error('Error fetching tracking data:', error));
}

function closeTrackingModal() {
    document.getElementById('trackingModal').style.display = 'none';
}

document.getElementById('trackingModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeTrackingModal();
});
</script>

<style>
@keyframes slideUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>
