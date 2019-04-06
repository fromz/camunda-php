<?php
/**
 * Created by IntelliJ IDEA.
 * User: hentschel
 * Date: 30.10.13
 * Time: 08:46
 * To change this template use File | Settings | File Templates.
 */

namespace Camunda\Service;

use Camunda\Client;
use Exception;
use Camunda\Request\AuthorizationRequest;
use Camunda\Response\Authorization;
use Camunda\Response\ResourceOption;

class AuthorizationService
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
   * Removes an authorization by id
   * @Link http://docs.camunda.org/latest/api-references/rest/#authorization-delete-authorization
   *
   * @param String $id authorization ID
   * @throws \Exception
   */
    public function deleteAuthorization($id)
    {
        $this->client->setRequestUrl('/authorization/'. $id);
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('DELETE');

        try {
            $this->client->execute();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieves a single authorization by id.
     * @Link http://docs.camunda.org/latest/api-references/rest/#authorization-get-single-authorization
     *
     * @param String $id authorization ID
     * @throws \Exception
     * @return \Camunda\Response\Authorization $this requested authorization
     */
    public function getAuthorization($id)
    {
        $authorization = new Authorization();
        $this->client->setRequestUrl('/authorization/'. $id);
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('GET');

        try {
            return $authorization->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Performs an authorization check for the currently authenticated user.
     * @Link http://docs.camunda.org/latest/api-references/rest/#authorization-perform-an-authorization-check
     *
     * @param AuthorizationRequest $request
     * @throws \Exception
     * @return mixed
     */
    public function checkAuthorization(AuthorizationRequest $request)
    {
        $checkerArray = array(
      0 => 'permissionName',
      1 => 'permissionValue',
      2 => 'resourceName',
      3 => 'resourceType');

        // Checker for required variables
        foreach ($checkerArray as $value) {
            if (isset($request[$value]) && ($request[$value] != null || $request[$value] != '')) {
                continue;
            } else {
                throw new Exception("Missing required Variables! See documentation for right syntax.");
            }
        }

        $authorization = new Authorization();
        $this->client->setRequestUrl('/authorization/check');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('GET');

        try {
            return $authorization->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Query for a list of authorizations using a list of parameters. The size of the result set can be retrieved by
     * using the get authorization count method.
     * @Link http://docs.camunda.org/latest/api-references/rest/#authorization-get-authorizations
     *
     * @param AuthorizationRequest $request
     * @throws \Exception
     * @return object
     */
    public function getAuthorizations(AuthorizationRequest $request)
    {
        $this->client->setRequestUrl('/authorization');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('GET');

        try {
            $prepare = $this->client->execute();
            $response = array();
            foreach ($prepare as $index => $data) {
                $authorization = new Authorization();
                $response['authorization_'.$index] = $authorization->cast($data);
            }
            return (object)$response;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Query for authorizations using a list of parameters and retrieves the count.
     * @Link http://docs.camunda.org/latest/api-references/rest/#authorization-get-authorizations-count
     *
     * @param AuthorizationRequest $request
     * @throws \Exception
     * @return Integer $this count of authorizations
     */
    public function getCount(AuthorizationRequest $request)
    {
        $this->client->setRequestUrl('/authorization/count');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('GET');

        try {
            return $this->client->execute()->count;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Allows checking for the set of available operations that the currently authenticated user can perform.
     * @Link http://docs.camunda.org/latest/api-references/rest/#authorization-authorization-resource-options
     *
     * @throws \Exception
     * @return \Camunda\Response\ResourceOption
     */
    public function getResourceOption()
    {
        $resourceOptions = new ResourceOption();
        $this->client->setRequestUrl('/authorization');
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('OPTIONS');

        try {
            return $resourceOptions->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }


    /**
     * Allows checking for the set of available operations that the currently authenticated user can perform.
     * @Link http://docs.camunda.org/latest/api-references/rest/#authorization-authorization-resource-options
     *
     * @param String $id  authorization ID
     * @throws \Exception
     * @return \Camunda\Response\ResourceOption
     */
    public function getResourceInstanceOption($id)
    {
        $resourceOptions = new ResourceOption();
        $this->client->setRequestUrl('/authorization/'. $id);
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('OPTIONS');

        try {
            return $resourceOptions->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Creates a new authorization
     * @Link http://docs.camunda.org/latest/api-references/rest/#authorization-create-a-new-authorization
     *
     * @param AuthorizationRequest $request
     * @throws \Exception
     * @return \Camunda\Response\Authorization
     */
    public function createAuthorization(AuthorizationRequest $request)
    {
        $authorization = new Authorization();
        $this->client->setRequestUrl('/authorization/create');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('POST');

        try {
            return $authorization->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Updates a single authorization.
     * @link http://docs.camunda.org/latest/api-references/rest/#authorization-update-a-single-authorization
     *
     * @param $id
     * @param AuthorizationRequest $request
     * @throws \Exception
     */
    public function updateAuthorization($id, AuthorizationRequest $request)
    {
        $this->client->setRequestUrl('/authorization/'.$id);
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('PUT');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
