<?php

namespace crmpbx\commutator\services;

trait LogTrait
{
    private string $logServiceAddress = '';
    private int $logServiceTimeout = 1;
    private string $logServiceAccessToken = '';
}