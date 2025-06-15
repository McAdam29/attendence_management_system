<?php

namespace Application\Attendence\Repository;

use Application\CoreModule\Repository\CoreRepository;
use Application\Attendence\Model\AttendenceModel;


/**
 * AttendenceRepository class.
 *
 * This class handles attendance-related database fetch operations.
 * 
 * Author: Rufus Mathew
 *  Version: 1.0
 *  @since 2025-06-15
 */
class AttendenceRepository extends CoreRepository
{
    /**
     * Constructor.
     *
     * @param AttendenceModel $model
     */
    public function __construct(AttendenceModel $model)
    {
        parent::__construct($model);
    }

    /**
     * Get Raw Query Builder instance.
     */
    public function getQuery()
    {
        return $this->model->newQuery();
    }
    /**
     * Get all attendances with optional filters and pagination.
     *
     * @param array $params
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllAttendences(array $params)
    {
        $query = $this->getQuery();
        $query->with('student')->select('attendence.*', 'students.name as student_name', 'students.department as department');

        // Apply filters if provided
        if (isset($params['student_id'])) {
            $query->where('student_id', $params['student_id']);
        }
        if (isset($params['attendance_date'])) {
            $query->whereDate('attendance_date', $params['attendance_date']);
        }
        // Apply pagination if specified
        if (isset($params['per_page']) && is_numeric($params['per_page'])) {
            return $query->paginate($params['per_page']);
        }

        return $query->get();
    }

    /**
     * Check if an attendance record already exists for a given student and date.
     *  @param array $data
     * 
     */
    public function checkExistingAttendence(array $data)
    {
        $getQuery = $this->getQuery();
        $existingAttendences = $getQuery->whereIn('student_id', array_column($data, 'student_id'))
            ->whereIn('attendance_date', array_column($data, 'attendance_date'))
            ->get();

        return $existingAttendences->toArray();
    }
}