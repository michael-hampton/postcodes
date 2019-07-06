<?php

require_once 'config/Config.php';
require_once 'models/DatabaseInterface.php';
require_once 'models/Database.php';
require_once 'models/ImportInterface.php';
require_once 'models/Import.php';
require_once 'controllers/PostcodeController.php';
require_once 'models/PostcodeRepositoryInterface.php';
require_once 'models/RestClientInterface.php';
require_once 'models/RestClient.php';
require_once 'models/PostcodeRepository.php';

if (empty($argv) || empty($argv[1]))
{
    die('you must specify the method you want to run');
}

$method = $argv[1];

$blDoImport = false;
$blPartial = false;

$objPostcodeController = new PostcodeController();

switch ($method)
{
    case 'getNearestPostcodesFromLongLat':

        // php console.php getNearestPostcodesFromLongLat -1.647370 50.748600

        if (empty($argv[2]) || empty($argv[3]))
        {

            die('You must enter a longitude and latitude');
        }

        $arrPostcodes = $objPostcodeController->getNearestPostcodesFromLongLat($argv[2], $argv[3]);

        if (!empty($argv[4]) && trim($argv[4]) == 'import')
        {
            // do import
            $blDoImport = true;
        }

        break;

    case 'getPartial':
        // php console.php getPartial BH25

        if (empty($argv[2]))
        {

            die('You must enter a partial postcode');
        }

        $arrPostcodes = $objPostcodeController->getPartial($argv[2]);

        if (!empty($argv[3]) && trim($argv[3]) == 'import')
        {
            // do import
            $blDoImport = true;
            $blPartial = true;
        }

        break;

    case 'getAllPostcodes':

        // php console.php getAllPostcodes

        $arrPostcodes = $objPostcodeController->getAllPostcodes();

        if (!empty($argv[2]) && trim($argv[2]) == 'import')
        {
            // do import
            $blDoImport = true;
        }

        break;
}

if (!$arrPostcodes)
{
    $strMessage = "There was an issue returning the data";

    $arrMessages = $objPostcodeController->getMessages();

    if (is_array($arrMessages) || !empty($arrMessages))
    {

        $strMessage .= implode('<br/>', $arrMessages);
    }
}

if (empty($arrPostcodes))
{

    die('No postcodes could be found');
}

//echo json_encode($arrPostcodes);

if($blDoImport) {
    $objPostcodeController->import($blPartial);
}

