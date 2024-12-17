@extends('Layouts.UiWeb')

@section('content')
    <div class="container mt-5 pt-5"> <!-- Tambahkan pt-5 untuk padding atas -->
        <h1 class="text-center">Daftar File Prosedur</h1>
        <p class="text-center">Klik tombol di bawah untuk mendownload file prosedur yang tersedia.</p>

        <div class="card-body">
            <table id="loadData" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>File Prosedur</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <!-- Data pengguna akan dimuat di sini -->
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function getData() {
                $.ajax({
                    url: '/v1/prosedur',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);

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
                                </tr>`;
                        });

                        $('#tbody').html(tableBody);
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
        });
    </script>
@endsection
