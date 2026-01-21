<script type="text/javascript">
$(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Datatable
    var table = $('#tabelRincian').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('rincian_objek.index') }}",
        columns: [
            {data: 'DT_RowIndex', className:'text-center'},
            {data: 'kode'},
            {data: 'uraian'},
            {data: 'nama_objek'},
            {data: 'action', orderable: false, searchable: false, className:'text-center'},
        ]
    });

    // Tambah data
    $('#createRincian').click(function(){
        $('#formRincian').trigger("reset");
        $('#id').val('');
        $('#modalRincian').modal('show');
    });

    // Edit data
    $('body').on('click', '.editRincian', function () {
        var id = $(this).data('id');
        $.get("/rincian_objek/edit/"+id, function (data) {
            $('#modalRincian').modal('show');
            $('#id').val(data.id);
            $('#kode').val(data.kode);
            $('#uraian').val(data.uraian);
            $('#id_objek').val(data.id_objek);
        })
    });

    // Simpan
    $('#formRincian').on('submit', function(e){
        e.preventDefault();
        $('#saveBtn').html('Menyimpan...');

        $.ajax({
            type: 'POST',
            url: "/rincian_objek/store",
            data: $(this).serialize(),
            success: function(res){
                $('#modalRincian').modal('hide');
                $('#formRincian').trigger("reset");
                $('#saveBtn').html('Simpan');
                Swal.fire('Berhasil!', res.success, 'success');
                table.draw();
            },
            error: function(){
                $('#saveBtn').html('Simpan');
                Swal.fire('Error!', 'Gagal menyimpan data.', 'error');
            }
        });
    });

    // Hapus
    $('body').on('click', '.deleteRincian', function () {
        var id = $(this).data("id");
        Swal.fire({
            title: 'Hapus Data?',
            text: "Data akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "/rincian_objek/destroy/"+id,
                    success: function(res){
                        Swal.fire('Berhasil!', res.success, 'success');
                        table.draw();
                    }
                });
            }
        });
    });

    // Import modal
    $('#importExcelBtn').click(function(){
        $('#formImportRincian').trigger("reset");
        $('#modalImportRincian').modal('show');
    });

    // Import proses
    $('#formImportRincian').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $('#btnImport').html('Import...');

        $.ajax({
            type: 'POST',
            url: "{{ route('rincian_objek.import') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){
                $('#modalImportRincian').modal('hide');
                $('#btnImport').html('Import');
                Swal.fire('Selesai!', res.success ?? res.error, res.success ? 'success' : 'error');
                table.ajax.reload();
            }
        });
    });

});
</script>
