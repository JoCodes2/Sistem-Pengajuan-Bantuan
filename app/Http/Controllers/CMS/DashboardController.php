<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Repositories\MemberGrupRepositories;
use App\Traits\HttpResponseTraits;
use Illuminate\Http\Request;
use App\Models\MemberGrup;


class DashboardController extends Controller
{
    use HttpResponseTraits;

    protected $memberGrupRepo;

    public function __construct(MemberGrupRepositories $memberGrupRepo)
    {
        $this->memberGrupRepo = $memberGrupRepo;
    }

    // Mengambil jumlah pengajuan
    public function getSubmissionCount()
    {
        try {
            // Hitung jumlah pengajuan
            $count = Submission::count();
            $countApproved = Submission::where('status_submissions', 'approved')->count();

            // Berikan respon JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Total submissions count retrieved successfully.',
                'data' => [
                    'total_submissions' => $count,
                    'total_approved_submissions' => $countApproved
                ],
            ], 200);
        } catch (\Throwable $th) {
            // Tangani error
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    // Method to get the total number of members
    public function getMemberCount()
    {
        try {
            // Calculate total number of members directly from the MemberGrup model
            $count = MemberGrup::count();

            // Return the result as JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Total members count retrieved successfully.',
                'data' => [
                    'total_members' => $count,
                ],
            ], 200);
        } catch (\Throwable $th) {
            // Handle errors and return the error message
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
