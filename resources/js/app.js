window.csrfToken = function () {
    return document.querySelector('meta[name="csrf-token"]').content;
};

document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("theme-toggle");
    if (btn) {
        btn.addEventListener("click", function () {
            const isDark = document.documentElement.classList.contains("dark");
            const next = isDark ? "light" : "dark";
            document.documentElement.classList.remove("light", "dark");
            document.documentElement.classList.add(next);
            localStorage.setItem("vite-ui-theme", next);
        });
    }

    document.querySelectorAll("form").forEach(function (form) {
        form.addEventListener("submit", function () {
            form.querySelectorAll('button[type="submit"]').forEach(
                function (submitBtn) {
                    submitBtn.disabled = true;
                },
            );
        });
    });
});
