@extends('Layouts.Base')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="fw-bold fs-10"><i class="fa-solid fa-book px-1"></i>DATA ANGGOTA KELOMPOK</h5>
        </div>
        <div class="table-responsive text-nowrap px-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pb-2">
                <div class="d-flex">
                    <div class="form-group">
                        <label for="pageSizeSelect">Show : </label>
                        <select id="pageSizeSelect" class="form-control" style="height: 39.9px !important;">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="form-group">
                        <label for="end_date">Search: </label>
                        <div class="input-icon">
                            <input type="text" class="form-control" style="height: 39.9px !important;" id="searchInput"
                                placeholder="Search for...">
                        </div>
                    </div>
                </div>
            </div>

            <table id="loadData" class="table">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA</th>
                        <th>ALAMAT</th>
                        <th>TEMPAT LAHIR</th>
                        <th>TANGGAL LAHIR</th>
                        <th>NIK</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <div class="pagination-container d-flex align-items-center py-2">
                <button id="prevPage" class="btn btn-sm btn-outline-secondary me-2">Previous</button>
                <span id="currentPage" class="align-self-center">1</span>
                <button id="nextPage" class="btn btn-sm btn-outline-secondary ms-2">Next</button>
            </div>
        </div>

        {{-- Modal Detail Member Group --}}
        <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Anggota</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="id_grup" id="id_grup">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="input name">
                                <small id="name-error" class="text-danger"></small>

                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <input type="text" name="address" id="address" class="form-control"
                                    placeholder="input address">
                                <small id="address-error" class="text-danger"></small>

                            </div>
                            <div class="mb-3">
                                <label for="place_birth" class="form-label">Tempat Lahir</label>
                                <input type="text" name="place_birth" id="place_birth" class="form-control"
                                    placeholder="input place birth">
                                <small id="place_birth-error" class="text-danger"></small>

                            </div>
                            <div class="mb-3">
                                <label for="date_birth" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="date_birth" id="date_birth" class="form-control"
                                    placeholder="date birth">
                                <small id="date_birth-error" class="text-danger"></small>

                            </div>
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" name="nik" id="nik" class="form-control"
                                    placeholder="input NIK">
                                <small id="NIK-error" class="text-danger"></small>

                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="" selected disabled>Pilih Status</option>
                                    <option value="marry">Menikah</option>
                                    <option value="single">Belum Nikah</option>
                                    <option value="divorced alive">Cerai Hidup</option>
                                    <option value="divorced dead">Cerai Mati</option>
                                </select>
                                <small id="status-error" class="text-danger"></small>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let allMembers = [];
            let currentPage = 1;
            const pageSize = 5;

            // Fungsi untuk mengelompokkan data berdasarkan kunci tertentu
            function groupBy(array, key) {
                return array.reduce((result, currentItem) => {
                    const group = currentItem[key];
                    if (!result[group]) {
                        result[group] = [];
                    }
                    result[group].push(currentItem);
                    return result;
                }, {});
            }

            // Fungsi untuk memuat data dari API
            function loadData() {
                $.ajax({
                    url: `/v1/membergrup?page=${currentPage}&pageSize=${pageSize}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.code === 200) {
                            // Transformasi data API
                            allMembers = response.data.flatMap(grup =>
                                grup.member_grup.map(member => ({
                                    grup_name: grup.grup_name,
                                    ...member
                                }))
                            );
                            renderTable();
                        } else {
                            $("#loadData tbody").append(`
                        <tr>
                            <td colspan="8" class="text-center"><i class="fa-solid fa-face-sad-tear px-1"></i>Data tidak ditemukan</td>
                        </tr>
                    `);
                        }
                    },
                    error: function() {
                        console.log("Failed to get data from server");
                    }
                });
            }

            // Fungsi untuk merender tabel berdasarkan data yang dikelompokkan
            function renderTable() {
                const tbody = $('#loadData tbody');
                tbody.empty();

                const groupedData = groupBy(allMembers, 'grup_name');

                if (Object.keys(groupedData).length === 0) {
                    tbody.append('<tr><td colspan="8">Data tidak ditemukan</td></tr>');
                } else {
                    Object.keys(groupedData).forEach((groupName, groupIndex) => {
                        // Baris header grup
                        tbody.append(`
                        <tr class="group-row">
                            <td colspan="8" style="text-align: center; font-weight: bold;">Kelompok: ${groupName}</td>
                        </tr>
                    `);

                        // Baris anggota dalam grup
                        groupedData[groupName].forEach((item, index) => {
                            tbody.append(`
                            <tr data-id="${item.id}">
                                <td>${groupIndex + 1}.${index + 1}</td>
                                <td>${item.name}</td>
                                <td>${item.address}</td>
                                <td>${item.place_birth}</td>
                                <td>${formatDate(item.date_birth)}</td>
                                <td>${item.nik}</td>
                                <td>${item.status}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary btn-edit" data-id="${item.id}"><i class='fa-solid fa-edit'></i></button>
                                    <button class="btn btn-sm btn-outline-danger btn-delete"><i class='fa fa-trash'></i></button>
                                </td>
                            </tr>
                        `);
                        });
                    });
                }

                $('#currentPage').text(currentPage);
                attachEventListeners();
            }

            // Fungsi untuk menambahkan event listener pada tombol edit dan delete
            function attachEventListeners() {
                $('.btn-edit').off('click').on('click', function() {
                    const id = $(this).data('id');
                    editMember(id);
                });

                $('.btn-delete').off('click').on('click', function() {
                    const id = $(this).closest('tr').data('id');
                    confirmAlert('Apakah Anda yakin ingin menghapus data?', () => deleteMember(id));
                });
            }

            // Fungsi untuk mengedit anggota
            function editMember(id) {
                $.ajax({
                    url: `/v1/membergrup/get/${id}`,
                    method: 'GET',
                    success: function(response) {
                        if (response.code === 200) {
                            const data = response.data;
                            // Isi form dengan data anggota
                            $('#id').val(data.id);
                            $('#id_grup').val(data.id_grup);
                            $('#name').val(data.name);
                            $('#address').val(data.address);
                            $('#place_birth').val(data.place_birth);
                            $('#date_birth').val(data.date_birth);
                            $('#nik').val(data.nik);
                            $('#status').val(data.status);

                            // Tampilkan modal
                            $('#editModal').modal('show');
                        } else {
                            errorAlert('Gagal memuat data untuk diedit!');
                        }
                    },
                    error: function() {
                        errorAlert('Terjadi kesalahan saat memuat data!');
                    }
                });
            }

            // Fungsi untuk menyimpan data yang sudah diedit
            $('#editForm').on('submit', function(e) {
                e.preventDefault();
                const id = $('#id').val();
                const formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: id ? `/v1/membergrup/update/${id}` : '/v1/membergrup/create',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.code === 200) {
                            successAlert('Data berhasil disimpan!');
                            $('#editModal').modal('hide');
                            loadData();
                        } else {
                            errorAlert('Gagal menyimpan data!');
                        }
                    },
                    error: function() {
                        errorAlert('Terjadi kesalahan saat menyimpan data!');
                    }
                });
            });

            // Fungsi untuk menghapus anggota
            function deleteMember(id) {
                $.ajax({
                    type: 'DELETE',
                    url: `/v1/membergrup/delete/${id}`,
                    success: function(response) {
                        if (response.code === 200) {
                            successAlert('Data berhasil dihapus!');
                            loadData();
                        } else {
                            errorAlert('Gagal menghapus data!');
                        }
                    },
                    error: function() {
                        errorAlert('Terjadi kesalahan saat menghapus data!');
                    }
                });
            }

            // Fungsi untuk alert sukses
            function successAlert(message) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: message,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                });
            }

            // Fungsi untuk alert error
            function errorAlert(message) {
                Swal.fire({
                    title: 'Error',
                    text: message || 'Terjadi kesalahan!',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                });
            }

            // Fungsi untuk konfirmasi aksi
            function confirmAlert(message, callback) {
                Swal.fire({
                    title: 'Konfirmasi!',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        callback();
                    }
                });
            }

            // Fungsi untuk memformat tanggal
            function formatDate(dateString) {
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                return new Date(dateString).toLocaleDateString('id-ID', options);
            }

            // Inisialisasi data saat halaman dimuat
            loadData();
        });
    </script>
@endsection
