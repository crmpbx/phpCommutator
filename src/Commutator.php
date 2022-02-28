<?php

namespace crmpbx\commutator;

use crmpbx\commutator\services\{AmoTrait, LogTrait, NotificationTrait, PbxTrait, PipedriveTrait};
use crmpbx\httpClient\HttpClient;
use crmpbx\httpClient\Request;
use crmpbx\httpClient\Response;

class Commutator implements Commutable
{
    private HttpClient $httpClient;

    use PbxTrait, AmoTrait, LogTrait, ExtensionTrait, PipedriveTrait, NotificationTrait;

    public function __construct(array $config)
    {
        $this->httpClient = new HttpClient();
        $this->init($config);
    }

    private function init(array $config)
    {
        foreach ($config as $prop => $value)
            if(property_exists($this, $prop))
                $this->$prop = $value;
    }

    /**
     * @throws CommutatorException
     */
    public function send(string $service, string $route, mixed $data): Response
    {
        $service = self::getService($service);
        return $this->httpClient->getResponse(
            $this->buildRequest($service, $route, $data),
            $this->getTimeout($service)
        );
    }

    /**
     * @throws CommutatorException
     */
    private function buildRequest(string $service, string $route, mixed $data): Request
    {
        $address = $service.'ServiceAddress';
        if(!property_exists($this, $address))
            Throw new CommutatorException($service.' current service does not exists', 404);

        if(!$this->$address)
            Throw new CommutatorException($service.' current service does not initiated', 400);


        $rq = new Request($this->$address.self::getRoute($route), $data, $this->getTimeout($service));
        if($auth = $this->getAuth($service))
            $rq->withHeader('XAuthToken', $auth);

        return $rq;
    }

    private function getTimeout($service): int
    {
        $timeout = $service.'ServiceTimeout';
        if(property_exists($this, $timeout))
            return $this->$timeout;

        return 0;
    }

    private function getAuth($service)
    {
        $auth = $service.'ServiceAccessToken';
        if(property_exists($this, $auth) && $this->$auth)
            return $this->$auth;
    }

    private static function getRoute(string $route): string
    {
        return str_replace('//', '/', '/'.$route.'/');
    }

    private static function getService(string $service): string
    {
        $arr=explode('-', $service);
        return array_reduce($arr, function ($carry, $item){
            if($carry === $item)
                return $carry;
            return $carry.ucfirst($item);
        }, $arr[0]);
    }
}
