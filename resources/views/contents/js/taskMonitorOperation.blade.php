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
                                data: "user.name",
                                class: "text-center",
                            },
                            {
                                data: "frequency",
                                class: "text-center",
                            },
                            {
                                data: "mulai",
                                class: "text-center",
                            },
                            {
                                data: "berakhir",
                                class: "text-center",
                            },
                            {
                                data: "is_active",
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

                $("body").on("click", ".btn-add", async function() {
                    var url = "{{ route('operation.p2h.task.add') }}";
                    
                    window.location.href = url;
                });

                $("body").on("click", ".btn-edit", function() {
                    var id = jQuery(this).attr("data-id");

                    var url = "{{ route('operation.p2h.task.edit', ':id') }}";
                    url = url.replace(':id', id);
                    window.location.href = url;
                });
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
                                data: "assignments_count",
                                class: "text-center",
                            },
                            {
                                data: "uuid",
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
                    var url = "{{ route('operation.p2h.task.detail', ':id') }}";
                    url = url.replace(':id', id);
                    window.location.href = url;
                });
            </script>
        @endisset
    @endpush
