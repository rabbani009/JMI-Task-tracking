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
use App\Models\StageTrack;


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


  



public function generateallPDF($task_id)
{
    // Fetch the task data based on $task_id
    $taskData = StageTrack::where('task_id', $task_id)->get();

    $task = Task::where('task_id', $task_id)->first();

    $customPaper = array(0, 0, 595.276, 841.890);

    // Load the PDF view with data from the "pdf" directory
    $pdf = PDF::loadView('pdf.task_report', compact('taskData','task'))->setPaper($customPaper);

    // Generate and return the PDF
    return $pdf->stream('task_report.pdf');
}


}






