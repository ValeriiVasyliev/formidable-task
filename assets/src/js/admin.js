jQuery(function($){
    $(document).ready(function () {
        var get_table = function(refresh = false) {
            $.ajax({
                type : "post",
                url : my_script.ajax_url,
                dataType: "json",
                cache: true,
                data : {action: "get_table", refresh: refresh},
                success: function(response) {
                    $('#frmchal-list').html(response.table);
                    $('#count').html(response.items_qty);
                    $('#current_date').html(response.current_date);
                },
                error: function(response) {
                    console.error('An error has ocurred, please try again.');
                }
            });
        }
        get_table();
        $('#refresh').on("click", function() {
            get_table(true);
        });
    });
});
