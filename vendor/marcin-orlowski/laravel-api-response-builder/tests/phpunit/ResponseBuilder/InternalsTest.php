<?php
/**
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 */
declare(strict_types=1);

namespace MarcinOrlowski\ResponseBuilder\Tests\ResponseBuilder;

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

use Illuminate\Support\Facades\Config;
use MarcinOrlowski\ResponseBuilder\BaseApiCodes;
use MarcinOrlowski\ResponseBuilder\Converter;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as RB;
use MarcinOrlowski\ResponseBuilder\Exceptions as Ex;
use MarcinOrlowski\ResponseBuilder\Tests\Models\TestModel;
use MarcinOrlowski\ResponseBuilder\Tests\TestCase;

/**
 * Class InternalsTest
 *
 * @package MarcinOrlowski\ResponseBuilder\Tests
 */
class InternalsTest extends TestCase
{
	/**
	 * Tests if dist's config defaults matches RB::DEFAULT_ENCODING_OPTIONS
	 *
	 * @return void
	 */
	public function testDefaultEncodingOptionValue(): void
	{
		$config_defaults = \Config::get(RB::CONF_KEY_ENCODING_OPTIONS);
		$this->assertEquals($config_defaults, RB::DEFAULT_ENCODING_OPTIONS);
	}

	/**
	 * Validates handling of incomplete class mapping configuration by getClassesMapping()
	 *
	 * @return void
	 */
	public function testGetClassesMappingWithWrongType(): void
	{
		\Config::set(RB::CONF_KEY_CONVERTER_CLASSES, false);

		$this->expectException(Ex\InvalidConfigurationException::class);
		$this->callProtectedMethod(Converter::class, 'getClassesMapping');
	}

	/**
	 * Tests if getClassesMapping() would throw an exception with incomplete
	 * class mapping configuration.
	 *
	 * @return void
	 */
	public function testGetClassesMappingMethodWithIncompleteMappingConfiguration(): void
	{
		\Config::set(RB::CONF_KEY_CONVERTER_CLASSES, [
			self::class => [],
		]);

		$this->expectException(Ex\IncompleteConfigurationException::class);
		$this->callProtectedMethod(Converter::class, 'getClassesMapping');
	}

	/**
	 * Tests if getClassesMapping() would throw an exception if class mapping configuration
	 * is not an array
	 *
	 * @return void
	 */
	public function testGetClassesMappingMethodWithIncorrectMappingConfiguration(): void
	{
		\Config::set(RB::CONF_KEY_CONVERTER_CLASSES, [
			self::class => 123,
		]);

		$this->expectException(Ex\InvalidConfigurationElementException::class);
		$this->callProtectedMethod(Converter::class, 'getClassesMapping');
	}

	/**
	 * Tests getCodeForInternalOffset() out of bounds handling
	 *
	 * @return void
	 */
	public function testGetCodeForInternalOffsetMethodWithOffsetOutOfMaxBounds(): void
	{
		$obj = new BaseApiCodes();
		$max = $this->getProtectedConstant($obj, 'RESERVED_MAX_API_CODE_OFFSET');

		$this->expectException(\OutOfBoundsException::class);
		$this->callProtectedMethod($obj, 'getCodeForInternalOffset', [$max + 1]);
	}

	/**
	 * Tests getCodeForInternalOffset() out of bounds handling.
	 *
	 * @return void
	 */
	public function testGetCodeForInternalOffsetMethodWithOffsetOutOfMinBounds(): void
	{
		$obj = new BaseApiCodes();
		$min = $this->getProtectedConstant($obj, 'RESERVED_MIN_API_CODE_OFFSET');

		$this->expectException(\OutOfBoundsException::class);
		$this->callProtectedMethod($obj, 'getCodeForInternalOffset', [$min - 1]);
	}

	/**
	 * Tests getCodeMessageKey() if given code of configured code range.
	 *
	 * @return void
	 */
	public function testGetCodeMessageKeyMethodWithCodeOutOfCodeRange(): void
	{
		$this->expectException(\OutOfBoundsException::class);
		BaseApiCodes::getCodeMessageKey(BaseApiCodes::getMaxCode() + 1);
	}

	/**
	 * Tests if all mandatory constants are still members of the class.
	 *
	 * @return void
	 */
	public function testGetApiCodeConstants(): void
	{
		$expected = [
			'RESERVED_MIN_API_CODE_OFFSET',
			'RESERVED_MAX_API_CODE_OFFSET',

			'OK_OFFSET',
			'NO_ERROR_MESSAGE_OFFSET',
			'EX_HTTP_EXCEPTION_OFFSET',
			'EX_UNCAUGHT_EXCEPTION_OFFSET',
			// phpcs:disable Squiz.PHP.CommentedOutCode.Found
			// 'EX_HTTP_NOT_FOUND_OFFSET',
			// 'EX_HTTP_SERVICE_UNAVAILABLE_OFFSET',
			// 'EX_AUTHENTICATION_EXCEPTION_OFFSET',
			// 'EX_VALIDATION_EXCEPTION_OFFSET',
		];
		$consts = BaseApiCodes::getApiCodeConstants();

		foreach ($expected as $key) {
			$this->assertArrayHasKey($key, $consts);
		}
	}


	/**
	 * Checks if missing config for class, throws exception.
	 */
	public function testGetClassMappingConfigOrThrowWithNoConfig(): void
	{
		$converter = new Converter();
		$model = new TestModel('');

		$this->expectException(Ex\ConfigurationNotFoundException::class);
		$this->callProtectedMethod($converter, 'getClassMappingConfigOrThrow', [$model]);
	}

}
