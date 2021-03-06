<?php

namespace WebpConverter;

use WebpConverter\Action;
use WebpConverter\Conversion;
use WebpConverter\Conversion\Cron;
use WebpConverter\Conversion\Endpoint;
use WebpConverter\Conversion\Media;
use WebpConverter\Error;
use WebpConverter\Notice;
use WebpConverter\Plugin;
use WebpConverter\Settings\Page;

/**
 * Class initializes all plugin actions.
 */
class WebpConverter {

	public function __construct() {
		$plugin_data = new PluginData();

		( new Action\ConvertAttachment( $plugin_data ) )->init_hooks();
		( new Action\ConvertDir() )->init_hooks();
		( new Action\ConvertPaths( $plugin_data ) )->init_hooks();
		( new Action\DeletePaths() )->init_hooks();
		( new Action\RegenerateAll( $plugin_data ) )->init_hooks();
		( new Conversion\Directory\DirectoryFactory() )->init_hooks();
		( new Conversion\DirectoryFiles( $plugin_data ) )->init_hooks();
		( new Endpoint\EndpointIntegration( new Endpoint\PathsEndpoint( $plugin_data ) ) )->init_hooks();
		( new Endpoint\EndpointIntegration( new Endpoint\RegenerateEndpoint( $plugin_data ) ) )->init_hooks();
		( new Conversion\SkipExists( $plugin_data ) )->init_hooks();
		( new Conversion\SkipLarger( $plugin_data ) )->init_hooks();
		( new Cron\Event( $plugin_data ) )->init_hooks();
		( new Cron\Schedules() )->init_hooks();
		( new Error\ErrorFactory( $plugin_data ) )->init_hooks();
		( new Notice\NoticeFactory() )->init_hooks();
		( new Loader\LoaderIntegration( new Loader\HtaccessLoader( $plugin_data ) ) )->init_hooks();
		( new Loader\LoaderIntegration( new Loader\PassthruLoader( $plugin_data ) ) )->init_hooks();
		( new Media\Delete() )->init_hooks();
		( new Media\Upload( $plugin_data ) )->init_hooks();
		( new Plugin\Activation() )->init_hooks();
		( new Plugin\Deactivation() )->init_hooks();
		( new Plugin\Deactivation\Modal( $plugin_data ) )->init_hooks();
		( new Plugin\Links() )->init_hooks();
		( new Plugin\Uninstall() )->init_hooks();
		( new Plugin\Update() )->init_hooks();
		( new Page\PageIntegration() )
			->set_page_integration( new Page\SettingsPage( $plugin_data ) )
			->set_page_integration( new Page\DebugPage( $plugin_data ) )
			->init_hooks();
	}
}
