<?php
/**
 * Created by IntelliJ IDEA.
 * User: hentschel
 * Date: 22.07.13
 * Time: 11:37
 * To change this template use File | Settings | File Templates.
 */

namespace Camunda\Service;

use Camunda\Client;
use Exception;
use Camunda\Request\GroupRequest;
use Camunda\Response\Group;
use Camunda\Response\ResourceOption;

class GroupService
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
   * Create a new group
   * @link http://docs.camunda.org/api-references/rest/#!/group/post-create
   *
   * @param GroupRequest $request request body
   * @throws \Exception
   */
    public function createGroup(GroupRequest $request)
    {
        $this->client->setRequestUrl('/group/create');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('POST');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Add a member to a group.
     * @link http://docs.camunda.org/api-references/rest/#!/group/members/put
     *
     * @param String $id Group ID
     * @param String $userId User ID
     * @throws \Exception
     */
    public function addMember($id, $userId)
    {
        $this->client->setRequestUrl('/group/'.$id.'/members/'.$userId);
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('PUT');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Removes the group with given ID
     * @link http://docs.camunda.org/api-references/rest/#!/group/delete
     *
     * @param String $id Group ID
     * @throws \Exception
     */
    public function deleteGroup($id)
    {
        $this->client->setRequestUrl('/group/'.$id);
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('DELETE');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Revokes the membership of a group
     * @link http://docs.camunda.org/api-references/rest/#!/group/members/delete
     *
     * @param String $id Group ID
     * @param String $userId Member ID
     * @throws \Exception
     */
    public function removeMember($id, $userId)
    {
        $this->client->setRequestUrl('/group/'.$id.'/members/'.$userId);
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('DELETE');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieves a group with given id
     * @link http://docs.camunda.org/api-references/rest/#!/group/get
     *
     * @param String $id Group ID
     * @throws \Exception
     * @return Group $this Requested group
     */
    public function getGroup($id)
    {
        $this->client->setRequestUrl('/group/'.$id);
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('GET');

        $group = new Group();
        try {
            return $group->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieves a list of all groups within the given context
     * @link http://docs.camunda.org/api-references/rest/#!/group/get-query
     *
     * @param GroupRequest $request Filter parameters
     * @throws \Exception
     * @return object List of groups
     */
    public function getGroups(GroupRequest $request)
    {
        $this->client->setRequestUrl('/group/');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('GET');

        try {
            $prepare = $this->client->execute();
            $response = array();
            foreach ($prepare as $index => $data) {
                $group = new Group();
                $response['group_'.$index] = $group->cast($data);
            }
            return (object)$response;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieves the amount of Groups within the given context.
     * @link http://docs.camunda.org/api-references/rest/#!/group/get-query-count
     *
     * @param GroupRequest $request Filter parameters
     * @throws \Exception
     * @return int Amount of groups
     */
    public function getCount(GroupRequest $request)
    {
        $this->client->setRequestUrl('/group/count');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('GET');

        try {
            return $this->client->execute()->count;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Updates an existing group.
     * @link http://docs.camunda.org/api-references/rest/#!/group/put-update
     *
     * @param String $id  Group Id
     * @param GroupRequest $request update parameters
     * @throws \Exception
     */
    public function updateGroup($id, GroupRequest $request)
    {
        $this->client->setRequestUrl('/group/'.$id);
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('PUT');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * allows checking for the set of available operations that the currently authenticated user can perform on the
     * resource
     * @link http://docs.camunda.org/latest/api-references/rest/#group-group-resource-options
     *
     * @throws \Exception
     * @return ResourceOption $this
     */
    public function getResourceOption()
    {
        $resourceOption = new ResourceOption();
        $this->client->setRequestUrl('/group');
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('OPTIONS');

        try {
            return $resourceOption->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * allows checking for the set of available operations that the currently authenticated user can perform on the
     * resource
     * @link http://docs.camunda.org/latest/api-references/rest/#group-group-resource-options
     *
     * @param String $id group ID
     * @throws \Exception
     * @return ResourceOption $this
     */
    public function getResourceInstanceOption($id)
    {
        $resourceOption = new ResourceOption();
        $this->client->setRequestUrl('/group/'.$id);
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('OPTIONS');

        try {
            return $resourceOption->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }
}
