<?php

namespace Application\UserModule\Repository;
use Application\UserModule\Model\UserModel;
use Application\CoreModule\Repository\CoreRepository;

/**
 * UserRepository class.
 *
 * This class handles user-related database Fetch operations.
 * 
 * Author: Rufus Mathew
 * Version: 1.0
 *  @since 2025-06-15
 */
class UserRepository extends CoreRepository
{
    /**
     * Constructor.
     *
     * @param UserModel $model
     */
    public function __construct(UserModel $model)
    {
        parent::__construct($model);
    }

    /**
     * Get a single user by ID.
     *
     * @param int $id
     * @return UserModel|null
     */
    public function getSingleData($attributes, $options): ?UserModel
    {
        $query = $this->getQuery();
        if (!empty($attributes)) {
            $query = $query->select($attributes);

        }
        $query->where($options);
        return $query->first();
    }
}