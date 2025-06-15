<?php

namespace Application\Attendence\Service;

use Application\Attendence\Repository\AttendenceRepository;
use Application\CoreModule\Service\CoreService;

class AttendenceService extends CoreService
{
    protected $attendenceRepository;

    public function __construct(AttendenceRepository $attendenceRepository)
    {
        $this->attendenceRepository = $attendenceRepository;
    }

    /**
     * Get all attendances with optional filters and pagination.
     *
     * @param array $params
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllAttendences(array $params)
    {
        try {
            return $this->attendenceRepository->getAllAttendences($params);
        } catch (\Exception $e) {
            // Handle exception, log error, etc.
            throw new \Exception($e);
        }
    }

    /**
     * Create a new attendance record.
     *
     * @param array $data
     * @return Model Entered attendance record.
     */
    public function createBulkAttendence(array $data)
    {
        try {
            $data['attendences'] = array_map(function ($attendance) use ($data) {
                return [
                    'student_id' => $attendance['student_id'],
                    'attendance_date' => $data['attendance_date'],
                    'status' => $attendance['status'] ?? 'absent', 
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['attendences']);

            // Validate the data before saving
            $checkExistingAttendence = $this->attendenceRepository->checkExistingAttendence($data['attendences']);
            if ($checkExistingAttendence) {
                // If any attendance record already exists, throw an exception
                throw new \Exception('Attendance record already exists for the given student and date.');
            } else {
                return $this->attendenceRepository->saveBulkData($data['attendences']);
            }
            
        } catch (\Exception $e) {
            // Handle exception, log error, etc.
            throw new \Exception($e);
        }
    }

    /**
     * Update an existing attendance record.
     *
     * @param int $id
     * @param array $data
     * @return \Application\Attendence\Model\AttendenceModel|null
     */
    public function updateAttendence(int $id, array $data)
    {
        try {
            $attendance = $this->attendenceRepository->getDetailsById($id);
            if (!$attendance) {
                throw new \Exception('Attendance record not found.');
            }

            // Update the attendance record with the provided data
            $attendance->fill($data);
            $attendance->save();

            return $attendance;
        } catch (\Exception $e) {
            // Handle exception, log error, etc.
            throw new \Exception($e);
        }
    }

    /**
     * Function to save Single Attendance Record
     * @param array $data data to be inserted
     *  @return bool true on success, false on failure
     * @throws \Exception
     */
    public function saveSingleAttendence(array $data)
    {
        try {
            $attendance = $this->attendenceRepository->getQuery()
                ->where('student_id', $data['student_id'])
                ->where('attendance_date', $data['attendance_date'])
                ->first();

            if (!$attendance) {
                // If attendance record does not exist, create a new one
                $data['created_at'] = now();
                $data['updated_at'] = now();
                return $this->attendenceRepository->insertQuery($data);
            } else {
                // If attendance record exists, update it
                $attendance->status = $data['status'] ?? 'absent';
                $attendance->updated_at = now();
                return $attendance->save();
            }
        } catch (\Exception $e) {
            // Handle exception, log error, etc.
            throw new \Exception($e);
        }
    }
}   