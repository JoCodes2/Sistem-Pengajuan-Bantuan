@extends('Layouts.Base')
@section('content')
    <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h3 class="m-0 font-weight-bold "><i class="fa-solid fa-book pr-2"></i>Prosedur</h3>
            <button type="button" class="btn btn-outline-primary ml-auto" id="myBtn">
                <i class="fa-solid fa-plus pr-2"></i>Tambah
            </button>
        </div>

        <!-- /.card-header -->
        <div class="card-body">
            <table id="loadData" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Prosedur</th>
                        <th>Actions</th>
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
                        <form id="upsertData" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="id" name="id">
                            <div class="form-group">
                                <label for="file_produk_hukum">File Produk Hukum</label>
                                <input type="file" class="form-control" name="file_produk_hukum" id="file_produk_hukum"
                                    accept="application/pdf">
                                <small id="file_produk_hukum-error" class="text-danger"></small>
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
            // Menampilkan modal form saat tombol "Tambah" diklik
            $('#myBtn').click(function() {
                $('#upsertData')[0].reset(); // Reset input form
                $('.text-danger').text(''); // Hapus pesan error lama
                $('#id').val(''); // Kosongkan input ID
                var modal = new bootstrap.Modal(document.getElementById('formDataModal'));
                modal.show();
            });

            // Mengambil dan menampilkan data produk hukum ke DataTable
            function getData() {
                $.ajax({
                    url: '/v1/prosedur',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        let tableBody = "";
                        $.each(response.data, function(index, item) {
                            tableBody += "<tr>";
                            tableBody += "<td>" + (index + 1) + "</td>";
                            tableBody += "<td>";
                            tableBody += "<a href='/uploads/file-prosedur/" + item
                                .file_prosedur + "' download='" + item.file_prosedur +
                                "' class='btn btn-outline-primary'><i class='fa-solid fa-eye pr-2'></i>Detail</a>";
                            tableBody +=
                                "<button type='button' class='btn btn-outline-danger delete-confirm' data-id='" +
                                item.id + "'><i class='fa fa-trash'></i></button>";
                            tableBody += "</td>";
                            tableBody += "</tr>";
                        });
                        $("#loadData tbody").html(tableBody);
                        $('#loadData').DataTable({
                            "responsive": true,
                            "lengthChange": true,
                            "lengthMenu": [10, 20, 30, 40, 50],
                            "autoWidth": false,
                        });
                    },
                    error: function() {
                        console.log("Gagal mengambil data");
                    }
                });
            }
            getData();

            // Pengaturan CSRF Token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Menyimpan data baru atau memperbarui data
            $('#simpanData').click(function(e) {
                $('.text-danger').text(''); // Menghapus pesan error
                e.preventDefault();

                let formData = new FormData($('#upsertData')[0]);
                loadingAlert();

                $.ajax({
                    type: 'POST',
                    url: '/v1/prosedur/create',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);

                        Swal.close();
                        if (response.code === 422) {
                            let errors = response.errors;
                            $.each(errors, function(key, value) {
                                $('#' + key + '-error').text(value[0]);
                            });
                        } else if (response.code === 200) {
                            successAlert();
                            getData(); // Reload data table
                        } else {
                            errorAlert();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.close();
                        errorAlert();
                    }
                });
            });

            // Menampilkan alert loading
            function loadingAlert() {
                Swal.fire({
                    title: 'Loading...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }

            // Alert sukses
            function successAlert() {
                Swal.fire({
                    title: 'Berhasil!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1000,
                });
            }

            // Alert error
            function errorAlert() {
                Swal.fire({
                    title: 'Error',
                    text: 'Terjadi kesalahan!',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1000,
                });
            }

            // Konfirmasi penghapusan data
            $(document).on('click', '.delete-confirm', function() {
                let id = $(this).data('id');

                function deleteData() {
                    $.ajax({
                        type: 'DELETE',
                        url: `/v1/prosedur/delete/${id}`,
                        success: function(response) {
                            if (response.code === 200) {
                                successAlert();
                                getData(); // Reload data table setelah penghapusan
                            } else {
                                errorAlert();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            errorAlert();
                        }
                    });
                }

                confirmAlert('Apakah Anda yakin ingin menghapus data?', deleteData);
            });

            // Konfirmasi dengan SweetAlert
            function confirmAlert(message, callback) {
                Swal.fire({
                    title: '<span style="font-size: 22px">Konfirmasi!</span>',
                    text: message,
                    showCancelButton: true,
                    showConfirmButton: true,
                    cancelButtonText: 'Tidak',
                    confirmButtonText: 'Ya',
                    reverseButtons: true,
                    confirmButtonColor: '#063158',
                    cancelButtonColor: '#EFEFEF',
                    customClass: {
                        cancelButton: 'text-dark'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        callback();
                    }
                });
            }
        });
    </script>
@endsection
