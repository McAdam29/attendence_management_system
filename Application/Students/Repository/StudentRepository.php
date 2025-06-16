<?php
namespace Application\Students\Repository;

use Application\CoreModule\Repository\CoreRepository;
use Application\Students\Model\StudentModel;
/**
 * StudentRepository class handles database operations related to students.
 *
 * @package Application\Students\Repository
 * @author Your Name
 * @version 1.0
 * @since 2025-06-15
 */
class StudentRepository extends CoreRepository
{
    /**
     * Constructor to initialize the repository.
     */
    public function __construct(StudentModel $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }
    
    
    /**
     * Get Raw Query
     */
    public function getRawQuery()
    {
        return $this->model;
    }

    /**
     * Create a new student record.
     *
     * @param array $data
     * @return StudentModel
     */
    public function create(array $data)
    {
        return $this->model()::create($data);
    }

    /**
     * Get all students with optional filtering and pagination.
     *
     * @param array $options
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(array $options = [])
    {
        return $this->model()::all();
    }
    /**
     * Get a student by ID.
     *
     * @param int $id
     * @return StudentModel|null
     */
    public function getById(int $id)
    {
        return $this->model()::find($id);
    }
    /**
     * Update a student record.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data)
    {
        $student = $this->getById($id);
        if ($student) {
            return $student->update($data);
        }
        return false;
    }
    /**
     * Delete a student record.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {
        $student = $this->getById($id);
        if ($student) {
            return $student->delete();
        }
        return false;
    }
}