<script>
$(function() {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    let id_anggaran = "{{ $anggaran->id }}";

    // Tambah Rincian
    $('#createRincian').click(function() {
        $('#formRincian').trigger("reset");
        $('#id').val('');
        $('#modalRincian').modal('show');
    });

    // Simpan / Update
    $('#formRincian').submit(function(e) {
        e.preventDefault();
        $('#saveBtn').html('Menyimpan...');
        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: '/rka/' + id_anggaran + '/rincian/store',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                $('#modalRincian').modal('hide');
                $('#saveBtn').html('Simpan');

                updateTotalPagu(id_anggaran); // update pagu langsung
                Swal.fire('Berhasil!', 'Rincian berhasil disimpan.', 'success');

                // Ambil ulang tabel via AJAX tanpa reload halaman penuh
                $('#tabelRincian tbody').load(window.location.href + ' #tabelRincian tbody>*');
            },
            error: function() {
                Swal.fire('Error', 'Gagal menyimpan data.', 'error');
                $('#saveBtn').html('Simpan');
            }
        });
    });

    // Edit
    $('body').on('click', '.editRincian', function() {
        let id = $(this).data('id');
        $.get('/rka/rincian/' + id + '/edit', function(data) {
            $('#modalRincian').modal('show');
            $('#id').val(data.id);
            $('#kode_rekening').val(data.kode_rekening);
            $('#uraian').val(data.uraian);
            $('#koefisien').val(data.koefisien);
            $('#satuan').val(data.satuan);
            $('#harga').val(data.harga);
            $('#jumlah').val(data.jumlah);

            if (data.lock === true) {
                $('#formRincian input').prop('readonly', true);
                $('#saveBtn').hide();
                return;
            } else {
                $('#formRincian input').prop('readonly', false);
                $('#saveBtn').show();
            }

        });
    });

    // Hapus
    $('body').on('click', '.deleteRincian', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Hapus Rincian?',
            text: "Data ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: '/rka/rincian/' + id + '/destroy',
                    success: function() {
                        updateTotalPagu(id_anggaran); // update pagu langsung
                        Swal.fire('Berhasil!', 'Data berhasil dihapus.', 'success');
                        $('#tabelRincian tbody').load(window.location.href + ' #tabelRincian tbody>*');
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal menghapus data.', 'error');
                    }
                });
            }
        });
    });

    // Hitung jumlah otomatis saat user ubah harga / koefisien
    $('#harga, #koefisien').on('input', function () {
        let harga = parseFloat($('#harga').val()) || 0;
        let koef = parseFloat($('#koefisien').val()) || 0;
        let total = harga * koef;
        $('#jumlah').val(total);
    });

    // sembunyikan semua anak saat load pertama
    // $('#tabelRincian tbody tr[data-level!="0"]').addClass('collapsed-row');

    // toggle expand
    $('body').on('click', '.toggle-child', function() {
        const kode = $(this).data('target');
        const icon = $(this).find('i');
        icon.toggleClass('bi-caret-right-fill bi-caret-down-fill');

        // toggle anak langsung
        $('tr[data-parent="' + kode + '"]').toggleClass('collapsed-row');
    });

    // === Import Excel Rincian ===
    $('#importRincianBtn').click(function() {
        $('#formImportRincian').trigger('reset');
        $('#modalImportRincian').modal('show');
    });

    $('#formImportRincian').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        let id_anggaran = "{{ $anggaran->id }}";

        $.ajax({
            type: 'POST',
            url: '/rka/' + id_anggaran + '/rincian/import',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                Swal.fire({
                    title: 'Sedang mengimpor...',
                    text: 'Harap tunggu beberapa saat.',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
            },
            success: function(res) {
                Swal.close();
                Swal.fire('Berhasil!', res.message, 'success');
                location.reload();
            },
            error: function(err) {
                Swal.close();
                Swal.fire('Gagal!', 'Terjadi kesalahan saat import.', 'error');
            }
        });
    });

    $(document).ready(function() {
        let showOnlyErrors = false;

        $('#toggleErrorFilter').click(function() {
            showOnlyErrors = !showOnlyErrors;

            if (showOnlyErrors) {
                $(this).removeClass('btn-outline-danger').addClass('btn-danger')
                    .html('<i class="bi bi-x-circle"></i> Tampilkan Semua');

                // hanya sembunyikan baris TANPA .rek-error di mana pun dalam tr
                $('tbody tr').each(function() {
                    if ($(this).find('.rek-error').length === 0) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });

            } else {
                $(this).removeClass('btn-danger').addClass('btn-outline-danger')
                    .html('<i class="bi bi-filter-circle"></i> Tampilkan Hanya Kode Error');
                $('tbody tr').show();
            }
        });
    });

    function formatRupiah(angka) {
        return 'Rp' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function animateNumber(oldValue, newValue, duration = 900) {
        const start = oldValue;
        const end = newValue;
        const range = end - start;
        const stepTime = Math.abs(Math.floor(duration / 60)); // smooth fps

        let startTime = null;
        const $el = $('#totalPagu');

        // Ganti warna sesuai perubahan
        $el.removeClass('text-success text-danger');
        if (end > start) {
            $el.addClass('text-success');
        } else if (end < start) {
            $el.addClass('text-danger');
        }

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            const progress = Math.min((timestamp - startTime) / duration, 1);
            const easedProgress = 1 - Math.pow(1 - progress, 3); // easeOutCubic
            const currentValue = Math.floor(start + range * easedProgress);
            $el.text(formatRupiah(currentValue));

            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                // Kembalikan warna ke normal setelah 1 detik
                setTimeout(() => {
                    $el.removeClass('text-success text-danger').addClass('text-dark');
                }, 1000);
            }
        }

        requestAnimationFrame(step);
    }

    function updateTotalPagu(id_anggaran) {
        const oldValue = parseInt($('#totalPagu').text().replace(/[^\d]/g, '')) || 0;

        $.get(`/rka/${id_anggaran}/pagu`, function(res) {
            if (res.total !== undefined) {
                animateNumber(oldValue, res.total);
            }
        });
    }


});

</script>
