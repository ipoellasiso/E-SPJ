<script type="text/javascript">
$(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // DataTables
    var table = $('#tabelSubRincian').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('sub_rincian_objek.index') }}",
        columns: [
            {data: 'DT_RowIndex', className:'text-center'},
            {data: 'kode'},
            {data: 'uraian'},
            {data: 'nama_rincian'},
            {data: 'action', orderable: false, searchable: false, className:'text-center'},
        ]
    });

    // Tambah data
    $('#createSubRincian').click(function(){
        $('#formSubRincian').trigger("reset");
        $('#id').val('');
        $('#modalSubRincian').modal('show');
    });

    // Edit data
    $('body').on('click', '.editSub', function () {
        var id = $(this).data('id');
        $.get("/sub_rincian_objek/edit/"+id, function (data) {
            $('#modalSubRincian').modal('show');
            $('#id').val(data.id);
            $('#kode').val(data.kode);
            $('#uraian').val(data.uraian);
            $('#id_rincian_objek').val(data.id_rincian_objek);
        })
    });

    // Simpan data
    $('#formSubRincian').on('submit', function(e){
        e.preventDefault();
        $('#saveBtn').html('Menyimpan...');

        $.ajax({
            type: 'POST',
            url: "/sub_rincian_objek/store",
            data: $(this).serialize(),
            success: function(res){
                $('#modalSubRincian').modal('hide');
                $('#formSubRincian').trigger("reset");
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

    // Hapus data
    $('body').on('click', '.deleteSub', function () {
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
                    url: "/sub_rincian_objek/destroy/"+id,
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
        $('#formImportSubRincian').trigger("reset");
        $('#modalImportSubRincian').modal('show');
    });

    // Import proses
    $('#formImportSubRincian').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $('#btnImport').html('Import...');

        $.ajax({
            type: 'POST',
            url: "{{ route('sub_rincian_objek.import') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){
                $('#modalImportSubRincian').modal('hide');
                $('#btnImport').html('Import');
                Swal.fire('Selesai!', res.success ?? res.error, res.success ? 'success' : 'error');
                table.ajax.reload();
            }
        });
    });

});
</script>
