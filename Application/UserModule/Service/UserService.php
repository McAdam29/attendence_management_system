<?php
namespace Application\UserModule\Service;

use Application\UserModule\Repository\UserRepository;
use Application\CoreModule\Service\CoreService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
/**
 * UserService class handles user-related operations.
 *
 * @package Application\UserModule\Service
 *  @author Rufus Mathew 
 *  @version 1.0
 *  @since 2025-06-15
 */


class UserService extends CoreService
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        parent::__construct($userRepo);
        $this->userRepo = $userRepo;
    }

    /**
     * Get all users list.
     *
     * @param array $options
     * 
     * @return JSON Retrived users list.
     */
    public function getAllUsers($options = [])
    {
        try {
            $users = $this->userRepo->getList($options);
            return $users;
        } catch (\Exception $e) {
            throw new \Exception('Error retrieving users: ' . $e->getMessage());
        }
    }

    /**
     * Find a user by ID.
     *
     * @param int $id
     * @return \Application\UserModule\Model\UserModel|null
     */
    public function getUserById(int $id)
    {
        return $this->userRepo->getDetailsById($id);
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return \Application\UserModule\Model\UserModel
     */
    public function createNewUser(array $data)
    {
        try {
            if (empty($data['password'])) {
                throw new \InvalidArgumentException('Password cannot be empty');
            } else {
                $data['password'] = $this->hashPassword($data['password']);
                $data['aliasId'] = $this->createAliasId($data['name'], $data['email']);
            }
            $user = $this->userRepo->insertQuery($data);
            $userDetails = $user->getAttributes();
            if (!$user) {
                throw new \Exception('User creation failed');
            } else {
                return $userDetails;
            }
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }

    public function checkAndAuthenticateUser($credentials){
        try {
            $user = $this->userRepo->getSingleData(['aliasId', 'password'], ['email' => $credentials['email']]);
            if (!$user) {
                throw new \Exception('User not found');
            }

            if (!Hash::check($credentials['password'], $user->password)) {
                throw new \Exception('Invalid credentials');
            }
            $http = new Client([
                'verify' => false,   // Skip SSL verification (useful in local dev)
                'timeout' => 10,     // Fail the request instead of hanging
            ]);
            $response = $http->post(config('app.url') . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => '1',
                    'client_secret' => 'SHh7Iz2YXTJAicCxSOaAOZDRbBHoEkxNpknX9QRP',
                    'username' => $user->aliasId,
                    'password' =>  $credentials['password'],
                    'scope' => '',
                ],
            ]);
            $responseData = json_decode($response->getBody()->getContents(), true);
            print_r($responseData);
            return $user;
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }
}