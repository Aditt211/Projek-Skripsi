<script>
    $(document).ready(function() {
        $(".show_modal").click(function() {
            let id = $(this).data("id");
            let token = $("input[name=_token]").val();

            // Clear the modal fields before populating them with new data
            $("#modalLabel").html('');
            $("#item_code").val('');
            $("#register").val('');
            $("#commodity_location_id").html('');
            $("#name").html('');
            $("#brand").val('');
            $("#material").val('');
            $("#year_of_purchase").val('');
            $("#school_operational_assistance_id").html('');
            $("#quantity").val('');
            $("#price").val('');
            $("#price_per_item").val('');
            $("#note").html('');

            $.ajax({
                type: "GET",
                url: "commodities/json/" + id,
                data: {
                    id: id,
                    _token: token
                },
                success: function(data) {
                    console.log(data);
                    $("#modalLabel").html(data.data.item_code);
                    $("#item_code").val(data.data.item_code);
                    $("#register").val(data.data.register);
                    $("#commodity_location_id").html(data.data.commodity_location_id);
                    $("#name").html(data.data.name);
                    $("#brand").val(data.data.brand);
                    $("#material").val(data.data.material);
                    $("#year_of_purchase").val(data.data.year_of_purchase);
                    $("#school_operational_assistance_id").html(data.data.school_operational_assistance_id);
                    $("#quantity").val(data.data.quantity);
                    $("#price").val(data.data.price);
                    $("#price_per_item").val(data.data.price_per_item);
                    $("#note").html(data.data.note);
                }
            });
        });
    });
</script>