<?php

namespace Firestorm\MonCalamari\Application\Exception;

final class CalculatedAreaAlreadyExists extends \Exception
{
	public static function reason(string $msg, $value): self
	{
		return new self(sprintf("Upss, '%s' %s", $value, $msg));
	}
}
