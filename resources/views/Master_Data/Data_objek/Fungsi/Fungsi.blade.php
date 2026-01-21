<script type="text/javascript">
$(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Datatable
    var table = $('#tabelObjek').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('objek.index') }}",
        columns: [
            {data: 'DT_RowIndex', className:'text-center'},
            {data: 'kode'},
            {data: 'uraian'},
            {data: 'nama_jenis'},
            {data: 'action', orderable: false, searchable: false, className:'text-center'},
        ]
    });

    // Tambah
    $('#createObjek').click(function(){
        $('#id').val('');
        $('#formObjek').trigger("reset");
        $('#modalObjek').modal('show');
    });

    // Edit
    $('body').on('click', '.editObjek', function () {
        var id = $(this).data('id');
        $.get("/objek/edit/"+id, function (data) {
            $('#modalObjek').modal('show');
            $('#id').val(data.id);
            $('#kode').val(data.kode);
            $('#uraian').val(data.uraian);
            $('#id_jenis').val(data.id_jenis);
        })
    });

    // Save
    $('#formObjek').on('submit', function(e){
        e.preventDefault();
        $('#saveBtn').html('Menyimpan...');

        $.ajax({
            url: "/objek/store",
            type: "POST",
            data: $(this).serialize(),
            success: function (res) {
                $('#modalObjek').modal('hide');
                $('#formObjek')[0].reset();
                $('#saveBtn').html('Simpan');
                Swal.fire('Berhasil!', res.success, 'success')
                table.draw();
            },
            error: function () {
                $('#saveBtn').html('Simpan');
                Swal.fire('Error!', 'Terjadi kesalahan!', 'error');
            }
        });
    });

    // Delete
    $('body').on('click', '.deleteObjek', function () {

        var id = $(this).data("id");

        Swal.fire({
            title: 'Hapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/objek/destroy/"+id,
                    type: "DELETE",
                    success: function (res) {
                        Swal.fire('Terhapus!', res.success, 'success');
                        table.draw();
                    }
                });
            }
        })
    });

    // Import open modal
    $('#importExcelBtn').click(function(){
        $('#formImportObjek').trigger("reset");
        $('#modalImportObjek').modal('show');
    });

    // Import process
    $('#formImportObjek').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $('#btnImport').html('Import...');

        $.ajax({
            type: "POST",
            url: "{{ route('objek.import') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){
                $('#modalImportObjek').modal('hide');
                $('#btnImport').html('Import');
                Swal.fire('Berhasil!', res.success ?? res.error, res.success ? 'success' : 'error');
                table.draw();
            }
        });

    });

});
</script>
