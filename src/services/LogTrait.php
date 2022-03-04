<?php

namespace crmpbx\commutator\services;

trait LogTrait
{
    public string $logServiceAddress = '';
    public int $logServiceTimeout = 1;
    public string $logServiceAccessToken = '';
}