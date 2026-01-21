<script type="text/javascript">
$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // === Render DataTable ===
    var table = $('#tabelKegiatan').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('kegiatan.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', className:'text-center'},
            {data: 'kode', name: 'kode'},
            {data: 'nama', name: 'nama'},
            {data: 'nama_program', name: 'nama_program'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className:'text-center'},
        ]
    });

    // === Tambah Data ===
    $('#createKegiatan').click(function(){
        $('#formKegiatan').trigger("reset");
        $('#id').val('');
        $('#saveBtn').val("create-kegiatan");
        $('#modalKegiatan').modal('show');
    });

    // === Edit Data ===
    $('body').on('click', '.editKegiatan', function () {
        var id = $(this).data('id');
        $.get("/kegiatan/edit/"+id, function (data) {
            $('#modalKegiatan').modal('show');
            $('#id').val(data.id);
            $('#kode').val(data.kode);
            $('#nama').val(data.nama);
            $('#id_program').val(data.id_program);
        })
    });

    // === Simpan Data ===
    $('body').on('submit', '#formKegiatan', function(e){
        e.preventDefault();
        $('#saveBtn').html('Menyimpan...');

        $.ajax({
            type: 'POST',
            url: "/kegiatan/store",
            data: $(this).serialize(),
            success: function(res){
                $('#formKegiatan').trigger("reset");
                $('#modalKegiatan').modal('hide');
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
    $('body').on('click', '.deleteKegiatan', function () {
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
                    url: "/kegiatan/destroy/"+id,
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
        $('#formImportKegiatan').trigger("reset");
        $('#modalImportKegiatan').modal('show');
    });

    $('#formImportKegiatan').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $('#btnImport').html('Mengimpor...');

        $.ajax({
            type: 'POST',
            url: "{{ route('kegiatan.import') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){
                $('#btnImport').html('Import');
                $('#modalImportKegiatan').modal('hide');
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
