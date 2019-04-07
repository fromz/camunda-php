<?php
/**
 * Created by IntelliJ IDEA.
 * User: hentschel
 * Date: 07.06.13
 * Time: 20:43
 * To change this template use File | Settings | File Templates.
 */

namespace Camunda;

class Client
{
    private $requestData;

    private $requestMethod = 'GET';

    private $requestUrl;

    private $http_status_code;

    private $restApiUrl;

    public function __construct($restApiUrl)
    {
        $this->restApiUrl = $restApiUrl;
    }

    /**
     * @param array $requestObject
     */
    public function setRequestData(?string $requestObject = null)
    {
        $this->requestData = $requestObject;
    }

    /**
     * @return mixed
     */
    public function getRequestData()
    {
        return $this->requestData;
    }

    /**
     * @param mixed $requestMethod
     */
    public function setRequestMethod($requestMethod)
    {
        $this->requestMethod = $requestMethod;
    }

    /**
     * @return mixed
     */
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    /**
     * @param $requestUrl
     */
    public function setRequestUrl($requestUrl)
    {
        $this->requestUrl = $requestUrl;
    }

    /**
     * @return mixed
     */
    public function getRequestUrl()
    {
        return $this->requestUrl;
    }

    /**
     * @param mixed $http_status_code
     */
    public function setHttpStatusCode($http_status_code)
    {
        $this->http_status_code = $http_status_code;
    }

    /**
     * @return mixed
     */
    public function getHttpStatusCode()
    {
        return $this->http_status_code;
    }

    /**
     * executes the rest request.
     *
     * @throws \Exception
     *
     * @return mixed server response
     */
    public function execute()
    {
        $this->restApiUrl = preg_replace('/\/$/', '', $this->restApiUrl);

        $tmp = array();

        if ('GET' != $this->requestMethod) {
            // JSON Payload
            $data = json_encode($this->requestData);
        } else {
            // Query string payload
            $data = '?';
            if (isset($this->requestData)) {
                foreach ($this->requestData->iterate() as $index => $value) {
                    if (null != $value && !empty($value)) {
                        $tmp[] = $index.'='.$value;
                    }
                }
            }

            $data .= implode('&', $tmp);
        }

        switch (strtoupper($this->requestMethod)) {
      case 'OPTIONS':
        if ($this->checkCurl()) {
            $ch = curl_init($this->restApiUrl.$this->requestUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'OPTIONS');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $request = curl_exec($ch);
            $this->http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        } else {
            $streamContext = stream_context_create(
              array(
              'http' => array(
                'method' => 'OPTIONS',
              ),
            )
          );
            $request = file_get_contents($this->restApiUrl.$this->requestUrl, null, $streamContext);
            $this->http_status_code = substr($http_response_header[0], 9, 3);
        }
        break;

      case 'DELETE':
        if ($this->checkCurl()) {
            $ch = curl_init($this->restApiUrl.$this->requestUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: '.strlen($data),
          ));
            $request = curl_exec($ch);
            $this->http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        } else {
            $streamContext = stream_context_create(
              array(
              'http' => array(
                'method' => 'DELETE',
                'header' => 'Content-Type: application/json'."\r\n"
                .'Content-Length:'.strlen($data)."\r\n",
                'content' => $data,
              ),
            )
          );
            $request = file_get_contents($this->restApiUrl.$this->requestUrl, null, $streamContext);
            $this->http_status_code = substr($http_response_header[0], 9, 3);
        }
        break;
      case 'PUT':
        if ($this->checkCurl()) {
            $ch = curl_init($this->restApiUrl.$this->requestUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: '.strlen($data),
          ));

            $request = curl_exec($ch);
            $this->http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        } else {
            $streamContext = stream_context_create(
              array(
              'http' => array(
                'method' => 'PUT',
                'header' => 'Content-Type: application/json'."\r\n"
                .'Content-Length:'.strlen($data)."\r\n",
                'content' => $data,
              ),
            )
          );

            $request = file_get_contents($this->restApiUrl.$this->requestUrl, null, $streamContext);
            $this->http_status_code = substr($http_response_header[0], 9, 3);
        }
        break;
      case 'POST':
        if ($this->checkCurl()) {
            $ch = curl_init($this->restApiUrl.$this->requestUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: '.strlen($data),
          ));
            $request = curl_exec($ch);
            $this->http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        } else {
            $streamContext = stream_context_create(
              array(
              'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: application/json'."\r\n"
                .'Content-Length:'.strlen($data)."\r\n",
                'content' => $data,
              ),
            )
          );

            $request = file_get_contents($this->restApiUrl.$this->requestUrl, null, $streamContext);
            $this->http_status_code = substr($http_response_header[0], 9, 3);
        }
        break;
      case 'GET':
      default:

      if ($this->checkCurl()) {
          $ch = curl_init($this->restApiUrl.$this->requestUrl.$data);
          curl_setopt($ch, CURLOPT_COOKIEJAR, './');
          curl_setopt($ch, CURLOPT_COOKIEFILE, './');
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

          $request = curl_exec($ch);
          $this->http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
          curl_close($ch);
      } else {
          $request = file_get_contents($this->restApiUrl.$this->requestUrl.$data);
          $this->http_status_code = substr($http_response_header[0], 9, 3);
      }
        break;
    }

        if (preg_match('/(^10|^20)[0-9]/', $this->http_status_code)) {
            $this->reset();

            return json_decode($request);
        } else {
            $this->reset();
            if (null != $request && '' != $request && !empty($request)) {
                $error = json_decode($request);
            } else {
                $error = new \stdClass();
                $error->type = 'Not found!';
                $error->message = 'No Message!';
            }
            throw new \Exception('Error! HTTP Status Code: '.$this->http_status_code.' -- ErrorType: '.$error->type.' --
      Error Message: '.$error->message);
        }
    }

    /**
     * simple curl check.
     *
     * @return bool
     */
    private function checkCurl()
    {
        return function_exists('curl_version');
    }

    private function reset()
    {
        $this->setRequestData(null);
        $this->setRequestUrl('');
        $this->setRequestMethod('GET');
    }
}
