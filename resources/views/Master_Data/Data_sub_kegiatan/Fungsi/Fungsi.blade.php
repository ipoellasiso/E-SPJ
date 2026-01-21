<script type="text/javascript">
$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // === Render DataTable ===
    var table = $('#tabelSubKegiatan').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('sub-kegiatan.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', className:'text-center'},
            {data: 'kode', name: 'kode'},
            {data: 'nama', name: 'nama'},
            {data: 'nama_kegiatan', name: 'nama_kegiatan'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className:'text-center'},
        ]
    });

    // === Tambah Data ===
    $('#createSubKegiatan').click(function(){
        $('#formSubKegiatan').trigger("reset");
        $('#id').val('');
        $('#saveBtn').val("create-sub");
        $('#modalSubKegiatan').modal('show');
    });

    // === Edit Data ===
    $('body').on('click', '.editSubKegiatan', function () {
        var id = $(this).data('id');
        $.get("/sub-kegiatan/edit/"+id, function (data) {
            $('#modalSubKegiatan').modal('show');
            $('#id').val(data.id);
            $('#kode').val(data.kode);
            $('#nama').val(data.nama);
            $('#id_kegiatan').val(data.id_kegiatan);
        })
    });

    // === Simpan Data ===
    $('body').on('submit', '#formSubKegiatan', function(e){
        e.preventDefault();
        $('#saveBtn').html('Menyimpan...');

        $.ajax({
            type: 'POST',
            url: "/sub-kegiatan/store",
            data: $(this).serialize(),
            success: function(res){
                $('#formSubKegiatan').trigger("reset");
                $('#modalSubKegiatan').modal('hide');
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
    $('body').on('click', '.deleteSubKegiatan', function () {
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
                    url: "/sub-kegiatan/destroy/"+id,
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
        $('#formImportSubKegiatan').trigger("reset");
        $('#modalImportSubKegiatan').modal('show');
    });

    $('#formImportSubKegiatan').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $('#btnImport').html('Mengimpor...');

        $.ajax({
            type: 'POST',
            url: "{{ route('sub-kegiatan.import') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){
                $('#btnImport').html('Import');
                $('#modalImportSubKegiatan').modal('hide');
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
