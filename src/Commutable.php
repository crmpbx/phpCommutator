<?php

namespace crmpbx\commutator;

use crmpbx\httpClient\Response;

interface CommutatorInterface
{
    public function send(string $service, string $method, string $route, mixed $data) : Response;
}