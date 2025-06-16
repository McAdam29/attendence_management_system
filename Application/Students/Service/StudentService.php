<?php
namespace Application\Students\Service;

use Application\Students\Repository\StudentRepository;
use Application\CoreModule\Service\CoreService;
/**
 * StudentService class handles student-related operations.
 *
 * @package Application\Students\Service
 * @author Your Name
 * @version 1.0
 * @since 2025-06-15
 */
class StudentService extends CoreService
{
    protected $studentRepo;

    public function __construct(StudentRepository $studentRepo)
    {
        parent::__construct($studentRepo);
        $this->studentRepo = $studentRepo;
    }

    /**
     * Create a new student.
     *
     * @param array $data
     * @return \Application\Students\Model\StudentModel
     */
    public function createNewStudent(array $data)
    {
        try {
            // Validate the data
            if (empty($data['student_name']) || empty($data['department']) || empty($data['enrollment_date'])) {
                throw new \InvalidArgumentException('Invalid student data provided');
            }
            return $this->studentRepo->create($data);
        } catch (\Exception $e) {
            throw new \Exception('Error creating student: ' . $e->getMessage());
        }
    }

    /**
     * Get all students.
     *
     * @param array $options
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllStudents(array $options = [])
    {
        try {
            // Validate options if necessary
            if (!is_array($options)) {
                throw new \InvalidArgumentException('Options must be an array');
            }
            return $this->studentRepo->getAll($options);
        } catch (\Exception $e) {
            throw new \Exception('Error fetching students: ' . $e->getMessage());
        }
    }

    /**
     * Find a student by ID.
     *
     * @param int $id
     * @return \Application\Students\Model\StudentModel|null
     */
    public function getStudentById(int $id)
    {
        try {
            // Validate ID
            if (!is_int($id) || $id <= 0) {
                throw new \InvalidArgumentException('Invalid student ID provided');
            }
            return $this->studentRepo->findById($id);
        } catch (\Exception $e) {
            throw new \Exception('Error fetching student by ID: ' . $e->getMessage());
        }
    }
    /**
     * Update a student's details.
     *
     * @param int $id
     * @param array $data
     * @return \Application\Students\Model\StudentModel
     */
    public function updateStudent(int $id, array $data)
    {
        try {
            // Validate ID and data
            if (!is_int($id) || $id <= 0) {
                throw new \InvalidArgumentException('Invalid student ID provided');
            }
            if (empty($data['student_name']) || empty($data['department']) || empty($data['enrollment_date'])) {
                throw new \InvalidArgumentException('Invalid student data provided');
            }
            $student = $this->getStudentById($id);
            if (!$student) {
                throw new \Exception('Student not found');
            }
            return $this->studentRepo->update($id, $data);
        } catch (\Exception $e) {
            throw new \Exception('Error updating student: ' . $e->getMessage());
        }
    }

    /**
     * Delete a student by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteStudent(int $id)
    {
        try {
            $student = $this->getStudentById($id);
            if (!$student) {
                throw new \Exception('Student not found');
            }
            return $this->studentRepo->delete($id);
        } catch (\Exception $e) {
            throw new \Exception('Error deleting student: ' . $e->getMessage());
        }
    }
}

    