<?php
/**
 * Created by IntelliJ IDEA.
 * User: hentschel
 * Date: 13.06.13
 * Time: 10:03
 * To change this template use File | Settings | File Templates.
 */

namespace Camunda\Service;

use Camunda\Client;
use Exception;
use Camunda\Request\IdentityLinksRequest;
use Camunda\Request\TaskRequest;
use Camunda\Response\Form;
use Camunda\Response\IdentityLink;
use Camunda\Response\Task;

class TaskService
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
   * Retrieves the task with the given ID
   *
   * @param String $id task id
   * @throws \Exception
   * @return \Camunda\Response\Task $this requested task
   */
    public function getTask($id)
    {
        $task = new Task();
        $this->client->setRequestUrl('/task/' . $id);
        $this->client->setRequestMethod('GET');
        $this->client->setRequestData(null);

        try {
            return $task->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieves a list of tasks within given context
     * @link http://docs.camunda.org/api-references/rest/#!/task/get-query
     * @link http://docs.camunda.org/api-references/rest/#!/task/post-query
     *
     * @param TaskRequest $request filter parameters
     * @param bool $isPostRequest switch for GET/POST request
     * @throws \Exception
     * @return object list of all Tasks
     */
    public function getTasks(TaskRequest $request, $isPostRequest = false)
    {
        $this->client->setRequestUrl('/task/');
        $this->client->setRequestData($request);
        if ($isPostRequest == true) {
            $this->client->setRequestMethod('POST');
        } else {
            $this->client->setRequestMethod('GET');
        }

        try {
            $prepare = $this->client->execute();
            $response = array();
            foreach ($prepare as $index => $data) {
                $task = new Task();
                $response['task_' . $index] = $task->cast($data);
            }
            return (object)$response;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieves the amount of tasks within given context
     * @link http://docs.camunda.org/api-references/rest/#!/task/get-query-count
     * @link http://docs.camunda.org/api-references/rest/#!/task/post-query-count
     *
     * @param TaskRequest $request filter parameters
     * @param bool $isPostRequest switch for GET/POST request
     * @throws \Exception
     * @return int Amount of tasks
     */
    public function getCount(TaskRequest $request, $isPostRequest = false)
    {
        $this->client->setRequestUrl('/task/count/');
        $this->client->setRequestData($request);
        if ($isPostRequest == true) {
            $this->client->setRequestMethod('POST');
        } else {
            $this->client->setRequestMethod('GET');
        }

        try {
            return $this->client->execute()->count;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieves the form key of the given task
     * @link http://docs.camunda.org/api-references/rest/#!/task/get-form-key
     *
     * @param String $id task ID
     * @throws \Exception
     * @return Form start form object
     */
    public function getFormKey($id)
    {
        $form = new Form();
        $this->client->setRequestUrl('/task/'.$id.'/form');
        $this->client->setRequestMethod('GET');
        $this->client->setRequestData(null);

        try {
            return $form->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Claims a task for a specific user
     * @link http://docs.camunda.org/api-references/rest/#!/task/post-claim
     *
     * @param String $id task id
     * @param \org\camunda\php\sdk\entity\request\TaskRequest $request
     * @throws \Exception
     */
    public function claimTask($id, TaskRequest $request)
    {
        $this->client->setRequestUrl('/task/'.$id.'/claim');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('POST');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Unclaims a task
     * @link http://docs.camunda.org/api-references/rest/#!/task/post-unclaim
     *
     * @param String $id task id
     * @throws \Exception
     */
    public function unclaimTask($id)
    {
        $this->client->setRequestUrl('/task/'.$id.'/unclaim');
        $this->client->setRequestMethod('POST');
        $this->client->setRequestData(null);

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Completes a Task and updates process variables
     * @link http://docs.camunda.org/api-references/rest/#!/task/post-complete
     *
     * @param String $id task ID
     * @param TaskRequest $request variable properties
     * @throws \Exception
     */
    public function completeTask($id, TaskRequest $request)
    {
        $this->client->setRequestUrl('/task/'.$id.'/complete');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('POST');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Resolves a task and update execution variables
     * @link http://docs.camunda.org/api-references/rest/#!/task/post-resolve
     *
     * @param String $id task ID
     * @param TaskRequest $request variable properties
     * @throws \Exception
     */
    public function resolveTask($id, TaskRequest $request)
    {
        $this->client->setRequestUrl('/task/'.$id.'/resolve');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('POST');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Delegates a task to another user
     * @link http://docs.camunda.org/api-references/rest/#!/task/post-delegate
     *
     * @param String $id task ID
     * @param TaskRequest $request user properties
     * @throws \Exception
     */
    public function delegateTask($id, TaskRequest $request)
    {
        $this->client->setRequestUrl('/task/'.$id.'/delegate');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('POST');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Change the assignee of a task to a specific user.
     * @link http://docs.camunda.org/latest/api-references/rest/#task-set-assignee
     *
     * @param String $id Task ID
     * @param TaskRequest $request
     * @throws \Exception
     */
    public function setAssignee($id, TaskRequest $request)
    {
        $this->client->setRequestUrl('/task/'.$id. '/assignee');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('POST');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     *  Gets the identity links for a task, which are the users and groups that are in some relation to it
     * (including assignee and owner).
     * @link http://docs.camunda.org/latest/api-references/rest/#task-get-identity-links
     *
     * @param String $id task ID
     * @param IdentityLinksRequest $request
     * @throws \Exception
     * @return IdentityLink $this
     */
    public function getIdentityLinks($id, IdentityLinksRequest $request)
    {
        $identityLink = new IdentityLink();
        $this->client->setRequestUrl('/task/'.$id.'/identity-links');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('GET');

        try {
            $prepare = $this->client->execute();
            $response = array();
            foreach ($prepare as $index => $data) {
                $identityLink = new IdentityLink();
                $response['identityLink_' . $index] = $identityLink->cast($data);
            }
            return (object)$response;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Adds an identity link to a task. Can be used to link any user or group to a task and specify and relation.
     * @link http://docs.camunda.org/latest/api-references/rest/#task-add-identity-link
     *
     * @param String $id task ID
     * @param IdentityLinksRequest $request
     * @throws \Exception
     */
    public function addIdentityLink($id, IdentityLinksRequest $request)
    {
        $this->client->setRequestUrl('/task/'.$id.'/identity-links');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('POST');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Removes an identity link from a task.
     * @link http://docs.camunda.org/latest/api-references/rest/#task-delete-identity-link
     *
     * @param String $id task ID
     * @param IdentityLinksRequest $request
     * @throws \Exception
     */
    public function deleteIdentityLink($id, IdentityLinksRequest $request)
    {
        $this->client->setRequestUrl('/task/'.$id.'/identity-links/delete');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('POST');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Do a fast takeover of the task. So you don't need first to unclaim
     * a task before you can claim it
     *
     * @param String $id task ID
     * @param TaskRequest $request user properties
     * @throws \Exception
     * @deprecated Use setAssignee() instead
     */
    public function takeTask($id, TaskRequest $request)
    {
        try {
            $this->unclaimTask($id);
            $this->claimTask($id, $request);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
