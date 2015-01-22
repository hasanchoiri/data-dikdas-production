<?php
	/**
	*  Setting all desktop and sync application
	**/
	require_once 'functions.php';

	define ('APPNAME', 'DataDikdas'); // for desktop application  only, do not edit
	define ('DBNAME', 'data_dikdas'); // for desktop application only, do not edit

	define ('DATABASENAME', 'pendataan');
	define ('DATABASEUSER', 'postgres');
	define ('DATABASEPASSWORD', 'k03t03l0nc4tj03ngk1rb4lik');
	define ('DATABASEPORT', '5433');
	define ('DATABASEHOST', 'localhost');
	
	// SD
	define ('SDDATABASENAME', 'pendataan');
	define ('SDDATABASEUSER', 'postgres');
	define ('SDDATABASEPASSWORD', 'k03t03l0nc4tj03ngk1rb4lik');
	define ('SDDATABASEPORT', '5433');
	define ('SDDATABASEHOST', 'localhost');
	
	// SMP
	define ('SMPDATABASENAME', 'pendataan');
	define ('SMPDATABASEUSER', 'postgres');
	define ('SMPDATABASEPASSWORD', 'k03t03l0nc4tj03ngk1rb4lik');
	define ('SMPDATABASEPORT', '5433');
	define ('SMPDATABASEHOST', 'localhost');

	define ('SQLITEPASSWORD', 'd4p0d1kd45p455');
	// define ('URLUPLOAD', 'http://data_dikdas/upload.php');
	define ('URLUPLOAD', 'http://66.nufaza.co.id:8160/index.php');

	define ('SERVERURL', 'http://dapo.dikdas.kemdikbud.go.id');
	define ('URLSYNC', 'http://sinkronisasi:8313/index_standalone.php');
	define ('URLPUSHPREFILL', 'http://registration:8313/push_prefill.php');

?>