<?php
declare(strict_types=1);

namespace MarcinOrlowski\ResponseBuilder\Converters;

/**
 * Laravel API Response Builder
 *
 * @package   MarcinOrlowski\ResponseBuilder
 *
 * @author    Marcin Orlowski <mail (#) marcinOrlowski (.) com>
 * @copyright 2016-2022 Marcin Orlowski
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/MarcinOrlowski/laravel-api-response-builder
 */

use Illuminate\Contracts\Support\Arrayable;
use MarcinOrlowski\ResponseBuilder\Contracts\ConverterContract;
use MarcinOrlowski\ResponseBuilder\Validator;

/**
 * Converter for Arrayable class type of objects.
 */
final class ArrayableConverter implements ConverterContract
{
	/**
	 * Returns array representation of the object implementing Arrayable interface
	 *
	 * @param object $obj                                    Object to be converted
	 * @param array  $config                                 Converter config array to be used for this object (based on exact class
	 *                                                       name match or inheritance).
	 *
	 * @return array
	 *
	 * phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.FoundInImplementedInterfaceAfterLastUsed
	 */
	public function convert(object $obj, array $config): array
	{
		Validator::assertInstanceOf('obj', $obj, Arrayable::class);

		return $obj->toArray();
	}
}
