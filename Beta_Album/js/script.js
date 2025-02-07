document.addEventListener("DOMContentLoaded", function() {
    const searchBtn = document.getElementById("search-btn");
    const searchForm = document.getElementById("search-form");

    searchBtn.addEventListener("click", function(event) {
        event.preventDefault();
        searchForm.style.display = (searchForm.style.display === "block") ? "none" : "block";
    });
});
