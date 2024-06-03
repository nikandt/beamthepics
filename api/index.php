<?php
phpinfo();
require __DIR__ . '/../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;

$url = 'https://beamthepics-7xalo1s9t-nikandts-projects.vercel.app/';

$result = Builder::create()
    ->writer(new PngWriter())
    ->writerOptions([])
    ->data($url)
    ->encoding(new \Endroid\QrCode\Encoding\Encoding('UTF-8'))
    ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
    ->size(300)
    ->margin(10)
    ->labelText('Scan Me')
    ->labelFont(new \Endroid\QrCode\Label\Font\NotoSans(20))
    ->labelAlignment(new LabelAlignmentCenter())
    ->validateResult(false)
    ->build();

header('Content-Type: '.$result->getMimeType());
echo $result->getString();
?>
