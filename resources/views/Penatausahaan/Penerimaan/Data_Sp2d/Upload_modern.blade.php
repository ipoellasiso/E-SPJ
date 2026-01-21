@extends('Template.Layout')
@section('content')

<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fa fa-upload"></i> Upload Dokumen SP2D (PDF)</h5>
        </div>
        <div class="card-body">
            <form id="uploadForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pilih File PDF</label>
                    <input type="file" name="pdf" class="form-control" accept="application/pdf" required>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fa fa-cloud-upload-alt"></i> Upload
                </button>

                <div class="progress mt-3" style="height: 20px; display:none;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%">0%</div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function(){
    $('#uploadForm').on('submit', function(e){
        e.preventDefault();

        let file = $('input[name="pdf"]')[0].files[0];
        if (!file) {
            Swal.fire('Oops!', 'Silakan pilih file PDF terlebih dahulu.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Upload',
            text: 'Apakah Anda yakin ingin mengunggah dokumen SP2D ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Upload Sekarang',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                startUpload();
            }
        });
    });

    function startUpload() {
        let formData = new FormData($('#uploadForm')[0]);
        let progressBar = $('.progress');
        let bar = $('.progress-bar');

        progressBar.show();
        bar.removeClass('bg-danger bg-success').css('width', '0%').text('0%');

        $.ajax({
    url: "{{ route('sp2d.upload') }}", // ✅ route POST -> /upload-pdf/proses
    type: "POST",
    data: new FormData($('#uploadForm')[0]),
    processData: false,
    contentType: false,
    beforeSend: function() {
        Swal.fire({
            title: 'Mengunggah Dokumen...',
            html: '<b>File sedang diproses. Harap tunggu sebentar...</b>',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });
    },
    success: function(res) {
        Swal.close();
        if (res.success) {
            Swal.fire({
                icon: 'success',
                title: 'Upload Berhasil 🎉',
                text: res.message,
                confirmButtonText: 'Lihat Data SP2D'
            }).then(() => {
                // ✅ redirect setelah sukses
                window.location.href = "{{ route('sp2d.index') }}";
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Upload!',
                text: res.message
            });
        }
    },
    error: function(xhr) {
        Swal.close();
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan!',
            text: 'Periksa koneksi atau format file PDF.'
        });
        console.log(xhr.responseText);
    }
});

    }
});
</script>
@endpush
