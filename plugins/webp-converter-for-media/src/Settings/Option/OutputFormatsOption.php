<?php

namespace WebpConverter\Settings\Option;

use WebpConverter\Conversion\Format\FormatFactory;
use WebpConverter\Conversion\Format\WebpFormat;

/**
 * Handles data about "Supported output formats" field in plugin settings.
 */
class OutputFormatsOption extends OptionAbstract {

	const LOADER_TYPE = 'output_formats';

	/**
	 * Object of integration class supports all conversion methods.
	 *
	 * @var FormatFactory
	 */
	private $formats_integration;

	public function __construct() {
		$this->formats_integration = new FormatFactory();
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_name(): string {
		return self::LOADER_TYPE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_type(): string {
		return OptionAbstract::OPTION_TYPE_CHECKBOX;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_label(): string {
		return __( 'List of supported output formats', 'webp-converter-for-media' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_values( array $settings ): array {
		return $this->formats_integration->get_formats();
	}

	/**
	 * Returns default value of field.
	 *
	 * @param mixed[]|null $settings Plugin settings.
	 *
	 * @return string[] Default value of field.
	 */
	public function get_default_value( array $settings = null ): array {
		$method  = $settings['method'] ?? ( new ConversionMethodOption() )->get_default_value();
		$formats = array_keys( $this->formats_integration->get_available_formats( $method ) );

		return ( in_array( WebpFormat::FORMAT_EXTENSION, $formats ) ) ? [ WebpFormat::FORMAT_EXTENSION ] : [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_disabled_values( array $settings ): array {
		$method            = $settings['method'] ?? ( new ConversionMethodOption() )->get_default_value();
		$formats           = $this->formats_integration->get_formats();
		$formats_available = $this->formats_integration->get_available_formats( $method );
		return array_keys( array_diff( $formats, $formats_available ) );
	}
}
