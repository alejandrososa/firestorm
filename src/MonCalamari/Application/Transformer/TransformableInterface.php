<?php

namespace Firestorm\MonCalamari\Application\Transformer;

interface TransformableInterface
{
	public function write($data): self;
	public function read();
}