<!--===============================================================================================-->
<script src="{{ asset('/static/js/jquery-3.7.0.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('/static/js/dataTables.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('/static/js/dataTables.bootstrap5.min.js') }}"></script>
<!--===============================================================================================-->
<!-- Select 2 Plugin -->
<script src="{{ asset('static/libs/select2/select2.min.js') }}"></script>

<script>
    $("body").on("click", ".btn-hapus", function() {
        var x = jQuery(this).attr("data-id");
        var y = jQuery(this).attr("data-handler");
        var xy = x + '-' + y;
        event.preventDefault()
        Swal.fire({
            title: 'Hapus Data ?',
            text: "Data yang dihapus tidak dapat dikembalikan !",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Data Dihapus!',
                    '',
                    'success'
                );
                document.getElementById('delete-form-' + xy).submit();
            }
        });
    })


    function fetch_data(category, binding) {
        $.ajax({
            url: '{{ url()->current() }}/' + category,
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                binding = dataResult;
            }
        });
    }

    async function find_modalData(id) {
        let bindingData;
        await $.ajax({
            url: '{{ url()->current() }}/find/' + id,
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                bindingData = dataResult;
                jQuery("#compose .modal-title").html(dataResult.dataTitle);
                jQuery("#compose").modal("toggle");
            }
        });
        
        return bindingData;
    }
</script>
