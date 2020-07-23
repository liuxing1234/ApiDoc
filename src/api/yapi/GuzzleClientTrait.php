<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/7/14
 * Time: 9:10
 */

namespace ApiGenerator\api\yapi;


use \GuzzleHttp\Client;

/**
 * Trait GuzzleClientTrait
 * @package Cblink\YapiClient\Traits
 */
trait GuzzleClientTrait
{
    protected $client;

    /**
     * @return Client
     */
    protected function getClient()
    {

        if (!$this->client) {
            $this->client = new Client();
            var_dump($this->client);
        }

        return $this->client;
    }

    /**
     * @param Client $client
     * @return $this
     */
    public function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @return array
     * @throws YApiException
     */
    protected function request(string $method, string $url, array $options = [])
    {
        var_dump($this->getClient());
        $response = $this->getClient()->request($method, $this->getUrl($url), array_merge([
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'verify' => false,
            'errors' => false,
        ], $options));
        $contents = $response->getBody()->getContents();

        $array = json_decode($contents, true, 512, JSON_BIGINT_AS_STRING);

        if (JSON_ERROR_NONE === json_last_error()) {
            if (isset($array['errcode']) && $array['errcode'] === 0) {
                return (array) $array['data'];
            }
            throw new YApiException($array['errmsg'] ?? 'yapi request error');
        }
        throw new YApiException('yapi request error');
    }

    /**
     * @param string $url
     * @param array $query
     * @return array
     * @throws YApiException
     */
    protected function get(string $url, array $query = [])
    {
        return $this->request('GET', $url, ['query' => $query]);
    }

    /**
     * @param string $url
     * @param array $body
     * @return array
     * @throws YApiException
     */
    protected function post(string $url, array $body = [])
    {
        return $this->request('POST', $url, ['json' => $body]);
    }

    /**
     * @param string $url
     * @param array $body
     * @return array
     * @throws YApiException
     */
    protected function postForm(string $url, array $body = [])
    {
        return $this->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'form_params' => $body
        ]);
    }

    /**
     * @param $url
     * @return string
     */
    protected function getUrl($url)
    {
        echo "ojkb";
        return sprintf(
            '%s%s%s',
            rtrim($this->baseUrl, '/'),
            '/',
            ltrim($url, '/')
        );
    }
}
