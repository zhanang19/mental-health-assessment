<?php

namespace App\Http\Controllers\User;

use App\Exports\StudentExport;
use App\Http\Controllers\Controller;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentExportController extends Controller
{
    private $userRepository;

    /**
     * @param \App\Repository\UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function export()
    {
        return Excel::download(new StudentExport(
            $this->userRepository->getStudents()
        ), 'students.xlsx');
    }
}
