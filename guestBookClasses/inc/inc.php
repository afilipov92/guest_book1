<?php
error_reporting(E_ALL);
session_start();

define('TPL_DIR', 'tpl');

require_once(__DIR__ . DIRECTORY_SEPARATOR . "Form.php");
require_once(__DIR__ . DIRECTORY_SEPARATOR . "Template.php");
require_once(__DIR__ . DIRECTORY_SEPARATOR . "Page.php");
require_once(__DIR__ . DIRECTORY_SEPARATOR . "IMessages.php");
require_once(__DIR__ . DIRECTORY_SEPARATOR . "DB.php");
require_once(__DIR__ . DIRECTORY_SEPARATOR . "Files.php");