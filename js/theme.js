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

const searchButton = document.getElementById('searchButton');
const searchForm = document.getElementById('searchForm');

searchButton.addEventListener('click', function () {

    searchForm.classList.toggle('active');

    if (searchForm.classList.contains('active')) {

        searchForm.querySelector('input').focus();

    }

});
function toggleDigital() {

    const subcategories = document.getElementById("digitalSubcategories");
    const arrow = document.querySelector(".category-arrow");

    subcategories.classList.toggle("show");
    arrow.classList.toggle("rotate");
}