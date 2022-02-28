<?php

namespace crmpbx\commutator;

use crmpbx\httpClient\Response;

interface Commutable
{
    public function send(string $service, string $route, mixed $data) : Response;
}