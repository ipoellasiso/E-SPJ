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
    // === Datatable ===
    var table = $('#tabelBidang').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('bidang-urusan.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', className:'text-center'},
            {data: 'kode', name: 'kode'},
            {data: 'nama', name: 'nama'},
            {data: 'nama_urusan', name: 'nama_urusan'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className:'text-center'},
        ]
    });

    // === Tambah Data ===
    $('#createBidang').click(function(){
        $('#saveBtn').val("create-bidang");
        $('#id').val('');
        $('#formBidang').trigger("reset");
        $('#modalBidang').modal('show');
    });

    // === Edit Data ===
    $('body').on('click', '.editBidang', function () {
        var id = $(this).data('id');
        $.get("/bidang-urusan/edit/"+id, function (data) {
            $('#modalBidang').modal('show');
            $('#id').val(data.id);
            $('#kode').val(data.kode);
            $('#nama').val(data.nama);
            $('#id_urusan').val(data.id_urusan);
        })
    });

    // === Simpan Data ===
    $('body').on('submit', '#formBidang', function(e){
        e.preventDefault();
        $('#saveBtn').html('Menyimpan...');
        $.ajax({
            type:'POST',
            url: "/bidang-urusan/store",
            data: $(this).serialize(),
            success:function(data){
                $('#formBidang').trigger("reset");
                $('#modalBidang').modal('hide');
                $('#saveBtn').html('Simpan');
                Swal.fire('Berhasil!','Data berhasil disimpan!','success');
                table.draw();
            },
            error: function(){
                Swal.fire('Error!','Terjadi kesalahan','error');
                $('#saveBtn').html('Simpan');
            }
        });
    });

    // === Hapus Data ===
    $('body').on('click', '.deleteBidang', function () {
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
                    url: "/bidang-urusan/destroy/"+id,
                    success: function(data){
                        Swal.fire('Berhasil!','Data dihapus!','success');
                        table.draw();
                    }
                });
            }
        });
    });

    // === Import Excel ===
    $('#importExcelBtn').click(function(){
        $('#formImportExcel').trigger("reset");
        $('#modalImport').modal('show');
    });

    $('#formImportExcel').on('submit', function(e){
        e.preventDefault();

        var formData = new FormData(this);
        $('#btnImport').html('Mengimpor...');

        $.ajax({
            type: 'POST',
            url: "{{ route('bidang-urusan.import') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){
                $('#btnImport').html('Import');
                $('#modalImport').modal('hide');

                if(res.success){
                    Swal.fire('Berhasil!', res.success, 'success');
                } else {
                    Swal.fire('Gagal!', res.error, 'error');
                }

                $('#tabelBidang').DataTable().ajax.reload();
            },
            error: function(){
                $('#btnImport').html('Import');
                Swal.fire('Error!', 'Gagal memproses file', 'error');
            }
        });
    });

});
</script>   