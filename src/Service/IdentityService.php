<?php
/**
 * Created by IntelliJ IDEA.
 * User: hentschel
 * Date: 30.10.13
 * Time: 14:04
 * To change this template use File | Settings | File Templates.
 */

namespace Camunda\Service;

use Camunda\Client;
use Exception;
use Camunda\Request\IdentityRequest;
use Camunda\Response\Identity;

class IdentityService
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
   * Gets the groups of a user and all users that share a group with the given user.
   * @link http://docs.camunda.org/latest/api-references/rest/#identity-get-a-users-groups
   *
   * @param IdentityRequest $request
   * @return Identity $this
   * @throws \Exception
   */
    public function getGroups(IdentityRequest $request)
    {
        $identity = new Identity();
        $this->client->setRequestUrl('/identity/groups');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('GET');

        try {
            return $identity->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }
}
