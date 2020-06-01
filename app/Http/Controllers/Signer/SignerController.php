<?php

namespace App\Http\Controllers\Signer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use setasign\Fpdi\Tfpdf;
use Carbon\Carbon;

class SignerController extends Controller
{
    public function index()
    {
        $fpdi = new Tfpdf\Fpdi();
// $fpdftpl = new Tfpdf\FpdfTpl();

        //Set the source PDF file
        $pagecount = $fpdi->setSourceFile("test2.pdf");

        $signedPage = 1;

        //Import the first page of the file

        //Use this page as template
        // use the imported page and place it at point 20,30 with a width of 170 mm
        #Print Hello World at the bottom of the page

        //Select Arial italic 8
        $tpl = $fpdi->importPage(1);
        $sizeTemplate = $fpdi->getTemplatesize($tpl);
        return $sizeTemplate;

        //$fpdi->Write(0, “Hello World”);

        // $targetX =

        for ($i = 0; $i < $pagecount; $i++) {
            if ($i == ($signedPage - 1)) {
                $fpdi->AddPage();
                $tppl = $fpdi->importPage($i + 1);
                $fpdi->useTemplate($tppl);
                $fpdi->Image("logo.png", 105 - 7.5, 148 - 7.5, 15, 15);
            }
            if ($i != ($signedPage - 1)) {
                $fpdi->AddPage();
                $tppl = $fpdi->importPage($i + 1);
                $fpdi->useTemplate($tppl);
            }

        }
        $fpdi->Output();
    }
    public function generate(Request $request)
    {
        $fpdi = new Tfpdf\Fpdi();

        $item = json_decode($request->input('itemInput'), true);
        $openedFile = $request->file('itemFile')->getRealPath();
        $fileName = pathinfo($request->file('itemFile')->getClientOriginalName(), PATHINFO_FILENAME);
        $pagecount = $fpdi->setSourceFile($openedFile);
        $signedPage = $item['page'];

        for ($i = 0; $i < $pagecount; $i++) {
            if ($i == ($signedPage - 1)) {
              $tppl = $fpdi->importPage($i + 1);
              $sizeTemplate = $fpdi->getTemplatesize($tppl);
              $fpdi->AddPage($sizeTemplate['orientation'],[$sizeTemplate['width'],$sizeTemplate['height']]);
              $fpdi->useTemplate($tppl);
                $targetY = $item['elementTop'] / $item['parentHeight'] * $sizeTemplate['height'];
                $targetX = $item['elementLeft'] / $item['parentWidth'] * $sizeTemplate['width'];
                $targetHeight = $item['height'] / $item['parentHeight'] * $sizeTemplate['height'];
                $targetWidth = $item['width'] / $item['parentWidth'] * $sizeTemplate['width'];
                $fpdi->Image($request->input('itemSignData'), $targetX - ($targetWidth / 2), $targetY - ($targetHeight / 2), $targetWidth, $targetHeight,'PNG');
            }
            if ($i != ($signedPage - 1)) {
              $tppl = $fpdi->importPage($i + 1);
              $sizeTemplate = $fpdi->getTemplatesize($tppl);
              $fpdi->AddPage($sizeTemplate['orientation'],[$sizeTemplate['width'],$sizeTemplate['height']]);
              $fpdi->useTemplate($tppl);
            }

        }
        // $fpdi->Output("D","{$fileName}-SIGN.pdf",true);
      // setlocale(LC_TIME, 'id');
      $tz = $request->input('timeZone') ?? null;
      $dateTime = Carbon::now($tz)->format('d-M-y His');
        return response($fpdi->Output('S',"{$fileName}-SIGN.pdf",true), 200, array(
        'Content-Type' => 'application/pdf','Filename' => "{$fileName} SIGNED {$dateTime}.pdf"));
 return new Response();
    }
    public function base64_to_jpeg($base64_string, $output_file) {

        $ifp = fopen( $output_file, 'wb' );


        return $output_file;
    }
}
