<script type="text/javascript">
    $(function () {

      /*------------------------------------------
       --------------------------------------------
       Pass Header Token
       --------------------------------------------
       --------------------------------------------*/
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

      /*------------------------------------------
      --------------------------------------------
      Render DataTable
      --------------------------------------------
      --------------------------------------------*/
    // === Render DataTable ===
    var table = $('#tabelProgram').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('program.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', className:'text-center'},
            {data: 'kode', name: 'kode'},
            {data: 'nama', name: 'nama'},
            {data: 'nama_bidang', name: 'nama_bidang'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className:'text-center'},
        ]
    });

    // === Tambah Data ===
    $('#createProgram').click(function(){
        $('#formProgram').trigger("reset");
        $('#id').val('');
        $('#saveBtn').val("create-program");
        $('#modalProgram').modal('show');
    });

    // === Edit Data ===
    $('body').on('click', '.editProgram', function () {
        var id = $(this).data('id');
        $.get("/program/edit/"+id, function (data) {
            $('#modalProgram').modal('show');
            $('#id').val(data.id);
            $('#kode').val(data.kode);
            $('#nama').val(data.nama);
            $('#id_unit').val(data.id_unit);
        })
    });

    // === Simpan Data ===
    $('body').on('submit', '#formProgram', function(e){
        e.preventDefault();
        $('#saveBtn').html('Menyimpan...');

        $.ajax({
            type: 'POST',
            url: "/program/store",
            data: $(this).serialize(),
            success: function(res){
                $('#formProgram').trigger("reset");
                $('#modalProgram').modal('hide');
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
    $('body').on('click', '.deleteProgram', function () {
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
                    url: "/program/destroy/"+id,
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
        $('#formImportProgram').trigger("reset");
        $('#modalImportProgram').modal('show');
    });

    $('#formImportProgram').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $('#btnImport').html('Mengimpor...');

        $.ajax({
            type: 'POST',
            url: "{{ route('program.import') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){
                $('#btnImport').html('Import');
                $('#modalImportProgram').modal('hide');
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