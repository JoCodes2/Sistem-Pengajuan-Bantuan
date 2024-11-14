@extends('Layouts.Base')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="fw-bold fs-10"><i class="fa-solid fa-book px-1"></i>Tambah Pengajuan Bantuan</h5>
        </div>
        <div class="card-body">
            <form id="submissionForm">
                @csrf
                <div class="form-group">
                    <label for="grup_name">Nama Kelompok</label>
                    <input type="text" class="form-control" name="grup_name" id="grup_name" value="{{ old('grup_name') }}">
                    <small id="grup_name-error" class="text-danger"></small>
                </div>

                <!-- Form Anggota -->
                <div id="membersSection">
                    <div class="member-form" >
                        <div class="form-group">
                            <label for="member_name" class="form-label">Nama Anggota</label>
                            <input type="text" class="form-control" name="members[0][name]" value="{{ old('members.0.name') }}" placeholder="Nama Anggota">
                            <small id="members.0.name-error" class="text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label for="member_nik" class="form-label">NIK Anggota</label>
                            <input type="text" class="form-control" name="members[0][nik]" value="{{ old('members.0.nik') }}" placeholder="NIK Anggota">
                            <small id="members.0.nik-error" class="text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label for="member_address" class="form-label">Alamat Anggota</label>
                            <input type="text" class="form-control" name="members[0][address]" value="{{ old('members.0.address') }}" placeholder="Alamat">
                            <small id="members.0.address-error" class="text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label for="member_place_birth" class="form-label">Tempat Tanggal</label>
                            <input type="text" class="form-control" name="members[0][place_birth]" value="{{ old('members.0.place_birth') }}" placeholder="Tempat Lahir">
                            <small id="members.0.place_birth-error" class="text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label for="member_date_birth" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="members[0][date_birth]" value="{{ old('members.0.date_birth') }}">
                            <small id="members.0.date_birth-error" class="text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label for="member_status" class="form-label">Status Perkawinan</label>
                            <input type="text" class="form-control" name="members[0][status]" value="{{ old('members.0.status') }}" placeholder="Status Perkawinan">
                            <small id="members.0.status-error" class="text-danger"></small>
                        </div>

                        <!-- Tombol Hapus Form Anggota (tidak bisa dihapus untuk yang pertama) -->
                        <div class="d-flex flex-column flex-md-row py-2 align-items-center">
                            <button type="button" class="btn btn-danger btn-sm removeMember" data-index="0" disabled>Hapus Anggota</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm addMember">Tambah Anggota</button>


                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi Pengajuan</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                    <small id="description-error" class="text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="file_proposal" class="form-label">File Proposal</label>
                    <input type="file" class="form-control" id="file_proposal" name="file_proposal">
                    <small id="file_proposal-error" class="text-danger"></small>
                </div>

                <!-- Submit Button -->
                <button type="button" id="saveData" class="btn btn-primary">Simpan Pengajuan</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
    let memberIndex = 1;

    // Menambahkan form anggota baru
    $('.addMember').click(function () {
        $('#membersSection').append(`
            <div class="member-form" >
                <div class="form-group">
                    <label for="member_name" class="form-label">Nama Anggota</label>
                    <input type="text" class="form-control" name="members[${memberIndex}][name]" value="{{ old('members.${memberIndex}.name') }}" placeholder="Nama Anggota" required>
                    <small id="members.${memberIndex}.name-error" class="text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="member_nik" class="form-label">NIK Anggota</label>
                    <input type="text" class="form-control" name="members[${memberIndex}][nik]" value="{{ old('members.${memberIndex}.nik') }}" placeholder="NIK Anggota" required>
                    <small id="members.${memberIndex}.nik-error" class="text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="member_address" class="form-label">Alamat Anggota</label>
                    <input type="text" class="form-control" name="members[${memberIndex}][address]" value="{{ old('members.${memberIndex}.address') }}" placeholder="Alamat" required>
                    <small id="members.${memberIndex}.address-error" class="text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="member_place_birth" class="form-label">Tempat Tanggal Lahir</label>
                    <input type="text" class="form-control" name="members[${memberIndex}][place_birth]" value="{{ old('members.${memberIndex}.place_birth') }}" placeholder="Tempat Lahir" required>
                    <small id="members.${memberIndex}.place_birth-error" class="text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="member_date_birth" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="members[${memberIndex}][date_birth]" value="{{ old('members.${memberIndex}.date_birth') }}" required>
                    <small id="members.${memberIndex}.date_birth-error" class="text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="member_status" class="form-label">Status Perkawinan</label>
                    <input type="text" class="form-control" name="members[${memberIndex}][status]" value="{{ old('members.${memberIndex}.status') }}" placeholder="Status Perkawinan" required>
                    <small id="members.${memberIndex}.status-error" class="text-danger"></small>
                </div>

                <div class="d-flex flex-column flex-md-row py-2 align-items-center">
                    <button type="button" class="btn btn-danger btn-sm removeMember" data-index="${memberIndex}">Hapus Anggota</button>
                </div>
            </div>
        `);
        memberIndex++;
    });

    // Hapus form anggota
    $(document).on('click', '.removeMember', function () {
        let index = $(this).data('index');
        // Hanya izinkan penghapusan jika bukan anggota pertama
        if (index !== 0) {
            $(this).closest('.member-form').remove();
        }
    });

    // Menampilkan error menggunakan alert swal
    function showErrorAlert(errors) {
        $.each(errors, function (key, value) {
            // Menampilkan pesan error di small tag dengan id yang sesuai
            $('#' + key + '-error').text(value[0]);
        });
    }
     function successAlert(message) {
            Swal.fire({
                title: 'Berhasil!',
                text: message,
                icon: 'success',
                showConfirmButton: false,
                timer: 1000,
            })
        }

        // alert error message
        function errorAlert() {
            Swal.fire({
                title: 'Error',
                text: 'Terjadi kesalahan!',
                icon: 'error',
                showConfirmButton: false,
                timer: 1000,
            });
        }


        // funtion reload
        function reloadBrowsers() {
            setTimeout(function() {
                location.reload();
            }, 1500);
        }

        // loading alerts
        function loadingAllert(){
            Swal.fire({
                title: 'Loading...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }

    // Tombol Simpan Pengajuan
    $(document).on('click', '#saveData', function (e) {
        e.preventDefault();
        $('.text-danger').text('');  // Menghapus pesan error sebelumnya

        // Menyiapkan formData
        let formData = new FormData($('#submissionForm')[0]);
        loadingAllert();

        // Melakukan pengiriman form menggunakan AJAX
        $.ajax({
            type: 'POST',
            url: '/v1/submissions/create',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);

                Swal.close();
                if (response.code === 422) {
                    // Jika ada error, tampilkan pesan error di tiap input
                    showErrorAlert(response.errors);
                } else if (response.code === 200) {
                    successAlert('Pengajuan berhasil disimpan!');
                    reloadBrowsers();
                } else {
                    errorAlert();
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.close();
            }
        });
    });
});

</script>
@endsection
