const themeButton = document.getElementById("themeButton");

if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark");
}

function updateThemeButton() {
    if (!themeButton) return;

    if (document.body.classList.contains("dark")) {
        themeButton.textContent = "حالت روشن";
    } else {
        themeButton.textContent = "حالت تیره";
    }
}

updateThemeButton();
if (themeButton) {
    themeButton.addEventListener("click", function () {

        document.body.classList.toggle("dark");

        if (document.body.classList.contains("dark")) {
            localStorage.setItem("theme", "dark");
        } else {
            localStorage.setItem("theme", "light");
        }

        updateThemeButton();
    });
}