<?php
namespace PSR2Plugin\Tests\Integration;
use WPMedia\PHPUnit\BootstrapManager;

define( 'PSR2_PLUGIN_PLUGIN_ROOT', dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR );
define( 'PSR2_PLUGIN_TESTS_FIXTURES_DIR', dirname(__DIR__) . '/Fixtures');
define( 'PSR2_PLUGIN_TESTS_DIR', __DIR__ );
define( 'PSR2_PLUGIN_IS_TESTING', true );

// Manually load the plugin being tested.
tests_add_filter(
    'muplugins_loaded',
    function() {
        if ( BootstrapManager::isGroup( 'MyGroup' ) ) {
            // TODO: add your logic from MyGroup.
        }

        // Load the plugin.
        require PSR2_PLUGIN_PLUGIN_ROOT . '/psr2-plugin.php';
    }
);
