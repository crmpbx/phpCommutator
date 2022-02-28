<?php

namespace crmpbx\commutator;

use crmpbx\httpClient\Response;

interface Commutable
{
    public function send(string $method, string $service, string $route, mixed $data) : Response;
}