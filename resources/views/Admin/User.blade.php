@extends('Layouts.Base')
@section('content')
    <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h3 class="m-0 font-weight-bold "><i class="fa-solid fa-book pr-2"></i>Pengguna</h3>
            <button type="button" class="btn btn-outline-primary ml-auto" id="myBtn">
                <i class="fa-solid fa-plus pr-2"></i>Tambah Data
            </button>
        </div>

        <!-- /.card-header -->
        <div class="card-body">
            <table id="loadData" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Jabatan</th>
                        <th>Hak Akses</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <!-- Data pengguna akan dimuat di sini -->
                </tbody>
            </table>
        </div>

        <!-- Modal -->

        <div class="modal fade show" id="formDataModal" tabindex="-1" aria-labelledby="formDataModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formDataModalLabel">Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="userForm" method="POST">
                            @csrf
                            <input type="hidden" id="id" name="id">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="input nama">
                                <small id="name-error" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="input email">
                                <small id="email-error" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="password" id="passwordLabel">Password</label>
                                <input type="password" class="form-control passwordLabel" name="password" id="password"
                                    placeholder="*******">
                                <small id="password-error" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" id="passwordConfirmLabel">Konfirmasi Password</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                    id="password_confirmation">
                                <small id="password_confirmation-error" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="position">Jabatan</label>
                                <input type="text" class="form-control" name="position" id="position"
                                    placeholder="input jabatan">
                                <small id="devisi-error" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="role">Hak Akses</label>
                                <select class="form-control" name="role" id="role">
                                    <option value="">Pilih Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                                <small id="role-error" class="text-danger"></small>
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
            function getData() {
                $.ajax({
                    url: `/v1/user`,
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        let table = $("#loadData").DataTable(); // Inisialisasi DataTable hanya sekali
                        table.clear(); // Hapus data lama dari tabel

                        // Menambahkan data baru ke tabel
                        $.each(response.data, function(index, item) {
                            table.row.add([
                                index + 1,
                                item.name,
                                "****", // Menyembunyikan password
                                item.position,
                                item.role,
                                `<button type='button' class='btn btn-outline-primary edit-btn' data-id='${item.id}'><i class='fa-solid fa-edit'></i></button>
                    <button type='button' class='btn btn-outline-danger delete-confirm' data-id='${item.id}'><i class='fa fa-trash'></i></button>`
                            ]);
                        });

                        table.draw(); // Render ulang tabel
                    },
                    error: function() {
                        console.log("Gagal mengambil data dari server");
                    }
                });
            }

            getData();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#myBtn').click(function() {
                // Reset form dan pesan error
                $('#userForm')[0].reset(); // Reset input form
                $('.text-danger').text(''); // Hapus pesan error
                $('#id').val(''); // Kosongkan input ID

                // Atur ulang judul modal jika perlu
                $('#formDataModalLabel').text('Tambah Pengguna');

                // Tampilkan modal
                $('#formDataModal').modal('show');
            });

            // Save or update data
            $(document).on('click', '#simpanData', function(e) {
                e.preventDefault();

                // Hapus pesan error sebelumnya
                $('.text-danger').text('');

                let id = $('#id').val();
                let formData = new FormData($('#userForm')[0]); // Pastikan ID form sesuai dengan modal
                let url = id ? `/v1/user/update/${id}` : '/v1/user/create';
                let method = 'POST';

                loadingAllert();

                $.ajax({
                    type: method,
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.close();
                        if (response.code === 422) {
                            let errors = response.errors;
                            $.each(errors, function(key, value) {
                                $('#' + key + '-error').text(value[0]);
                            });
                        } else if (response.code === 200) {
                            successAlert();
                            $('#formDataModal').modal(
                            'hide'); // Tutup modal setelah berhasil menyimpan
                            getData(); // Refresh data tabel
                        } else {
                            errorAlert();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.close();
                    }
                });
            });


            // Edit data button click handler
            $(document).on('click', '.edit-btn', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: `/v1/user/get/${id}`,
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        $('#formDataModal').modal('show');
                        $('#id').val(response.data.id);
                        $('#name').val(response.data.name);
                        $('#passwordLabel').text('Masukan password baru')

                        $('#position').val(response.data.position);
                        $('#role').val(response.data.role);

                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data for edit:', error);
                    }
                });
            });

            // Delete data button click handler
            $(document).on('click', '.delete-confirm', function() {
                let id = $(this).data('id');

                // Function to delete data
                function deleteData() {
                    $.ajax({
                        type: 'DELETE',
                        url: `/v1/user/delete/${id}`,
                        success: function(response) {
                            if (response.code === 200) {
                                successAlert();
                                reloadBrowsers();
                            } else {
                                errorAlert();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }

                // Show confirmation alert
                confirmAlert('Apakah Anda yakin ingin menghapus data?', deleteData);
            });

            // Alert functions
            function successAlert(message) {
                Swal.fire({
                    title: 'Berhasil!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1000,
                })
            }


            // Alert functions
            function successAlert(message) {
                Swal.fire({
                    title: 'Berhasil!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1000,
                })
            }

            function errorAlert(message) {
                Swal.fire({
                    title: 'Error',
                    text: message || 'Terjadi kesalahan!',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1000,
                });
            }

            function confirmAlert(message, callback) {
                Swal.fire({
                    title: '<span style="font-size: 22px"> Konfirmasi!</span>',
                    text: message,
                    showCancelButton: true,
                    showConfirmButton: true,
                    cancelButtonText: 'Tidak',
                    confirmButtonText: 'Ya',
                    reverseButtons: true,
                    confirmButtonColor: '#063158 ',
                    cancelButtonColor: '#EFEFEF',
                    cancelButtonText: 'Tidak',
                    customClass: {
                        cancelButton: 'text-dark'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        callback();
                    }
                });
            }

            function reloadBrowsers() {
                setTimeout(function() {
                    location.reload();
                }, 1500);
            }

            function loadingAllert() {
                Swal.fire({
                    title: 'Loading...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }

        });
    </script>
@endsection
