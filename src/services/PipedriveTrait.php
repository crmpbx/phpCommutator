<?php

namespace crmpbx\commutator\services;

trait PipedriveTrait
{
    private string $pipedriveServiceAddress = '';
    private int $pipedriveServiceTimeout = 1;
    private string $pipedriveTestServiceAddress = '';
}