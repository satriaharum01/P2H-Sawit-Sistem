    @push('scripts')
        @isset($showDatatablesSettingDetails)
            <script>
                $(function() {

                    table = $("#data-width").DataTable({
                        destroy: true,
                        searching: true,
                        ajax: '{{ url()->current() }}/json',
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex",
                                class: "text-center",
                            },
                            {
                                data: "attribute.name",
                                class: "text-center",
                            },
                            {
                                data: "value_string",
                                class: "text-center",
                            },
                            {
                                data: "value_number",
                                class: "text-center",
                            },
                            {
                                data: "value_boolean",
                                class: "text-center",
                            },
                            {
                                data: "value_date",
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
                                        '" data-handler="data"><i class="fa fa-pencil"></i> </button>\
                                                                                        <a class="btn btn-danger btn-hapus" data-id="' +
                                        data +
                                        '" data-handler="data" href="delete/' + data + '">\
                                                                                        <i class="fa fa-trash"></i> </a> \
                                                            					        <form id="delete-form-' + data +
                                        '-data" action="{{ url()->current() }}/delete/' +
                                        data + '" method="GET" style="display: none;">\
                                                                                        </form>'
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
                    jQuery("#compose-form input[name=attribute_name]").val("");
                    jQuery("#compose-form input[name=value_string]").val("");
                    jQuery("#compose-form input[name=value_number]").val("");
                    jQuery("#compose-form input[name=value_boolean]").val("");
                    jQuery("#compose-form input[name=value_date]").val("");
                }

                function set_value(value) {
                    var url = "{{ route('master.data.itemattributes.update', ':id') }}";
                    url = url.replace(':id', value.id);
                    $('#compose-form').attr('action', url);

                    jQuery("#compose-form input[name=attribute_name]").val(value.attribute.name);
                    jQuery("#compose-form input[name=value_string]").val(value.value_string);
                    jQuery("#compose-form input[name=value_number]").val(value.value_number);
                    jQuery("#compose-form input[name=value_boolean]").val(value.value_boolean);
                    jQuery("#compose-form input[name=value_date]").val(value.value_date);
                }
            </script>
        @endisset
        @isset($showDatatablesSetting)
            <script>
                $(function() {

                    table = $("#data-width").DataTable({
                        destroy: true,
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
                                data: "category",
                                class: "text-center",
                            },
                            {
                                data: "attribute_values_count",
                                class: "text-center",
                            },
                            {
                                data: "id",
                                class: "text-center",
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    return (
                                        '<button class="btn btn-info btn-detail" data-id="' + data +
                                        '" data-handler="data"><i class="fa fa-cog"></i> </button>'
                                    );
                                },
                            },
                        ],
                    });
                });

                $("body").on("click", ".btn-detail", function() {
                    var id = jQuery(this).attr("data-id");
                    var url = "{{ route('master.data.itemattributes.detail', ':id') }}";
                    url = url.replace(':id', id);
                    window.location.href = url;
                });
            </script>
        @endisset
    @endpush
