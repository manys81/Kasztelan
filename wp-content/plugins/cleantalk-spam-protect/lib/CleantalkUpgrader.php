<?php

class CleantalkUpgrader extends Plugin_Upgrader
{
	/**
	 * Plugin upgrade result.
	 *
	 * @since 2.8.0
	 * @var array|WP_Error $result
	 *
	 * @see WP_Upgrader::$result
	 */
	public $result;
	
	public $apbct_result = 'OK';
	
	/**
	 * Initialize the upgrade strings.
	 *
	 * @since 2.8.0
	 */
	public function upgrade_strings() {
		$this->strings['up_to_date'] = __('UP_TO_DATE');
		$this->strings['no_package'] = __('PACKAGE_NOT_AVAILABLE');
		/* translators: %s: package URL */
		$this->strings['remove_old_failed'] = __('COULD_NOT_REMOVE_OLD_PLUGIN');
		$this->strings['process_failed'] = __('PLUGIN_UPDATE_FAILED');
		$this->strings['process_success'] = __('OK');
	}
	
	public function run( $options ) {

		$defaults = array(
			'package' => '', // Please always pass this.
			'destination' => '', // And this
			'clear_destination' => false,
			'abort_if_destination_exists' => true, // Abort if the Destination directory exists, Pass clear_destination as false please
			'clear_working' => true,
			'is_multi' => false,
			'hook_extra' => array() // Pass any extra $hook_extra args here, this will be passed to any hooked filters.
		);

		$options = wp_parse_args( $options, $defaults );
		
		$options = apply_filters( 'upgrader_package_options', $options );

		if ( ! $options['is_multi'] ) { // call $this->header separately if running multiple times
			$this->skin->header();
		}

		// Connect to the Filesystem first.
		$res = $this->fs_connect( array( WP_CONTENT_DIR, $options['destination'] ) );
		// Mainly for non-connected filesystem.
		if ( ! $res ) {
			if ( ! $options['is_multi'] ) {
				$this->skin->footer();
			}
			return false;
		}

		$this->skin->before();

		if ( is_wp_error($res) ) {
			$this->skin->error($res);
			$this->skin->after();
			if ( ! $options['is_multi'] ) {
				$this->skin->footer();
			}
			return $res;
		}

		/*
		 * Download the package (Note, This just returns the filename
		 * of the file if the package is a local file)
		 */
		$download = $this->download_package( $options['package'] );
		if ( is_wp_error($download) ) {
			$this->skin->error($download);
			$this->skin->after();
			if ( ! $options['is_multi'] ) {
				$this->skin->footer();
			}
			return $download;
		}

		$delete_package = ( $download != $options['package'] ); // Do not delete a "local" file

		// Unzips the file into a temporary directory.
		$working_dir = $this->unpack_package( $download, $delete_package );
		if ( is_wp_error($working_dir) ) {
			$this->skin->error($working_dir);
			$this->skin->after();
			if ( ! $options['is_multi'] ) {
				$this->skin->footer();
			}
			return $working_dir;
		}

		// With the given options, this installs it to the destination directory.
		$result = $this->install_package( array(
			'source' => $working_dir,
			'destination' => $options['destination'],
			'clear_destination' => $options['clear_destination'],
			'abort_if_destination_exists' => $options['abort_if_destination_exists'],
			'clear_working' => $options['clear_working'],
			'hook_extra' => $options['hook_extra']
		) );

		$this->skin->set_result($result);
		if ( is_wp_error($result) ) {
			$this->skin->error($result);
			$this->skin->feedback('process_failed');
		} else {
			// Installation succeeded.
			$this->skin->feedback('process_success');
		}
		
		return $result;
	}
}
