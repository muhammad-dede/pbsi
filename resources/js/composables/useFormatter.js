export function useFormatter() {
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

    const formatShortDate = (date) => {
        if (!date) return "-";

        return new Intl.DateTimeFormat("id-ID", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
        }).format(new Date(date));
    };

    const formatDateTime = (date) => {
        if (!date) return "-";

        return new Intl.DateTimeFormat("id-ID", {
            dateStyle: "long",
            timeStyle: "short",
        }).format(new Date(date));
    };

    const formatShortTime = (time) => {
        if (!time) return "";
        return time.slice(0, 5);
    };

    const formatNumber = (value) => {
        if (value === null || value === undefined || value === "") return "-";
        return new Intl.NumberFormat("id-ID").format(value);
    };

    const formatCurrency = (
        value,
        currency = "IDR",
        minimumFractionDigits = 0
    ) => {
        if (value === null || value === undefined || value === "") return "-";

        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency,
            minimumFractionDigits,
        }).format(value);
    };

    return {
        formatDate,
        formatShortDate,
        formatDateTime,
        formatShortTime,
        formatNumber,
        formatCurrency,
    };
}
