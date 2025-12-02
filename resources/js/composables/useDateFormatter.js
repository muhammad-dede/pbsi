export function useDateFormatter() {
    const formatDate = (date, options = {}) => {
        if (!date) return "-";

        const defaultOptions = {
            day: "2-digit",
            month: "long",
            year: "numeric",
        };

        return new Intl.DateTimeFormat("id-ID", {
            ...defaultOptions,
            ...options,
        }).format(new Date(date));
    };

    const formatDateTime = (date) => {
        if (!date) return "-";

        return new Intl.DateTimeFormat("id-ID", {
            dateStyle: "long",
            timeStyle: "short",
        }).format(new Date(date));
    };

    const formatShort = (date) => {
        if (!date) return "-";

        return new Intl.DateTimeFormat("id-ID", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
        }).format(new Date(date));
    };

    return {
        formatDate,
        formatDateTime,
        formatShort,
    };
}
