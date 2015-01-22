<?php

	require_once 'config.php';
	error_reporting(E_ERROR);

	define ('ROOT', dirname(__FILE__).'/../');
	define ('D', DIRECTORY_SEPARATOR);
	define ('P', PATH_SEPARATOR); 
	define ('SYSDIR', ROOT.D.'system'.D);
	
	// Prepare Class Environment 
	$loader = require __DIR__.'/../vendor/autoload.php';
	$loader->add('DataDikdas', __DIR__.'/../src/');

	// Initialize the App
	$app = new Silex\Application();
	$app['debug'] = true;

	//  Propel 
	$app['propel.config_file'] = __DIR__.'/config/conf/data_dikdas-conf.php';
	$app['propel.model_path'] = __DIR__.'/../src/';
	$app->register(new Propel\Silex\PropelServiceProvider());

	// Register Twig
	$app->register(new Silex\Provider\TwigServiceProvider(), array(
		'twig.path' => __DIR__.'/../web',
	));

	// Register Session
	$app->register(new Silex\Provider\SessionServiceProvider());

	// Register for auth too
	$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

	$app->register(new Silex\Provider\SecurityServiceProvider(), array(
		'admin' => array(
			'pattern' => '^/admin',
			'http' => true,
			'users' => array(
				// raw password is foo
				'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
			),
		),	
		'security.firewalls' => array(
			'foo' => array('pattern' => '^/foo'), // Example of an url available as anonymous user
			'default' => array(
				'pattern' => '^.*$',
				'anonymous' => true, // Needed as the login path is under the secured area
				'form' => array('login_path' => '/', 'check_path' => 'login_check'),
				'logout' => array('logout_path' => '/logout')
			),
		)
	));

	// Set TIMEZONE
	date_default_timezone_set('Asia/Jakarta');

	return $app;