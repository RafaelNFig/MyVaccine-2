document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("searchInput");
    const tableRows = document.querySelectorAll("table tbody tr:not(#no-results-row):not(.no-db-results)");
    const mobileCards = document.querySelectorAll(".post-card");
    const noResultsRow = document.getElementById("no-results-row");
    const noResultsMobile = document.getElementById("no-results-mobile");

    searchInput.addEventListener("input", function() {
        const value = this.value.trim().toLowerCase();
        let anyVisible = false;

        // Desktop
        tableRows.forEach(row => {
            const text = row.innerText.toLowerCase();
            const vaccines = (row.getAttribute('data-vaccines') || '').toLowerCase();

            if (text.includes(value) || vaccines.includes(value)) {
                row.style.display = "";
                anyVisible = true;
            } else {
                row.style.display = "none";
            }
        });

        // Mobile
        mobileCards.forEach(card => {
            const text = card.innerText.toLowerCase();
            const vaccines = (card.getAttribute('data-vaccines') || '').toLowerCase();

            if (text.includes(value) || vaccines.includes(value)) {
                card.style.display = "";
                anyVisible = true;
            } else {
                card.style.display = "none";
            }
        });

        // Exibe/esconde mensagens
        if (noResultsRow) noResultsRow.style.display = anyVisible ? "none" : "";
        if (noResultsMobile) noResultsMobile.style.display = anyVisible ? "none" : "";
    });
});
