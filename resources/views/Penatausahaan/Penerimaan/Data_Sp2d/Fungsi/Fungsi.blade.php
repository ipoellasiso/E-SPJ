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
    $(document).ready(function () {
        let table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('sp2d.data') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'nomor_spm', name: 'nomor_spm'},
                {data: 'tanggal_sp2d', name: 'tanggal_sp2d'},
                {data: 'nomor_sp2d', name: 'nomor_sp2d'},
                {data: 'nama_skpd', name: 'nama_skpd'},
                {data: 'nama_pihak_ketiga', name: 'nama_pihak_ketiga'},
                {data: 'keterangan_sp2d', name: 'keterangan_sp2d'},
                {data: 'jenis', name: 'jenis'},
                {data: 'nilai_sp2d', name: 'nilai_sp2d', className: 'text-end'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                zeroRecords: "Tidak ada data ditemukan",
                processing: "🔄 Memuat data..."
            }
        });
    });

});

// =============== 🧠 FUNGSI GLOBAL DI LUAR $(document).ready) ===============

// Format Rupiah
function formatRupiah(value) {
  if (!value) return 'Rp0';
  return 'Rp' + parseFloat(value).toLocaleString('id-ID', {minimumFractionDigits: 2});
}

function showDetail(id) {
  $.ajax({
    url: "/sp2d/" + id,
    type: "GET",
    success: function(data) {
      // HEADER
      let headerHtml = `
        <div class="row">
          <div class="col-md-6">
            <p><b>Nomor SP2D:</b> ${data.nomor_sp2d}</p>
            <p><b>Nomor SPM:</b> ${data.nomor_spm}</p>
            <p><b>Tanggal SP2D:</b> ${data.tanggal_sp2d}</p>
            <p><b>Tanggal SPM:</b> ${data.tanggal_spm}</p>
          </div>
          <div class="col-md-6">
            <p><b>SKPD:</b> ${data.nama_skpd}</p>
            <p><b>Penerima:</b> ${data.nama_pihak_ketiga}</p>
            <p><b>Bank:</b> ${data.nama_bank}</p>
            <p><b>Keterangan:</b> ${data.keterangan_sp2d}</p>
          </div>
        </div>
        <hr>
        <p><b>Nilai SP2D:</b> <span class="text-primary">${formatRupiah(data.nilai_sp2d)}</span></p>
      `;
      $('#sp2dHeader').html(headerHtml);

      // REKENING BELANJA
      let totalBelanja = 0;
      let belanjaRows = '';
      data.belanja.forEach((b, i) => {
        totalBelanja += parseFloat(b.nilai);
        belanjaRows += `
          <tr>
          <td>${i+1}</td>
          <td>${b.norekening ?? '-'}</td>
          <td>${b.uraian ?? '-'}</td>
          <td class="text-end">
            <input type="text"
                  class="form-control form-control-sm text-end input-nilai"
                  data-id="${b.id}"
                  value="${new Intl.NumberFormat('id-ID').format(b.nilai)}">
          </td>
        </tr>`;
      });
      $('#tblBelanja tbody').html(belanjaRows || '<tr><td colspan="4" class="text-center text-muted">Tidak ada data</td></tr>');
      $('#totalBelanja').text(formatRupiah(totalBelanja));

      // POTONGAN
      let totalPotongan = 0;
      let potonganRows = '';
      data.potongan.forEach((p, i) => {
        totalPotongan += parseFloat(p.nilai_pajak);
        potonganRows += `
            <tr>
            <td>${i+1}</td>
            <td>${p.jenis_pajak ?? '-'}</td>
            <td class="text-end">${formatRupiah(p.nilai_pajak)}</td>
            <td>${p.ebilling ?? '-'}</td>
            </tr>`;
        });
      $('#tblPotongan tbody').html(potonganRows || '<tr><td colspan="4" class="text-center text-muted">Tidak ada data</td></tr>');
      $('#totalPotongan').text(formatRupiah(totalPotongan));

      // SHOW MODAL
      $('#modalDetailSp2d').modal('show');
    },
    error: function(xhr) {
      Swal.fire('Error', 'Gagal memuat detail SP2D', 'error');
      console.error(xhr.responseText);
    }
  });
}

    // =====================================================
    // 🧠 Edit nilai rekening belanja inline (fix lengkap)
    // =====================================================

    // 🟢 Saat mengetik: format angka ribuan dan jaga posisi kursor
    $(document).on('input', '.input-nilai', function (e) {
        let input = e.target;
        let cursorPosition = input.selectionStart;

        // Ambil angka murni
        let rawValue = input.value.replace(/\D/g, '');
        if (rawValue === '') rawValue = '0';

        // Hitung posisi angka sebelum format
        let beforeLength = input.value.slice(0, cursorPosition).replace(/\D/g, '').length;

        // Format angka jadi ribuan (1.000.000)
        let formatted = new Intl.NumberFormat('id-ID').format(parseInt(rawValue));
        input.value = formatted;

        // Hitung posisi baru kursor setelah diformat
        let afterLength = 0;
        for (let i = 0; i < input.value.length && beforeLength > 0; i++) {
            if (/\d/.test(input.value[i])) afterLength++;
            if (afterLength === beforeLength) {
                cursorPosition = i + 1;
                break;
            }
        }
        input.setSelectionRange(cursorPosition, cursorPosition);
    });

    // 🟢 Saat kehilangan fokus (blur): simpan ke server via AJAX
    $(document).on('blur', '.input-nilai', function () {
        let input = $(this);
        let id = input.data('id');
        let nilai = input.val();

        $.ajax({
            url: "{{ route('rekening.updateNilai') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                nilai: nilai
            },
            success: function (res) {
                if (res.success) {
                    input.css('background-color', '#d4edda'); // hijau sukses
                    setTimeout(() => input.css('background-color', ''), 800);
                    updateTotalBelanja();
                } else {
                    input.css('background-color', '#f8d7da'); // merah gagal
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                input.css('background-color', '#f8d7da');
            }
        });
    });

    // 🟢 Hitung ulang total belanja otomatis
    function updateTotalBelanja() {
        let total = 0;
        $('.input-nilai').each(function () {
            let val = $(this).val().replace(/\D/g, '');
            total += parseInt(val || 0);
        });
        $('#totalBelanja').text('Rp' + new Intl.NumberFormat('id-ID').format(total));
    }




// (Opsional) Format rupiah realtime saat diketik
$(document).on('input', '.editable-nilai', function () {
    let raw = $(this).text().replace(/\D/g, '');
    $(this).text('Rp' + new Intl.NumberFormat('id-ID').format(raw));
});


// HAPUS SP2D
function deleteSp2d(id) {
    Swal.fire({
        title: "Yakin ingin hapus?",
        text: "Data SP2D dan semua relasinya akan dihapus permanen.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/sp2d/' + id,
                type: 'DELETE',
                data: {_token: '{{ csrf_token() }}'},
                success: function (res) {
                    Swal.fire('Berhasil', res.message, 'success');
                    $('#data-table').DataTable().ajax.reload();
                },
                error: function () {
                    Swal.fire('Error', 'Gagal menghapus data SP2D', 'error');
                }
            });
        }
    });
}

$(function(){

    // 🟢 Buka Modal Upload
    $('#btnUploadSp2d').on('click', function(){
        $('#modalUploadSp2d').modal('show');
    });

    // 🟢 Proses Upload AJAX
    $('#uploadForm').on('submit', function(e){
        e.preventDefault();

        let file = $('input[name="pdf"]')[0].files[0];
        if (!file) {
            Swal.fire('Oops!', 'Silakan pilih file PDF terlebih dahulu.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Upload',
            text: 'Apakah Anda yakin ingin mengunggah dokumen SP2D ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Upload Sekarang',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                startUpload();
            }
        });
    });

    // 🔄 Fungsi Upload
    function startUpload() {
        let formData = new FormData($('#uploadForm')[0]);
        let progressBar = $('.progress');
        let bar = $('.progress-bar');

        progressBar.show();
        bar.removeClass('bg-danger bg-success').css('width', '0%').text('0%');

        $.ajax({
            xhr: function() {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(e) {
                    if (e.lengthComputable) {
                        let percent = Math.round((e.loaded / e.total) * 100);
                        bar.css('width', percent + '%').text(percent + '%');
                    }
                });
                return xhr;
            },
            url: "{{ route('sp2d.upload') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                Swal.fire({
                    title: 'Mengunggah Dokumen...',
                    html: '<b>File sedang diproses, harap tunggu sebentar...</b>',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
            },
            success: function(res) {
                Swal.close();
                if (res.success) {
                    bar.addClass('bg-success').text('Selesai');
                    Swal.fire({
                        icon: 'success',
                        title: 'Upload Berhasil 🎉',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false,
                        willClose: () => {
                            $('#modalUploadSp2d').modal('hide');
                            $('#uploadForm')[0].reset();
                            $('.progress').hide();
                            $('#data-table').DataTable().ajax.reload(); // 🔄 reload data SP2D
                            $('#table-log').DataTable().ajax.reload(); // 🔄 Refresh log upload
                        }
                    });
                } else {
                    bar.addClass('bg-danger').text('Gagal');
                    Swal.fire('Gagal Upload', res.message, 'error');
                }
            },
            error: function(xhr){
                Swal.close();
                bar.addClass('bg-danger').text('Error');
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Upload!',
                    text: 'Terjadi kesalahan saat memproses file.'
                });
                console.log(xhr.responseText);
            }
        });
    }
}); 

</script>
