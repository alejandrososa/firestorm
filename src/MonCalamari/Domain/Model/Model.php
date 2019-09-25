<?php

namespace Firestorm\MonCalamari\Domain\Model;

interface Model
{
    public function sameIdentityAs(Model $other): bool;
}