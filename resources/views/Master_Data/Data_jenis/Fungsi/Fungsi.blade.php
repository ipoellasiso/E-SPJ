<script type="text/javascript">
$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // === Render DataTable ===
    var table = $('#tabelJenis').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('jenis.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', className:'text-center'},
            {data: 'kode', name: 'kode'},
            {data: 'uraian', name: 'uraian'},
            {data: 'nama_kelompok', name: 'nama_kelompok'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className:'text-center'},
        ]
    });

    // === Tambah Data ===
    $('#createJenis').click(function(){
        $('#formJenis').trigger("reset");
        $('#id').val('');
        $('#saveBtn').val("create-jenis");
        $('#modalJenis').modal('show');
    });

    // === Edit Data ===
    $('body').on('click', '.editJenis', function () {
        var id = $(this).data('id');
        $.get("/jenis/edit/"+id, function (data) {
            $('#modalJenis').modal('show');
            $('#id').val(data.id);
            $('#kode').val(data.kode);
            $('#uraian').val(data.uraian);
            $('#id_kelompok').val(data.id_kelompok);
        })
    });

    // === Simpan Data ===
    $('body').on('submit', '#formJenis', function(e){
        e.preventDefault();
        $('#saveBtn').html('Menyimpan...');

        $.ajax({
            type: 'POST',
            url: "/jenis/store",
            data: $(this).serialize(),
            success: function(res){
                $('#formJenis').trigger("reset");
                $('#modalJenis').modal('hide');
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
    $('body').on('click', '.deleteJenis', function () {
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
                    url: "/jenis/destroy/"+id,
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
        $('#formImportJenis').trigger("reset");
        $('#modalImportJenis').modal('show');
    });

    $('#formImportJenis').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $('#btnImport').html('Mengimpor...');

        $.ajax({
            type: 'POST',
            url: "{{ route('jenis.import') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){
                $('#btnImport').html('Import');
                $('#modalImportJenis').modal('hide');
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
