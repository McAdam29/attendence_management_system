<?php
namespace Application\Students\Controller;

use Illuminate\Http\Request;
use Application\CoreModule\Controller\CoreController;
use Application\Students\Service\StudentService;
class StudentController extends CoreController
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        parent::__construct();
        $this->studentService = $studentService;
    }

    /**
     * Controller Function to handle HTTP request for adding a new student
     *
     * @param {Request} $request HTTP request containing student data
     * @return {JSON} JSON response with student addition status
     */
    public function addStudent(Request $request)
    {
        try {
            $getRequestedData = $request->only(['student_name', 'department', 'enrollment_date']);
            // Validate the request data
            $validatedData = $request->validate([
                'student_name' => 'required|string|max:255',
                'department' => 'required|string|max:255',
                'enrollment_date' => 'required|string|max:255',
            ], $this->validationErrorMessages());

            if (!$validatedData) {
                throw new \InvalidArgumentException($getRequestedData->messages());
            }

            $studentDetails = [
                'student_name' => $getRequestedData['student_name'],
                'department' => $getRequestedData['department'],
                'enrollment_date' => $getRequestedData['enrollment_date'],
            ];

            $savedStudent = $this->studentService->createNewStudent($studentDetails);
            if (!$savedStudent) {
                return $this->badRequestResponse('Student addition failed', 'Error in saving student data');
            } else {
                return $this->successResponse($savedStudent, 'Student added successfully');
            }
        } catch (\Exception $e) {
            return $this->badRequestResponse($e->getMessage(), 'Error in request data');
        }
    }

    /**
     * Controller Function to handle HTTP request for getting all students
     *
     * @param {Request} $request HTTP request containing filter and pagination data
     * @return {JSON} JSON response with list of students
     */
    public function getAllStudents(Request $request)
    {
        try {
            $getRequest = $request->only(['order', 'filter', 'search', 'page', 'per_page']);
            $students = $this->studentService->getAllStudents($getRequest);
            if ($students->isEmpty()) {
                return $this->responseNotFound('No students found');
            } else {
                return $this->responseSuccess($students, 'Students retrieved successfully');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve students'], 500);
        }
    }

    /**
     * Controller Function to handle HTTP request for getting a student by ID
     *
     * @param {int} $id Student ID
     * @return {JSON} JSON response with student details
     */
    public function getStudentById($id)
    {
        try {
            $student = $this->studentService->getStudentById($id);
            if (!$student) {
                return $this->responseNotFound('Student not found');
            } else {
                return $this->responseSuccess($student, 'Student retrieved successfully');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve student'], 500);
        }
    }
}