<?php

namespace Application\Attendence\Controller;

use Application\CoreModule\Controller\CoreController;
use Application\Attendence\Service\AttendenceService;
use Illuminate\Http\Request;

class AttendenceController extends CoreController
{
    protected $attendenceService;

    public function __construct(AttendenceService $attendenceService)
    {
        $this->attendenceService = $attendenceService;
    }

    public function getAllStudentsAttendence(Request $request)
    {
        try {
            $getRequest = $request->only(['order', 'filter', 'search', 'page', 'per_page']);
            $attendences = $this->attendenceService->getAllAttendences($getRequest);
            if ($attendences->isEmpty()) {
                return $this->responseNotFound('No attendances found');
            } else  {
                return $this->responseSuccess($attendences, 'Attendances retrieved successfully');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve attendances'], 500);
        }
        return response()->json($attendences);
    }

    public function markBulkAttendence(Request $request)
    {
        try {
            $data = $request->only(['attendance_date', 'attendences']);
            $validator = \Validator::make($data, [
                'attendance_date' => 'required|date',
                'attendences' => 'required|array',
                'attendences.*.student_id' => 'required|integer|exists:students,id',
                'attendences.*.status' => 'nullable|string|in:present,absent',
            ], $this->validationErrorMessages());
            $createdAttendences = $this->attendenceService->createBulkAttendence($data);
            return $this->successResponse($createdAttendences, 'Bulk attendance marked successfully');
        } catch (\Exception $e) {
            return $this->badRequestResponse($e->getMessage(), 'Failed to mark bulk attendance');
        }
    }
}