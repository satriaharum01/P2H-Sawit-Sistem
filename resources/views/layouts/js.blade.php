<!--===============================================================================================-->
<script src="{{ asset('/static/js/jquery-3.7.0.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('/static/js/dataTables.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('/static/js/dataTables.bootstrap5.min.js') }}"></script>
<!--===============================================================================================-->
<!-- Select 2 Plugin -->
<script src="{{ asset('static/libs/select2/select2.min.js') }}"></script>
<!-- SweetAlert 2 -->
<script src="{{ asset('static/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
<!-- GLight Box -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/js/glightbox.min.js"></script>

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

    function showToast(message, type = 'success') {
        const toastEl = document.getElementById('liveToast');
        const toastBody = document.getElementById('toastMessage');
        const toastIcon = document.getElementById('toastIcon');

        // 1. Isi Pesan
        toastBody.innerText = message;

        // 2. Atur Warna Background & Icon berdasarkan Type
        // Reset background classes
        toastEl.classList.remove('bg-success', 'bg-danger', 'bg-warning', 'bg-info');

        if (type === 'success') {
            toastEl.classList.add('bg-success');
            toastIcon.className = 'bx bx-check-circle me-2 fs-5';
        } else if (type === 'error' || type === 'danger') {
            toastEl.classList.add('bg-danger');
            toastIcon.className = 'bx bx-error-circle me-2 fs-5';
        } else if (type === 'warning') {
            toastEl.classList.add('bg-warning', 'text-dark'); // Warning biasanya teks hitam
            toastIcon.className = 'bx bx-warning me-2 fs-5';
        } else {
            toastEl.classList.add('bg-info');
            toastIcon.className = 'bx bx-info-circle me-2 fs-5';
        }

        // 3. Tampilkan Toast
        const toast = new bootstrap.Toast(toastEl, {
            delay: 4000
        });
        toast.show();
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const lightbox = GLightbox({
            selector: '.glightbox'
        });
    });
</script>
@if (session('message'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let message = "{{ session('message') }}";
            let type = "{{ session('info', 'success') }}";

            let title = 'Info';
            if (type === 'error') title = 'Error';
            if (type === 'warning') title = 'Warning';

            showToast(message, type, title);
        });
    </script>
@endif
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gabungkan semua pesan error menjadi satu string dengan baris baru
            let errorMessages = "";
            @foreach ($errors->all() as $error)
                errorMessages += "• {{ $error }}\n";
            @endforeach

            showToast(errorMessages, 'error', 'Validasi Gagal');
        });
    </script>
@endif
