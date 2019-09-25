<?php
/**
 * web, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 10/04/2019 15:56
 */

namespace Firestorm\Tests\MonCalamari;

use Faker\Factory;
use Firestorm\Tests\Shared\UnitTestCase;

abstract class MissileUnitTestCase extends UnitTestCase
{
    private $fake;

    /** @return \Faker\Generator */
    protected function fake()
    {
        return $this->fake = $this->fake ?: Factory::create();
    }
}
