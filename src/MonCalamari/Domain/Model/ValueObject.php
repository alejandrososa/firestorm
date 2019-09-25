<?php

namespace Firestorm\MonCalamari\Domain\Model;

interface ValueObject
{
    public function equals(ValueObject $object): bool;
}
