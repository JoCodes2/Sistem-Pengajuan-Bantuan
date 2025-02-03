@extends('Layouts.Base')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="fw-bold fs-10"><i class="fa-solid fa-book px-1"></i>DATA DISPOSISI</h5>
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
                            <input type="text" class="form-control" style="height: 39.9px !important;"
                                id="searchInput" placeholder="Search for...">
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-borderless" id="loadData">
                <thead class="table-primary text-center">
                    <tr>
                    <th>No</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Nama Kelompok</th>
                    <th>NIK/Nama Anggota</th>
                    <th>Deskripsi Pengajuan</th>
                    <th>File Proposal</th>
                    <th>Status Pengajuan</th>
                    <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class=" text-center">

                </tbody>
            </table>
            <div class="pagination-container d-flex  align-items-center py-2">
                <button id="prevPage" class="btn btn-sm btn-outline-secondary me-2">Previous</button>
                <span id="currentPage" class="align-self-center">1</span>
                <button id="nextPage" class="btn btn-sm btn-outline-secondary ms-2">Next</button>
            </div>
        </div>
        {{-- modal detail submission --}}
        <div class="modal fade" id="detailDataModal" tabindex="-1" aria-labelledby="detailDataModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailDataModalLabel">Detail Data Pengajuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table>
                            <thead>
                                <tr>
                                    <td>Tanggal Pengajuan</td>
                                    <td>:</td>
                                    <th id="detailDate"></th>
                                </tr>
                                <tr>
                                    <td>Nama Kelompok</td>
                                    <td>:</td>
                                    <th id="detailGroupName"></th>
                                </tr>
                                <tr>
                                    <td>Status Pengajuan</td>
                                    <td>:</td>
                                    <th id="detailStatus"></th>
                                </tr>
                                <tr>
                                    <td>File Proposal</td>
                                    <td>:</td>
                                    <th >
                                        <a href="" id="detailFileProposal" class="text-decoration-none" download></a>
                                    </th>
                                </tr>
                                <tr>
                                    <td>Deskripsi Pengajuan</td>
                                    <td>:</td>
                                    <th id="detailDescription"></th>
                                </tr>
                            </thead>
                        </table>
                        <hr>
                        <h6 class="fw-bold fs-10">Anggota Kelompok</h6>
                        <div class="table-responsive text-nowrap">
                            <table class="table" id="memberListTable">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>NIK/Nama</th>
                                        <th>Tempat Tanggal Lahit</th>
                                        <th>Status Perkawinan</th>
                                        <th>Alamat</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    let dataCache = [];
    let currentPage = 1;
    let pageSize = 5;
    let searchQuery = "";

    function formatDate(dateString) {
        const options = { year: 'numeric', month: 'long', day: 'numeric'};
        return new Date(dateString).toLocaleString('id-ID', options);
    }
    function getStatusInfo(status_submissions) {
        let statusClass = '';
        let statusText = '';

        switch (status_submissions) {
            case 'review':
                statusClass = 'btn btn-secondary btn-sm btn-round';
                statusText = 'Pemeriksaan Berkas';
                break;
            case 'approved':
                statusClass = 'btn btn-success btn-sm btn-round';
                statusText = 'Permohonan Disetujui';
                break;
            case 'rejected':
                statusClass = 'btn btn-danger btn-sm btn-round';
                statusText = 'Permohonan Ditolak';
                break;
            default:
                statusClass = 'btn btn-info btn-sm btn-round';
                statusText = 'Menunggu Persetujuan';
        }

        return { statusClass, statusText };
    }

   function renderTable(data) {
    $("#loadData tbody").empty();

    const offset = (currentPage - 1) * pageSize;
    const paginatedData = data.slice(offset, offset + pageSize);

    paginatedData.forEach(function (item, index) {
        let rowSpan = item.grup.member_grup.length;
        let statusRequest = getStatusInfo(item.status_submissions);
        let fileProposalUrl = '/uploads/file-proposal-pengajuan/' + item.file_proposal;

        // Periksa apakah status_submissions adalah 'waiting'
        let isWaiting = item.status_submissions === 'waiting';
        let disableClass = isWaiting ? '' : 'disabled'; // Tambahkan class 'disabled' jika bukan 'waiting'

        let row = `
            <tr>
                <td rowspan="${rowSpan}">${index + 1 + offset}</td>
                <td rowspan="${rowSpan}">${formatDate(item.date)}</td>
                <td rowspan="${rowSpan}"><strong class="fw-bold fs-10">${item.grup.grup_name}</strong></td>
                <td><strong class="fw-bold fs-10">${item.grup.member_grup[0].nik}</strong><br> ${item.grup.member_grup[0].name}</td>
                <td rowspan="${rowSpan}">${item.description}</td>
                <td rowspan="${rowSpan}">
                    <a href="${fileProposalUrl}" download class="text-decoration-none">${item.file_proposal}</a>
                </td>
                <td rowspan="${rowSpan}"><span class="${statusRequest.statusClass}"> ${statusRequest.statusText}</span></td>
                <td rowspan="${rowSpan}">
                    <button class="btn btn-sm btn-outline-info" id="detailData" data-id="${item.id}"><i class="fa-solid fa-eye"></i></button>
                    <button class="btn btn-sm btn-outline-primary ${disableClass}" id="approve" data-id="${item.id}" ${!isWaiting ? 'disabled' : ''}><i class="fa-solid fa-check"></i></button>
                    <button class="btn btn-sm btn-outline-danger ${disableClass}" id="reject" data-id="${item.id}" ${!isWaiting ? 'disabled' : ''}><i class="fa-solid fa-x"></i></button>
                </td>
            </tr>
        `;
        $("#loadData tbody").append(row);

        item.grup.member_grup.slice(1).forEach(function (member) {
            let memberRow = `
                <tr>
                    <td><strong class="fw-bold fs-10">${member.nik}</strong><br> ${member.name}</td>
                </tr>
            `;
            $("#loadData tbody").append(memberRow);
        });
    });
}


    function filterAndPaginateData() {
        const filteredData = dataCache.filter(item => {
            const searchString = `
                ${item.date}
                ${item.grup.grup_name}
                ${item.grup.member_grup.map(member => `${member.nik} ${member.name}`).join(" ")}
                ${item.description}
                ${item.file_proposal}
                ${item.status_submissions}
            `.toLowerCase();

            return searchString.includes(searchQuery.toLowerCase());
        });

        const totalPages = Math.ceil(filteredData.length / pageSize);

        if (filteredData.length === 0) {
            $("#loadData tbody").empty();
            $("#loadData tbody").append(`
                <tr>
                    <td colspan="8" class="text-center"><i class="fa-solid fa-face-sad-tear px-1"></i>Data tidak ditemukan</td>
                </tr>
            `);
            return;
        }

        renderTable(filteredData);

        $("#currentPage").text(currentPage);
        $("#prevPage").prop("disabled", currentPage === 1);
        $("#nextPage").prop("disabled", currentPage === totalPages);
    }

    function fetchData() {
        $.ajax({
            url: `/v1/submissions`,
            method: "GET",
            dataType: "json",
            success: function(response) {
                if (response.code === 200 && response.data) {
                    dataCache = response.data;
                    filterAndPaginateData();
                }else{
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

    $("#searchInput").on("input", function() {
        searchQuery = $(this).val();
        currentPage = 1;
        filterAndPaginateData();
    });

    $("#pageSizeSelect").on("change", function() {
        pageSize = parseInt($(this).val());
        currentPage = 1;
        filterAndPaginateData();
    });

    $("#prevPage").on("click", function() {
        if (currentPage > 1) {
            currentPage--;
            filterAndPaginateData();
        }
    });

    $("#nextPage").on("click", function() {
        const totalPages = Math.ceil(dataCache.length / pageSize);
        if (currentPage < totalPages) {
            currentPage++;
            filterAndPaginateData();
        }
    });

    fetchData();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $(document).on("click", "#detailData", function() {
        const id = $(this).data("id");

        function getStatusMember(status) {
            switch (status) {
                case 'marry':
                    return 'Kawin';  // Menambahkan 'return' agar nilai dikembalikan
                case 'single':  // Perbaikan typo: 'singgle' menjadi 'single'
                    return 'Belum Kawin';
                case 'divorced alive':
                    return 'Cerai Hidup';
                case 'divorced dead':
                    return 'Cerai Mati';
                default:
                    return 'Not Found';  // Menambahkan return pada default case
            }
        }

        $.ajax({
            url: `v1/submissions/get/${id}`,
            method: "GET",
            dataType: "json",
            success: function(response) {
                if (response.code === 200 && Array.isArray(response.data) && response.data.length > 0) {
                    const data = response.data[0];
                    console.log(data);

                    const statusInfo = getStatusInfo(data.status_submissions);
                    let fileProposalUrl = '/uploads/file-proposal-pengajuan/' + data.file_proposal;

                    // Fill modal fields
                    $("#detailDate").text(formatDate(data.date));
                    $("#detailGroupName").text(data.grup.grup_name);
                    $("#detailDescription").text(data.description);
                    $("#detailFileProposal").text(data.file_proposal).attr("href", fileProposalUrl);
                    $("#detailStatus").text(statusInfo.statusText).attr("class", statusInfo.statusClass);

                    // Populate member list table
                    const memberListTable = $("#memberListTable tbody");
                    memberListTable.empty();
                    data.grup.member_grup.forEach((member, index) => {
                        let statusMember = getStatusMember(member.status);
                        memberListTable.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td><strong class="fw-bold fs-10">${member.nik}</strong><br> ${member.name}</td>
                                <td><strong class="fw-bold fs-10">${member.place_birth}</strong><br> ${formatDate(member.date_birth)}</td>
                                <td>${statusMember}</td>
                                <td>${member.address}</td>
                            </tr>
                        `);
                    });

                    $("#detailDataModal").modal("show");
                } else {
                    alert("Data tidak ditemukan.");
                }
            },
            error: function() {
                alert("Gagal mengambil data detail.");
            }
        });
    })

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

    $(document).on('click', '#approve', function () {
        const id = $(this).data('id');
        console.log(id);

        confirmAlert('Apakah Anda yakin ?', function () {
            handleApproveReject(id, 'approve');
        });
    });

    $(document).on('click', '#reject', function () {
        const id = $(this).data('id');
        confirmAlert('Apakah Anda yakin ?', function () {
            handleApproveReject(id, 'reject');
        });
    });


    function handleApproveReject(id, action) {
        $.ajax({
            url: `v1/submissions/approve-reject/${id}`,
            type: 'POST',
            data: JSON.stringify({ action: action }),
            contentType: 'application/json',
            success: function (response) {
                console.log(response);
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

})

</script>


@endsection
