$(function() {
    var timer;
    function loadBlogs() {
        var category = $('#category').val();
        var date = $('#date').val();
        var search = $('#search').val();

        $.ajax({
            url: 'ajax/blog-filter.php',
            type: 'GET',
            data: { category: category, date: date, search: search },
            beforeSend: function() {
                $('#blogGrid').html('<div class="no-results">Loading blogs…</div>');
            },
            success: function(html) {
                $('#blogGrid').html(html);
            },
            error: function() {
                $('#blogGrid').html('<div class="no-results">Unable to load blogs. Please try again later.</div>');
            }
        });
    }

    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        loadBlogs();
    });

    $('#category, #date').on('change', function() {
        loadBlogs();
    });

    $('#search').on('input', function() {
        clearTimeout(timer);
        timer = setTimeout(loadBlogs, 300);
    });
});
