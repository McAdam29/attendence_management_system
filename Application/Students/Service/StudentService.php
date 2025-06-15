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
        return $this->studentRepo->create($data);
    }

    /**
     * Get all students.
     *
     * @param array $options
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllStudents(array $options = [])
    {
        return $this->studentRepo->getList($options);
    }

    /**
     * Find a student by ID.
     *
     * @param int $id
     * @return \Application\Students\Model\StudentModel|null
     */
    public function getStudentById(int $id)
    {
        return $this->studentRepo->getDetailsById($id);
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
        $student = $this->getStudentById($id);
        if (!$student) {
            throw new \Exception('Student not found');
        }
        return $this->studentRepo->update($id, $data);
    }
}

    