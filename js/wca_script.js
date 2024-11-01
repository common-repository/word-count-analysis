jQuery(document).ready(function ($) {
    $("#posts").DataTable({
        "order": [[5, "desc"]],
        stateSave: false
    });
    $("#author").DataTable({
        "order": [[3, "desc"]],
        stateSave: false
    });


});
