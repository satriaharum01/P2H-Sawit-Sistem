    @push('scripts')
        @isset($showDatatablesSettingDetails)
            <script>
                
                $("body").on("click", ".btn-work", function() {
                    var id = jQuery(this).attr("data-id");
                    var job = jQuery(this).attr("data-job");

                    var url = "{{ route('operation.task.detail', ':id') }}?job=:jobName";
                    url = url.replace(':id', id).replace(':jobName', encodeURIComponent(job));
                    window.location.href = url;
                });
            </script>
        @endisset
        @isset($showDatatablesSetting)
            <script>
                $("body").on("click", ".btn-detail", function() {
                    var id = jQuery(this).attr("data-id");
                    var url = "{{ route('operation.task.detail', ':id') }}";
                    url = url.replace(':id', id);
                    window.location.href = url;
                });
            </script>
        @endisset
    @endpush
