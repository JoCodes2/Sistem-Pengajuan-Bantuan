@extends('Layouts.UiWeb')
@section('content')
    <section class="home" id="home">
      <div class="container pt-5 mt-5" data-aos="zoom-in">
        <div class="row pt-2 justify-content-center">
          <div class="col-md-5 d-flex justify-content-center align-items-center">
            <div class="bg-home ">
              <img src="{{ asset('assets/assets/home.jpg') }}" class="img-fluid img" alt="">
            </div>
          </div>
          <div class="col-md-5 d-flex flex-column justify-content-center align-items-start">
                <p class="text-hai font-popins">Hallo 👋 Semua</p>
                <h1 class="title-home font-kanit sky">Selamat Datang di Sistem Informasi Pengajuan Bantuan Masyarakat Nelayan</h1>
                <p class="intro-junior font-popins">
                    Aplikasi ini dirancang untuk mempermudah masyarakat nelayan dalam mengajukan bantuan dan memberikan informasi terkait program bantuan yang tersedia.
                    Dengan sistem ini, proses pengajuan menjadi lebih cepat, transparan, dan mudah diakses kapan saja.
                </p>
            </div>

        </div>
      </div>
    </section>
    <section class="form-pengajuan">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-10">
                    <div class="row d-flex justify-content-center align-items-center py-2">
                        <h1 class="font-kanit sky text-center" data-aos="zoom-in">Silahkan melengkapi data yang dibutuhkan dalam proses pengajuan bantuan
                        </h1>
                    </div>
                    <div class="card rounded-5" data-aos="zoom-in">
                        <div class="card-header">
                            <h2 class="font-kanit sky " id="pendudukModalLabel"><i class="fas fa-file-alt pr-5 pr-2"></i>Form Pengajuan</h2>
                        </div>
                        <div class="card-body">
                        <form id="submissionForm">
                            @csrf
                            <div class="form-groupn mb-3">
                                <label for="grup_name" class="mb-2 fw-bold fs-6 sky"><i class="menu-icon fa-brands fa-42-group"></i><strong>Nama Kelompok</strong></label>
                                <input type="text" class="form-control" name="grup_name" id="grup_name" value="{{ old('grup_name') }}" placeholder="Nama kelompok">
                                <small id="grup_name-error" class="text-danger"></small>
                            </div>
                            <p class="fw-bold fs-6 sky"><i class="menu-icon fa-solid fa-people-group"></i>Anggota Kelompok</p>
                            <hr>
                            <!-- Form Anggota -->
                            <div id="membersSection">
                                <div class="member-form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="member_name" class="form-label">Nama Anggota</label>
                                                <input type="text" class="form-control" name="members[0][name]" placeholder="Nama Anggota">
                                                <small id="members_0_name-error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="member_nik" class="form-label">NIK Anggota</label>
                                                <input type="text" class="form-control nik-input" name="members[0][nik]" placeholder="NIK Anggota">
                                                <small id="members_0_nik-error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="member_address" class="form-label">Alamat Anggota</label>
                                                <input type="text" class="form-control" name="members[0][address]" placeholder="Alamat">
                                                <small id="members_0_address-error" class="text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="member_place_birth" class="form-label">Tempat Lahir</label>
                                                <input type="text" class="form-control" name="members[0][place_birth]" placeholder="Tempat Lahir">
                                                <small id="members_0_place_birth-error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="member_date_birth" class="form-label">Tanggal Lahir</label>
                                                <input type="date" class="form-control" name="members[0][date_birth]">
                                                <small id="members_0_date_birth-error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="member_status" class="form-label">Status Perkawinan</label>
                                                <select class="form-control" name="members[0][status]" id="member_status">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="marry">Kawin</option>
                                                    <option value="single">Belum Kawin</option>
                                                    <option value="divorced alive">Cerai Hidup</option>
                                                    <option value="divorced dead">Cerai Mati</option>
                                                </select>
                                                <small id="members_0_status-error" class="text-danger"></small>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-2">
                                        <button type="button" class="btn btn-outline-danger btn-sm removeMember ms-2"  disabled><i class="fa-solid fa-trash px-2"></i>Hapus Anggota</button>
                                        <button type="button" class="btn btn-outline-success btn-sm  addMember ms-2"><i class="fa-solid fa-plus px-2"></i>Tambah Anggota</button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group mb-2">
                                <label for="description" class="form-label">Deskripsi Pengajuan</label>
                                <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                <small id="description-error" class="text-danger"></small>
                            </div>

                            <div class="form-group mb-2">
                                <label for="file_proposal" class="form-label">File Proposal</label>
                                <input type="file" class="form-control" id="file_proposal" name="file_proposal">
                                <small id="file_proposal-error" class="text-danger"></small>
                            </div>
                        </form>
                        </div>
                         <div class="card-footer d-flex justify-content-end">
                            <button type="button" class="btn-cencel rounded-5 mr-2 px-3 py-1" id="cencelData">Batal</button>
                            <button type="button" class="btn-home px-3 py-1 font-popins rounded-5" id="saveData">Kirim </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
<script>
        $(document).ready(function () {
        let memberIndex = 1;

        $(document).on('click', '.addMember', function () {
            $('#membersSection').append(`
                <div class="member-form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="member_name" class="form-label">Nama Anggota</label>
                                <input type="text" class="form-control" name="members[${memberIndex}][name]" placeholder="Nama Anggota">
                                <small id="members_${memberIndex}_name-error" class="text-danger"></small>
                            </div>
                            <div class="form-group mb-2">
                                <label for="member_nik" class="form-label">NIK Anggota</label>
                                <input type="text" class="form-control nik-input" name="members[${memberIndex}][nik]" placeholder="NIK Anggota">
                                <small id="members_${memberIndex}_nik-error" class="text-danger"></small>
                            </div>
                            <div class="form-group mb-2">
                                <label for="member_address" class="form-label">Alamat Anggota</label>
                                <input type="text" class="form-control " name="members[${memberIndex}][address]" placeholder="Alamat">
                                <small id="members_${memberIndex}_address-error" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="member_place_birth" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" name="members[${memberIndex}][place_birth]" placeholder="Tempat Lahir">
                                <small id="members_${memberIndex}_place_birth-error" class="text-danger"></small>
                            </div>
                            <div class="form-group mb-2">
                                <label for="member_date_birth" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="members[${memberIndex}][date_birth]">
                                <small id="members_${memberIndex}_date_birth-error" class="text-danger"></small>
                            </div>
                            <div class="form-group mb-2">
                                <label for="member_status" class="form-label">Status Perkawinan</label>
                                <select class="form-control" name="members[${memberIndex}][status]">
                                    <option value="" selected disabled>--Pilih--</option>
                                    <option value="marry">Kawin</option>
                                    <option value="single">Belum Kawin</option>
                                    <option value="divorced alive">Cerai Hidup</option>
                                    <option value="divorced dead">Cerai Mati</option>
                                </select>
                                <small id="members_${memberIndex}_status-error" class="text-danger"></small>
                            </div>

                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <button type="button" class="btn btn-outline-danger btn-sm removeMember ms-2" data-index="${memberIndex}"><i class="fa-solid fa-trash px-2"></i>Hapus Anggota</button>
                        <button type="button" class="btn btn-outline-success btn-sm addMember ms-2"><i class="fa-solid fa-plus px-2"></i>Tambah Anggota</button>
                    </div>
                </div>
            `);

            $('.member-form').each(function (index) {
                if (index < $('.member-form').length - 1) {
                    $(this).find('.addMember').prop('disabled', true);
                    $(this).find('.removeMember').prop('disabled', true);
                }
            });
            $('.member-form').last().find('.addMember').prop('disabled', false);
            $('.member-form').last().find('.removeMember').prop('disabled', false);

            memberIndex++;
        });

        $(document).on('click', '.removeMember', function () {
            if ($(this).closest('.member-form').index() !== 0) {
                $(this).closest('.member-form').remove();
            }

            if ($('.member-form').length > 1) {
                $('.member-form').each(function (index) {
                    if (index === 0) {
                        $(this).find('.addMember').prop('disabled', false);
                        $(this).find('.removeMember').prop('disabled', true);
                    } else if (index < $('.member-form').length - 1) {
                        $(this).find('.addMember').prop('disabled', true);
                        $(this).find('.removeMember').prop('disabled', false);
                    }
                });
            }

            $('.member-form').last().find('.addMember').prop('disabled', false);
            $('.member-form').last().find('.removeMember').prop('disabled', false);
        });


        $(document).on('input', '.nik-input', function () {
            let input = $(this).val();
            $(this).val(input.replace(/[^0-9]/g, ''));
        });


        function successAlert(message) {
            Swal.fire({
                title: 'Berhasil!',
                text: message,
                icon: 'success',
                showConfirmButton: false,
                timer: 1000,
            })
        }

        function errorAlert() {
            Swal.fire({
                title: 'Error',
                text: 'Terjadi kesalahan!',
                icon: 'error',
                showConfirmButton: false,
                timer: 1000,
            });
        }

        function reloadBrowsers() {
            setTimeout(function() {
                location.reload();
            }, 1500);
        }


        function confirmAlert(message, callback) {
            Swal.fire({
                title: '<span style="font-size: 22px"> Konfirmasi!</span>',
                html: message,
                showCancelButton: true,
                showConfirmButton: true,
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Ya',
                reverseButtons: true,
                confirmButtonColor: '#48ABF7',
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

        // loading alert
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

        $(document).on('click', '#cencelData', function () {
            $('#grup_name').val('');
            $('#description').val('');

            $('#file_proposal').val('');

            $('#membersSection').html(`
                <div class="member-form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="member_name" class="form-label">Nama Anggota</label>
                                <input type="text" class="form-control" name="members[0][name]" placeholder="Nama Anggota">
                                <small id="members_0_name-error" class="text-danger"></small>
                            </div>
                            <div class="form-group mb-2">
                                <label for="member_nik" class="form-label">NIK Anggota</label>
                                <input type="text" class="form-control nik-input" name="members[0][nik]" placeholder="NIK Anggota">
                                <small id="members_0_nik-error" class="text-danger"></small>
                            </div>
                            <div class="form-group mb-2">
                                <label for="member_address" class="form-label">Alamat Anggota</label>
                                <input type="text" class="form-control" name="members[0][address]" placeholder="Alamat">
                                <small id="members_0_address-error" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="member_place_birth" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" name="members[0][place_birth]" placeholder="Tempat Lahir">
                                <small id="members_0_place_birth-error" class="text-danger"></small>
                            </div>
                            <div class="form-group mb-2">
                                <label for="member_date_birth" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="members[0][date_birth]">
                                <small id="members_0_date_birth-error" class="text-danger"></small>
                            </div>
                            <div class="form-group mb-2">
                                <label for="member_status" class="form-label">Status Perkawinan</label>
                                <select class="form-control" name="members[0][status]" id="member_status">
                                    <option value="" selected disabled>--Pilih--</option>
                                    <option value="marry">Kawin</option>
                                    <option value="single">Belum Kawin</option>
                                    <option value="divorced alive">Cerai Hidup</option>
                                    <option value="divorced dead">Cerai Mati</option>
                                </select>
                                <small id="members_0_status-error" class="text-danger"></small>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <button type="button" class="btn btn-danger btn-sm removeMember ms-2" disabled><i class="fa-solid fa-trash px-2"></i>Hapus Anggota</button>
                        <button type="button" class="btn btn-success btn-sm addMember ms-2"><i class="fa-solid fa-plus px-2"></i>Tambah Anggota</button>
                    </div>
                </div>
            `);

            $('.member-form').first().find('.addMember').prop('disabled', false);
            $('.member-form').first().find('.removeMember').prop('disabled', true);
        });

        $(document).on('click', '#saveData', function(e) {

            e.preventDefault();
            $('.text-danger').text('');

            let formData = new FormData($('#submissionForm')[0]);
            function saveData() {
                $.ajax({
                    type: 'POST',
                    url: '/v1/submissions/create',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        Swal.close();
                        if (response.code === 422) {
                           $.each(response.errors, function (key, value) {
                            let formattedKey = key.replace(/\./g, '_');
                            if (key.startsWith('members')) {
                                let memberIndex = key.split('.')[1];
                                let memberField = key.split('.')[2];
                                $(`#members_${memberIndex}_${memberField}-error`).text(value[0]);
                            } else {
                                $(`#${formattedKey}-error`).text(value[0]);
                            }
                        });
                        } else if (response.code === 200) {
                            successAlert();
                            reloadBrowsers();
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
            }
            confirmAlert('Apakah semua data sudah benar?', saveData);
        });
    });
</script>
@endsection
