<?php
namespace Application\CoreModule\Service;

use Application\CoreModule\Repository\CoreRepository;
use Illuminate\Support\Facades\Hash;


class CoreService {

    protected $repository;

    public function __construct(CoreRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Function to get encypted password
     * 
     * @param {string} $password
     * @return {string} Encrypted password
     */
    public function hashPassword(string $password): string
    {
        $encryptedPassword = '';
        if (empty($password)) {
            throw new \InvalidArgumentException('Password cannot be empty');
        } else {
            $encryptedPassword = Hash::make($password);
        }
        return $encryptedPassword;
    }

    /**
     * Function to create aliasId for a user
     */
    public function createAliasId($name, $email): string
    {
        $aliasId =  strtolower(str_replace(' ', '_', $name)) . '_' . substr(md5($email), 0, 8);
        $aliasId = Hash::make($aliasId);
        return $aliasId;
    }
}