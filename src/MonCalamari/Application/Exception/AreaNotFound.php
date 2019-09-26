<?php

namespace Firestorm\MonCalamari\Application\Exception;

final class AreaNotFound extends \Exception
{
	public static function reason($value): self
	{
		return new self(sprintf("Upss, area with uuid '%s' not found", $value));
	}
}
