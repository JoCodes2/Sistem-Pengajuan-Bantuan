@extends('Layouts.Base')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>DATA USER</h5>
            <button type="button" class="btn btn-outline-primary" id="add-user" data-bs-toggle="modal"
                data-bs-target="#userModal">
                <i class='bx bxs-plus-circle'></i>
            </button>
        </div>
        <div class="table-responsive text-nowrap px-4 py-1">
            <table class="table" id="dataTableUser">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Password</th>
                        <th>Jabatan</th>
                        <th>Hak Akses</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">

                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            let dataTable = $("#dataTableUser").DataTable({
                "responsive": true,
                "lengthChange": true,
                "lengthMenu": [10, 20, 30, 40, 50],
                "autoWidth": false,
            });

            function getDataUsers() {
                $.ajax({
                    url: `/v1/user`,
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);

                        let tableBody = "";
                        $.each(response.data, function(index, item) {
                            tableBody += "<tr>";
                            tableBody += "<td>" + (index + 1) + "</td>";
                            tableBody += "<td>" + item.name + "</td>";
                            tableBody += "<td>" + item.password + "</td>";
                            tableBody += "<td>" + item.position + "</td>";
                            tableBody += "<td>" + item.role + "</td>";
                            tableBody += "<td >" +
                                "<button type='button' class='btn btn-outline-primary btn-sm edit-modal' data-toggle='modal' " +
                                "data-id='" + item.id + "'>" +
                                "<i class='bx bx-edit-alt'></i></button>" +
                                "<button type='button' class='btn btn-outline-danger btn-sm delete-confirm' data-id='" +
                                item.id + "'><i class='bx bx-trash' ></i></button>" +
                                "</td>";
                            tableBody += "</tr>";
                        });
                        let table = $("#dataTableUser").DataTable();
                        table.clear().draw();
                        table.rows.add($(tableBody)).draw();
                    },
                    error: function() {
                        console.log("Failed to get data from server");
                    }
                });
            }
            getDataUsers();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            

        })
    </script>
@endsection
