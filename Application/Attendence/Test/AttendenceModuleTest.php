<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Application\Attendence\Service\AttendenceService;
use Application\Attendence\Controller\AttendenceController;
use Illuminate\Http\Request;

class AttendenceControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $attendenceService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->attendenceService = $this->createMock(AttendenceService::class);
    }

    /** @test */
    // public function it_retrieves_all_students_attendance_successfully()
    // {
    //     $controller = new AttendenceController($this->attendenceService);
    //     $request = Request::create('/attendences', 'GET', [
    //         'order' => 'asc', 'filter' => [], 'search' => '', 'page' => 1, 'per_page' => 10
    //     ]);

    //     $response = $controller->getAllStudentsAttendence($request);
    //     $this->assertEquals(200, $response->status());
    // }

    /** @test */
    public function it_marks_bulk_attendance_successfully()
    {
        $controller = new AttendenceController($this->attendenceService);
        $request = Request::create('/mark-bulk-attendance', 'POST', [
            'attendance_date' => now()->toDateString(),
            'attendences' => [
                [
                    'student_id' => 1, 
                    'status' => 'present'
                ],
                [
                    'student_id' => 2,
                    'status' => 'absent'
                ],
                [
                    'student_id' => 3,
                    'status' => 'present'
                ],
                [
                    'student_id' => 4,
                    'status' => 'absent'
                ]
            ]
        ]);

        $response = $controller->markBulkAttendence($request);
        print_r($response->getContent());
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_marks_attendance_for_a_single_student_successfully()
    {
        $controller = new AttendenceController($this->attendenceService);
        $request = Request::create('/mark-attendance', 'POST', [
            'attendance_date' => now()->toDateString(),
            'student_id' => 1,
            'status' => 'present'
        ]);

        $response = $controller->markAttendence($request);
        print_r($response->getContent());
       $this->assertEquals(200, $response->status());
    }
}