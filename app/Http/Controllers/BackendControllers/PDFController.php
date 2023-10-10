<?php

namespace App\Http\Controllers\BackendControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Task;
use App\Models\Sbu;
use App\Models\User;


class PDFController extends Controller
{
    public function generatePDF(Request $request)
{
    // Fetch data to pass to the PDF view
    $data = [
        'taskall' => Task::all(), 
    ];

    $pdf = PDF::loadView('pdf.templete', $data);

    return $pdf->download('task-overall-report.pdf');
}

}
