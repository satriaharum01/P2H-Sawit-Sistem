@pushIf($showDatatablesSetting, 'scripts')
<script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
<script>
    $(function() {

        table = $("#data-width").DataTable({
            searching: true,
            ajax: '{{ url()->current() }}/json',
            columns: [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    class: "text-center",
                },
                {
                    data: "config_key",
                    class: "text-center",
                },
                {
                    data: "config_value",
                    class: "text-center",
                },
                {
                    data: "id",
                    class: "text-center",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return (
                            '<button class="btn btn-success btn-edit" data-id="' + data +
                            '" data-handler="data"><i class="fa fa-pencil"></i> </button>'
                        );
                    },
                },
            ],
        });
    });

    $("body").on("click", ".btn-edit", async function() {
        var Id = jQuery(this).attr("data-id");
        const data = await find_modalData(Id);

        set_value(data);
    });

    $("body").on("click", ".btn-simpan", function() {
        Swal.fire("Data Disimpan!", "", "success");
    });

    function kosongkan() {
        jQuery("#compose-form input[name=config_key]").val("");
        jQuery("#compose-form input[name=config_value]").val("");
    }

    function set_value(value) {

        jQuery("#compose-form input[name=config_key]").val(value.config_key);
        jQuery("#compose-form input[name=config_value]").val(value.config_value);
    }
</script>
@endpushIf
