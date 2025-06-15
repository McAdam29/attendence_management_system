<?php
namespace Application\CoreModule\Repository;
use Application\CoreModule\Model\CoreModel;
use Illuminate\Database\Eloquent\Collection;

class CoreRepository
{
    protected $model;

    public function __construct(CoreModel $model)
    {
        $this->model = $model;
    }

    /**
     * Function to get query
     * 
     * @return Model
     */
    public function getQuery()
    {
        return $this->model;
    }

    /**
     * Get all records.
     *
     * @return Collection
     */
    public function getList($options = []): Collection
    {
        try {
            $query = $this->getQuery();
            if (isset($options['groupBy'])) {
                $query = $query->groupBy($options['groupBy']);
            } else if (isset($options['limit'])) {
                $query = $query->limit($options['limit']);
            } else if (isset($options['paginate'])) {
                $query = $query->paginate($options['paginate']);
            } else if (isset($options['orderBy'])) {
                $query = $query->orderBy($options['orderBy'], $options['direction'] ?? 'asc');
            } else if (isset($options['where'])) {
                $query = $query->where($options['where']);
            } else if (isset($options['whereIn'])) {
                $query = $query->whereIn($options['whereIn']['column'], $options['whereIn']['values']);
            } else if (isset($options['whereNotIn'])) {
                $query = $query->whereNotIn($options['whereNotIn']['column'], $options['whereNotIn']['values']);
            } else if (isset($options['select'])) {
                $query = $query->select($options['select']);
            } else if (isset($options['with'])) {
                $query = $query->with($options['with']);
            } else if (isset($options['whereNull'])) {
                $query = $query->whereNull($options['whereNull']);
            } else if (isset($options['whereNotNull'])) {
                $query = $query->whereNotNull($options['whereNotNull']);
            } else if (isset($options['whereBetween'])) {
                $query = $query->whereBetween($options['whereBetween']['column'], $options['whereBetween']['values']);
            } else if (isset($options['whereDate'])) {
                $query = $query->whereDate($options['whereDate']['column'], $options['whereDate']['value']);
            } else if (isset($options['orWhere'])) {
                $query = $query->orWhere($options['orWhere']);
            } else if (isset($options['whereRaw'])) {
                $query = $query->whereRaw($options['whereRaw']);
            } else if (isset($options['having'])) {
                $query = $query->having($options['having']);
            } else if (isset($options['distinct'])) {
                $query = $query->distinct();
            } else if (isset($options['count'])) {
                return $query->count();
            } else if (isset($options['sum'])) {
                return $query->sum($options['sum']);
            } else if (isset($options['avg'])) {
                return $query->avg($options['avg']);
            } else if (isset($options['max'])) {
                return $query->max($options['max']);
            } else if (isset($options['min'])) {
                return $query->min($options['min']);
            } else {
                foreach ($options as $key => $value) {
                    if (method_exists($query, $key)) {
                        $query->$key($value);
                    }
                }
            }

            return $query->get();

        } catch (\Exception $e) {
            // Handle exception
            throw new \Exception('Error in fetching records: ' . $e->getMessage());
        }
    }

    /**
     * Find a record by ID.
     *
     * @param int $id
     * @return CoreModel|null
     */
    public function getDetailsById(int $id): ?CoreModel
    {
        try {
            return $this->model->find($id);
        } catch (\Exception $e) {
            // Handle exception
            throw new \Exception('Error in finding record: ' . $e->getMessage());
        }
    }

    /**
     * Create a new record.
     *
     * @param array $data
     * @return CoreModel
     */
    public function insertQuery(array $data): CoreModel
    {
        try {
            return $this->model->create($data);
        } catch (\Exception $e) {
            // Handle exception
            throw new \Exception('Error in inserting record: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing record.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateQuery($whereCondition, $data): bool
    {
        try {
            $record = $this->model->where($whereCondition)->first();
            if ($record) {
                return $record->update($data);
            }
            return false;
        } catch (\Exception $e) {
            // Handle exception
            throw new \Exception('Error in updating record: ' . $e->getMessage());
        }
    }

    /**
     * Delete a record.
     *
     * @param int $id
     * @return bool|null
     * @throws \Exception 
     */
    public function delete(int $id): ?bool
    {
        try {
            $record = $this->model->find($id);
            if ($record) {
                return $record->delete();
            }
            return null;
        } catch (\Exception $e) {
            // Handle exception
            throw new \Exception('Error deleting record: ' . $e->getMessage());
        }
    }

    /**
     * Function to Save Bulk Data
     * @param array $data data to be inserted
     * @return bool true on success, false on failure
     * @throws \Exception
     */
    public function saveBulkData($data): bool
    {
        try {
            $this->model->insert($data);
            return true;
        } catch (\Exception $e) {
            // Handle exception
            throw new \Exception($e);
        }
    }
}