<?php

class CleantalkUpgraderSkin extends WP_Upgrader_Skin
{
	
	public $upgrader;
	public $done_header = false;
	public $done_footer = false;

	/**
	 * Holds the result of an upgrade.
	 *
	 * @since 2.8.0
	 * @var string|bool|WP_Error
	 */
	public $result = false;
	public $options = array();
	
	/**
	 */
	public function header() { }

	/**
	 */
	public function footer() { }

	/**
	 *
	 * @param string $string
	 */
	public function feedback($string) {	}
	
	/**
	 *
	 * @param string|WP_Error $errors
	 */
	public function error($errors) {
		$this->upgrader->apbct_result = $this->upgrader->strings[$errors];
	}
}
