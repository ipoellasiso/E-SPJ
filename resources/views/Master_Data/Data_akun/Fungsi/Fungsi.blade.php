<script type="text/javascript">
$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // === Render DataTable ===
    var table = $('#tabelAkun').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('akun.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', className:'text-center'},
            {data: 'kode', name: 'kode'},
            {data: 'uraian', name: 'uraian'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className:'text-center'},
        ]
    });

    // === Tambah Data ===
    $('#createAkun').click(function(){
        $('#formAkun').trigger("reset");
        $('#id').val('');
        $('#saveBtn').val("create-akun");
        $('#modalAkun').modal('show');
    });

    // === Edit Data ===
    $('body').on('click', '.editAkun', function () {
        var id = $(this).data('id');
        $.get("/akun/edit/"+id, function (data) {
            $('#modalAkun').modal('show');
            $('#id').val(data.id);
            $('#kode').val(data.kode);
            $('#uraian').val(data.uraian);
        })
    });

    // === Simpan Data ===
    $('body').on('submit', '#formAkun', function(e){
        e.preventDefault();
        $('#saveBtn').html('Menyimpan...');

        $.ajax({
            type: 'POST',
            url: "/akun/store",
            data: $(this).serialize(),
            success: function(res){
                $('#formAkun').trigger("reset");
                $('#modalAkun').modal('hide');
                $('#saveBtn').html('Simpan');
                Swal.fire('Berhasil!', res.success, 'success');
                table.draw();
            },
            error: function(){
                $('#saveBtn').html('Simpan');
                Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan data.', 'error');
            }
        });
    });

    // === Hapus Data ===
    $('body').on('click', '.deleteAkun', function () {
        var id = $(this).data("id");

        Swal.fire({
            title: 'Hapus Data?',
            text: "Data akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "/akun/destroy/"+id,
                    success: function(res){
                        Swal.fire('Berhasil!', res.success, 'success');
                        table.draw();
                    }
                });
            }
        });
    });

    // === Import Excel ===
    $('#importExcelBtn').click(function(){
        $('#formImportAkun').trigger("reset");
        $('#modalImportAkun').modal('show');
    });

    $('#formImportAkun').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $('#btnImport').html('Mengimpor...');

        $.ajax({
            type: 'POST',
            url: "{{ route('akun.import') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){
                $('#btnImport').html('Import');
                $('#modalImportAkun').modal('hide');
                if(res.success){
                    Swal.fire('Berhasil!', res.success, 'success');
                } else {
                    Swal.fire('Gagal!', res.error, 'error');
                }
                table.ajax.reload();
            },
            error: function(){
                $('#btnImport').html('Import');
                Swal.fire('Error!', 'File tidak valid atau gagal diproses.', 'error');
            }
        });
    });

});
</script>
