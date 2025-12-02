export function useStatusEnum() {
    const statusMap = {
        ACTIVE: {
            label: "Aktif",
            color: "bg-green-500/10 text-green-600 border border-green-500/20",
            icon: "CheckCircle",
        },
        INACTIVE: {
            label: "Non Aktif",
            color: "bg-red-500/10 text-red-600 border border-red-500/20",
            icon: "XCircle",
        },
    };

    const getStatus = (status) => {
        if (!status) return null;
        return statusMap[status] ?? { label: status, color: "", icon: "" };
    };

    const getStatusLabel = (status) => getStatus(status).label;
    const getStatusColor = (status) => getStatus(status).color;
    const getStatusIcon = (status) => getStatus(status).icon;

    return {
        getStatus,
        getStatusLabel,
        getStatusColor,
        getStatusIcon,
    };
}
