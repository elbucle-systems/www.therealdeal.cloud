const dateFormatter = new Intl.DateTimeFormat(undefined, {
    weekday: "short",
    day: "2-digit",
    month: "short",
    hour: "2-digit",
    minute: "2-digit",
});

document.querySelectorAll("time[datetime]").forEach(function (el) {
    el.textContent = dateFormatter.format(
        new Date(el.getAttribute("datetime")),
    );
});

function savePrediction(container) {
    const inputA = container.querySelector(".prediction__input--a");
    const inputB = container.querySelector(".prediction__input--b");
    const savedEl = container.querySelector(".prediction__saved");
    const errEl = container.querySelector(".prediction__error");

    const matchId = container.getAttribute("data-match-id");
    const leagueId = container.getAttribute("data-league-id");
    const valA = inputA.value.trim();
    const valB = inputB.value.trim();

    if (valA === "" || valB === "") return;

    const a = parseInt(valA, 10);
    const b = parseInt(valB, 10);

    if (isNaN(a) || isNaN(b) || a < 0 || b < 0 || a > 50 || b > 50) {
        if (errEl) errEl.textContent = "Score must be 0–50";
        return;
    }

    if (errEl) errEl.textContent = "";

    fetch(`/api/leagues/${leagueId}/matches/${matchId}/prediction`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            "X-CSRF-TOKEN": window.csrfToken(),
        },
        body: JSON.stringify({ predicted_score_a: a, predicted_score_b: b }),
    })
        .then(function (res) {
            if (!res.ok)
                return res.json().then(function (d) {
                    throw new Error(d.message || "Error saving.");
                });
            return res.json();
        })
        .then(function () {
            if (savedEl) {
                savedEl.style.display = "inline-flex";
                setTimeout(function () {
                    savedEl.style.display = "none";
                }, 2500);
            }
        })
        .catch(function (err) {
            if (errEl) errEl.textContent = err.message || "Failed to save.";
        });
}

document.addEventListener("focusout", function (e) {
    if (!e.target.matches(".prediction__input--a, .prediction__input--b"))
        return;
    const container = e.target.closest(".prediction[data-match-id]");
    if (container) savePrediction(container);
});

document.addEventListener("keydown", function (e) {
    if (e.key !== "Enter") return;
    if (!e.target.matches(".prediction__input--a, .prediction__input--b"))
        return;
    e.target.blur();
});
