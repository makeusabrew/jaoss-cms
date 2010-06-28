<?php
//set_include_path(get_include_path() . PATH_SEPARATOR . "../");
chdir("../");
ini_set("display_errors", 1);
ini_set("html_errors", "On");
error_reporting(E_ALL ^ E_STRICT);
include("library/core_exception.php");
include("library/error_handler.php");
include("library/path.php");
include("library/path_manager.php");
include("library/request.php");
include("library/controller.php");
include("library/settings.php");
include("library/database.php");
include("library/table.php");
include("library/object.php");
include("library/app.php");
include("library/app_manager.php");
include("library/session.php");

try {
	include("library/boot.php");
	include("library/load_apps.php");
	
	$request = new Request();
	$response = $request->dispatch();
	
	exit($response);
} catch (Exception $e) {
	$handler = new ErrorHandler();
	exit($handler->handleError($e));
}
