<?php

namespace crmpbx\commutator\services;

trait PbxTrait
{
    private string $pbxServiceAddress = '';
    private int $pbxServiceTimeout = 1;
    private string $pbxTestServiceAddress = '';
}