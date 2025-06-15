<?php
namespace Application\CoreModule\Controller;
use App\Http\Controllers\Controller;

class CoreController extends Controller
{
    /**
     * CoreController is the base controller for the application.
     * It provides common functionality and can be extended by other controllers.
     * 
     * Author: Rufus Mathew
     * @version 1.0
     * @since 2025-06-15
     */

    public function __construct()
    {
        // Initialize any common properties or methods here
        // This constructor can be extended by child controllers
    }

    /**
     * Function to Handle Validation Error Messages
     * 
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'attendance_date.required' => 'The attendance date field is required.',
            'attendance_date.date' => 'The attendance date must be a valid date.',
            'attendences.required' => 'The attendences field is required.',
            'attendences.array' => 'The attendences must be an array.',
            'attendences.*.student_id.required' => 'The student ID field is required.',
            'attendences.*.student_id.integer' => 'The student ID must be an integer.',
            'attendences.*.student_id.exists' => 'The selected student ID does not exist.',
            'attendences.*.status.string' => 'The status must be a string.',
            'attendences.*.status.in' => 'The status must be one of the following: present, absent.'
        ];
    }

    /**
     * Function to Handle Bad Request Responses
     * 
     * @param array $errors
     * @return {JSONResponse} Response with error messages
     */
    protected function badRequestResponse($errors, $message = 'Bad Request')
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Bad Request',
            'errors' => $errors
        ], 400);
    }

    /**
     * Function to Handle Success Responses
     * 
     * @param mixed $data
     * @param string $message
     * @return {JSONResponse} Response with success message and data
     */
    protected function successResponse($data, $message = 'Success')
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], 200);
    }

    /**
     * Function to Handle Internal Server Error Responses
     * 
     * @param string $message
     * @return {JSONResponse} Response with error message
     */
    protected function internalServerErrorResponse($message = 'Internal Server Error')
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], 500);
    }

    /**
     * Function to Handle Not Found Responses
     *
     * @param string $message
     * @return {JSONResponse} Response with not found message
     */
    protected function responseNotFound($message = 'Not Found')
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], 404);
    }
}