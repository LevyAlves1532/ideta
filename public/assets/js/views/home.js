(function() {
    const categoriesSelect = document.getElementById('categories');

    categoriesSelect.onchange = searchCategories;

    function searchCategories(event) {
        if (this.value) {
            window.location.href = window.location.href + '?category_id=' + this.value;
        }
    }
})()