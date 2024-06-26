<?php


namespace Fakell\Bing\Clients;

use Fakell\Bing\Constant\Defaults;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class Client {

    const BASE_URI = "https://www.bing.com/";
    const DEFAULT_TIMEOUT = 300;

    private ClientInterface $client;
    private $cookie;

    public function __construct($cookie = null){
        $this->cookie = $cookie;
        $this->client = $this->defaultHttpClient();
    }

    public function send($method, $uri, $options = []){
        try {
            $req = $this->client->request($method, $uri, $options );
            return $req;
        } catch (GuzzleException $e) {
            print_r($e->getMessage());
            throw new \Exception("Error Processing Request", 1);
        }
    }

    private function defaultHttpClient() : ClientInterface {
        $headers = array_merge(Defaults::HEDEARS, ["Cookie" => $this->cookie]);
        return new \GuzzleHttp\Client([
            "base_uri" => self::BASE_URI,
            "timeout" => self::DEFAULT_TIMEOUT,
            RequestOptions::HEADERS => $headers
        ]);
    }

}