<?php
namespace Application\UserModule\Controller;

use Illuminate\Http\Request;
use Application\CoreModule\Controller\CoreController;
use Application\UserModule\Service\UserService;


class UserController extends CoreController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }
    /**
     * Controller Function to handle HTTP request for user registration
     * 
     * @param {Request} $request HTTP request containing user registration data
     * @return {JSON} JSON response with user registration status
     */
    public function registerNewUser(Request $request)
    {
        try {
            $getRequestedData = $request->only(['name', 'email', 'password']);
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|max:12',
            ], $this->validationErrorMessages());

            if(!$validatedData) {
                throw new \InvalidArgumentException($getRequestedData->messages());
            }

            $userdetails = [
                'name' => $getRequestedData['name'],
                'email' => $getRequestedData['email'],
                'password' => $getRequestedData['password'],
            ];

            $savedUser = $this->userService->createNewUser($userdetails);
            if (!$savedUser) {
                return $this->badRequestResponse('User registration failed', 'Error in saving user data');
            } else {
                return $this->successResponse($savedUser, 'User registered successfully');
            }
        } 
        catch (\Exception $e) {
            return $this->badRequestResponse($e->getMessage(), 'Error in request data');
        }
    }

    public function login(Request $request)
    {
        try {
            $getRequestedData = $request->only(['email', 'password']);
            // Validate the request data
            $validatedData = $request->validate([
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8|max:12',
            ], $this->validationErrorMessages());

            if(!$validatedData) {
                throw new \InvalidArgumentException($getRequestedData->messages());
            }

            // Here you would typically check the credentials against the database
            // For simplicity, let's assume a successful login
            $userDetails = $this->userService->checkAndAuthenticateUser($getRequestedData); // Example user ID 
            return $this->successResponse(['message' => 'Login successful'], 'User logged in successfully');
        }
        catch (\Exception $e) {
            return $this->badRequestResponse($e->getMessage(), 'Error in request data');
        }
    }
}