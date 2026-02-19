@pushIf($showDatatablesSetting, 'scripts')
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
                    data: "code",
                    class: "text-center",
                },
                {
                    data: "name",
                    class: "text-left",
                },
                {
                    data: "data_type",
                    class: "text-center",
                },
                {
                    data: "category_scope",
                    class: "text-center",
                },
                {
                    data: "applies_to_subtype",
                    class: "text-center",
                },
                {
                    data: "uuid",
                    class: "text-center",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return (
                            '<button class="btn btn-success btn-edit" data-id="' + data +
                            '" data-handler="data"><i class="fa fa-pencil"></i> </button>\
                            <a class="btn btn-danger btn-hapus" data-id="' + data +
                            '" data-handler="data" href="delete/' + data + '">\
                            <i class="fa fa-trash"></i> </a> \
					        <form id="delete-form-' + data + '-data" action="{{ url()->current() }}/delete/' + data + '" method="GET" style="display: none;">\
                            </form>'
                        );
                    },
                },
            ],
        });
    });

    $("body").on("click", ".btn-add", function() {
        var url = "{{ route('master.data.attributes.add') }}";
        window.location.href = url;
    });

    $("body").on("click", ".btn-edit", function() {
        var id = jQuery(this).attr("data-id");
        
        var url = "{{ route('master.data.attributes.edit', ':id') }}";
        url = url.replace(':id', id);
        window.location.href = url;
    });

</script>
@endpushIf
