<?php
use Tests\TestCase;
use App\Http\Controllers\BackendControllers\AssignmentController;
use App\Models\Assignment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AssignmentControllerTest extends TestCase
{
   

    public function testStore()
    {
     

        $file = UploadedFile::fake()->create('document.pdf', 1024);

        $response = $this->post(route('assignment.store'), [
            'class' => 'ten',
            'section' => 'A',
            'assignment' => 'Assignment 1',
            'assign_date' => '2023-06-22',
            'submission_date' => '2023-06-30',
            'assignment_id' => 6001,
            'subject' => 'Bangla',
            'assignment_description' => 'Description of the assignment',
            'assignment_status' => 1,
            'status' => 1,
            'attached_file' => $file,
        ]);

        $response->assertRedirect(route('assignment.index'));

        $this->assertDatabaseHas('assignments', [
            'class' => 'ten',
            'section' => 'A',
            'assignment' => 'Assignment 1',
            'assign_date' => '2023-06-22',
            'submission_date' => '2023-06-30',
            'assignment_id' => 6001,
            'subject' => 'Bangla',
            'assignment_description' => 'Description of the assignment',
            'assignment_status' => 1,
            'status' => 1,
            'created_by' => $user->id,
        ]);
    }
}
