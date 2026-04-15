// Chart.js default configuration for the application
import Chart from "chart.js/auto";

export const chartDefaults = {
    responsive: true,
    maintainAspectRatio: true,
    plugins: {
        legend: {
            labels: {
                font: {
                    size: 12,
                    weight: "600",
                    family: "'Inter', sans-serif",
                },
                color: "#525252",
                padding: 16,
                usePointStyle: true,
                pointStyle: "circle",
            },
            position: "right",
        },
        tooltip: {
            backgroundColor: "rgba(26, 26, 26, 0.95)",
            titleFont: {
                size: 13,
                weight: "600",
            },
            bodyFont: {
                size: 12,
            },
            padding: 12,
            borderRadius: 6,
            displayColors: true,
            callbacks: {
                labelColor: function (context) {
                    return {
                        borderColor:
                            context.dataset.borderColor ||
                            context.dataset.backgroundColor,
                        backgroundColor:
                            context.dataset.backgroundColor || "#FFD700",
                    };
                },
            },
        },
    },
};

export const colorScheme = {
    completed: "#FFD700",
    confirmed: "#4A5568",
    scheduled: "#2D2D2D",
    cancelled: "#6B2C2C",
    no_show: "#6B7280",
    gold: "#FFD700",
    darkGray: "#2D2D2D",
    lightGray: "#F5F5F5",
    mediumGray: "#8A8A8A",
};

export const initChart = (ctx, config) => {
    return new Chart(ctx, {
        ...config,
        options: {
            ...chartDefaults,
            ...config.options,
        },
    });
};
