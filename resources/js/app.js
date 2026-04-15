window.csrfToken = function () {
    return document.querySelector('meta[name="csrf-token"]').content;
};

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

document.addEventListener("submit", function (e) {
    e.target.querySelectorAll('button[type="submit"]').forEach(function (btn) {
        btn.disabled = true;
    });
});
