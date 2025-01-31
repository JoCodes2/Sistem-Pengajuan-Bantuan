@extends('Layouts.Base')

@section('content')
    <div class="container my-5">
        <div class="row">
            <!-- Heading -->
            <div class="col-12 text-center mb-4">
                <h1 class="fw-bold">Dashboard</h1>
                <p class="text-muted">Selamat datang di dashboard! Pantau data pengajuan bantuan dan anggota di sini.</p>
            </div>
        </div>

        <!-- Card Section -->
        <div class="row">
            <!-- Total Submissions Card -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-file-alt fa-3x text-primary mb-3"></i>
                        <h5 class="card-title fw-bold">Total Pengajuan</h5>
                        <h2 id="total-submissions" class="display-4 fw-bold">0</h2>
                        <p class="text-muted">Jumlah total pengajuan yang terdaftar.</p>
                    </div>
                </div>
            </div>

            <!-- Total Members Card -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Anggota Terdaftar</h5>
                        <h2 id="total-members" class="display-4 fw-bold">0</h2>
                        <p class="text-muted">Jumlah anggota yang telah bergabung.</p>
                    </div>
                </div>
            </div>

            <!-- Example Placeholder for Another Card -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-3x text-info mb-3"></i>
                        <h5 class="card-title fw-bold">Pengajuan Disetujui</h5>
                        <h2 class="display-4 fw-bold" id="statusApproved"></h2>
                        <p class="text-muted">Jumlah pengajuan yang telah disetujui.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Fetch total submissions count via AJAX
            $.ajax({
                url: '/dashboard/submissions-count',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#total-submissions').text(response.data.total_submissions);
                        $('#statusApproved').text(response.data.total_approved_submissions);
                    } else {
                        console.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });

            // Fetch total members count via AJAX
            $.ajax({
                url: '/dashboard/members-count',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#total-members').text(response.data.total_members);
                    } else {
                        console.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    </script>
@endsection
