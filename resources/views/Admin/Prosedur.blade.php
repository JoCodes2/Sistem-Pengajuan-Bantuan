@extends('Layouts.Base')
@section('content')
    <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h3 class="m-0 font-weight-bold"><i class="fa-solid fa-book pr-2"></i>Prosedur</h3>
            <button type="button" class="btn btn-outline-primary ml-auto" id="myBtn">
                <i class="fa-solid fa-plus pr-2"></i>Tambah
            </button>
        </div>

        <div class="card-body">
            <table id="loadData" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>File Prosedur</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <!-- Data pengguna akan dimuat di sini -->
                </tbody>
            </table>
        </div>

        <!-- Modal Form -->
        <div class="modal fade" id="formDataModal" tabindex="-1" aria-labelledby="formDataModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formDataModalLabel">Prosedur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="upsertData" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="id" name="id">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Masukkan nama prosedur">
                                <small id="name-error" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="file_prosedur">File Prosedur</label>
                                <input type="file" class="form-control" name="file_prosedur" id="file_prosedur"
                                    accept="application/pdf">
                                <small id="file_prosedur-error" class="text-danger"></small>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="simpanData">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Tampilkan modal form
            $('#myBtn').click(function() {
                $('#upsertData')[0].reset();
                $('.text-danger').text('');
                $('#id').val('');
                var modal = new bootstrap.Modal(document.getElementById('formDataModal'));
                modal.show();
            });

            function getData() {
                $.ajax({
                    url: '/v1/prosedur',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);

                        if ($.fn.DataTable.isDataTable('#loadData')) {
                            $('#loadData').DataTable().clear().destroy();
                        }

                        let tableBody = '';
                        $.each(response.data, function(index, item) {
                            tableBody += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.name || 'Tidak ada nama'}</td>
                        <td>
                            <a href='/uploads/file-prsedur/${item.file_prosedur}'
                               download='${item.file_prosedur}'
                               class='btn btn-outline-primary'>
                                <i class='fa-solid fa-download pr-2'></i>Unduh
                            </a>
                        </td>
                        <td>
                            <button type='button'
                                    class='btn btn-outline-danger delete-confirm'
                                    data-id='${item.id}'>
                                <i class='fa fa-trash'></i>
                            </button>
                        </td>
                    </tr>`;
                        });

                        $('#tbody').html(tableBody);

                        $('#loadData').DataTable({
                            responsive: true,
                            lengthChange: true,
                            lengthMenu: [10, 20, 30, 40, 50],
                            autoWidth: false,
                            language: {
                                search: "Cari:",
                                lengthMenu: "Tampilkan _MENU_ data",
                                info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                                paginate: {
                                    first: "Awal",
                                    last: "Akhir",
                                    next: "Berikutnya",
                                    previous: "Sebelumnya"
                                }
                            }
                        });
                    },
                    error: function() {
                        console.log("Gagal mengambil data dari server");
                    }
                });
            }

            getData();

            // CSRF Token setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Simpan atau update data
            $('#simpanData').click(function(e) {
                e.preventDefault();
                $('.text-danger').text('');
                let formData = new FormData($('#upsertData')[0]);

                $.ajax({
                    type: 'POST',
                    url: '/v1/prosedur/create',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);

                        if (response.code === 422) {
                            $.each(response.errors, function(key, value) {
                                $(`#${key}-error`).text(value[0]);
                            });
                        } else if (response.code === 200) {
                            Swal.fire('Berhasil!', 'Data berhasil disimpan!', 'success');
                            $('#formDataModal').modal('hide');
                            getData();
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan!', 'error');
                    }
                });
            });

            // Hapus data
            $(document).on('click', '.delete-confirm', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Konfirmasi!',
                    text: 'Apakah Anda yakin ingin menghapus data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: `/v1/prosedur/delete/${id}`,
                            success: function(response) {
                                if (response.code === 200) {
                                    Swal.fire('Berhasil!', 'Data berhasil dihapus!',
                                        'success');
                                    getData();
                                }
                            },
                            error: function() {
                                Swal.fire('Error!', 'Terjadi kesalahan!', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
