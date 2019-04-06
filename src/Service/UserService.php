<?php
/**
 * Created by IntelliJ IDEA.
 * User: hentschel
 * Date: 22.07.13
 * Time: 11:38
 * To change this template use File | Settings | File Templates.
 */

namespace Camunda\Service;

use Camunda\Client;
use Exception;
use Camunda\Request\CredentialsRequest;
use Camunda\Request\ProfileRequest;
use Camunda\Request\UserRequest;
use Camunda\Response\ResourceOption;
use Camunda\Response\User;

class UserService
{

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

  /**
   * Create a new user
   * @link http://docs.camunda.org/api-references/rest/#!/user/post-create
   *
   * @param UserRequest $request user properties
   * @throws \Exception
   */
    public function createUser(UserRequest $request)
    {
        $this->client->setRequestUrl('/user/create');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('POST');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Removes a User
     * @link http://docs.camunda.org/api-references/rest/#!/user/delete
     *
     * @param String $id user ID
     * @throws \Exception
     */
    public function deleteUser($id)
    {
        $this->client->setRequestUrl('/user/'.$id);
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('DELETE');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieves the profile of a given user
     * @link http://docs.camunda.org/api-references/rest/#!/user/get
     *
     * @param String $id user ID
     * @throws \Exception
     * @return \Camunda\Response\User $this requested profile
     */
    public function getProfile($id)
    {
        $this->client->setRequestUrl('/user/'.$id.'/profile');
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('GET');

        $user = new User();
        try {
            return $user->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieves a list of users within a given context
     * @link http://docs.camunda.org/api-references/rest/#!/user/get-query
     *
     * @param UserRequest $request filter parameters
     * @throws \Exception
     * @return object list of requested users
     */
    public function getUsers(UserRequest $request)
    {
        $this->client->setRequestUrl('/user/');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('GET');

        try {
            $prepare = $this->client->execute();
            $response = array();
            foreach ($prepare as $index => $data) {
                $user = new User();
                $response['user_' . $index] = $user->cast($data);
            }
            return (object)$response;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieves the amount of users within a given context
     * @link http://docs.camunda.org/api-references/rest/#!/user/get-query-count
     *
     * @param UserRequest $request filter parameters
     * @throws \Exception
     * @return int Amount of users
     */
    public function getCount(UserRequest $request)
    {
        $this->client->setRequestUrl('/user/count');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('GET');

        try {
            return $this->client->execute()->count;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Updates the profile of a given user
     * @link http://docs.camunda.org/api-references/rest/#!/user/put-update-profile
     *
     * @param String $id user ID
     * @param ProfileRequest $request user properties
     * @throws \Exception
     */
    public function updateProfile($id, ProfileRequest $request)
    {
        $this->client->setRequestUrl('/user/'.$id.'/profile');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('PUT');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * update credentials of a single user
     * @link http://docs.camunda.org/api-references/rest/#!/user/put-update-credentials
     *
     * @param String $id user ID
     * @param CredentialsRequest $request credential properties
     * @throws \Exception
     */
    public function updateCredentials($id, CredentialsRequest $request)
    {
        $this->client->setRequestUrl('/user/'.$id.'/credentials');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('PUT');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * allows checking for the set of available operations that the currently authenticated user can perform on the user
     * resource
     * @link http://docs.camunda.org/latest/api-references/rest/#user-user-resource-options
     *
     * @throws \Exception
     * @return ResourceOption $this
     */
    public function getResourceOption()
    {
        $resourceOption = new ResourceOption();
        $this->client->setRequestUrl('/user');
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('OPTIONS');

        try {
            return $resourceOption->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * allows checking for the set of available operations that the currently authenticated user can perform on the user
     * resource
     * @link http://docs.camunda.org/latest/api-references/rest/#user-user-resource-options
     *
     * @param String $id user ID
     * @throws \Exception
     * @return ResourceOption $this
     */
    public function getResourceInstanceOption($id)
    {
        $requestOption = new ResourceOption();
        $this->client->setRequestUrl('/user/'.$id);
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('OPTIONS');

        try {
            return $requestOption->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }
}
