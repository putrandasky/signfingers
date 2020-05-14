<?php

namespace App\Http\Controllers\Signer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use setasign\Fpdi\Tfpdf;

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
// return  $_FILES['itemFile'];json_decode($request->input('itemInput'), true);
// return $request->input('itemSignData');
// $base64_image = $request->input('itemSignData');
// $dataImage = str_replace('data:image/png;base64,', '', $base64_image);
// $dataImage = str_replace(' ', '+', $dataImage);
// return $dataImage;
        $item = json_decode($request->input('itemInput'), true);
// return $item['elementTop'];
        $openedFile = $request->file('itemFile')->getRealPath();
        $pagecount = $fpdi->setSourceFile($openedFile);
        $signedPage = 1;

        for ($i = 0; $i < $pagecount; $i++) {
            if ($i == ($signedPage - 1)) {
                $fpdi->AddPage();
                $tppl = $fpdi->importPage($i + 1);
                $sizeTemplate = $fpdi->getTemplatesize($tppl);
                $fpdi->useTemplate($tppl);
                $targetY = $item['elementTop'] / $item['parentHeight'] * $sizeTemplate['height'];
                $targetX = $item['elementLeft'] / $item['parentWidth'] * $sizeTemplate['width'];
                $targetHeight = $item['height'] / $item['parentHeight'] * $sizeTemplate['height'];
                $targetWidth = $item['width'] / $item['parentWidth'] * $sizeTemplate['width'];
                $fpdi->Image($this->base64_to_jpeg($request->input('itemSignData'),'sign.png'), $targetX - ($targetWidth / 2), $targetY - ($targetHeight / 2), $targetWidth, $targetHeight);
            }
            if ($i != ($signedPage - 1)) {
                $fpdi->AddPage();
                $tppl = $fpdi->importPage($i + 1);
                $fpdi->useTemplate($tppl);
            }

        }
        $fpdi->Output('test.pdf', "D");
    }
    public function base64_to_jpeg($base64_string, $output_file) {
        // open the output file for writing
        $ifp = fopen( $output_file, 'wb' );

        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );

        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );

        // clean up the file resource
        fclose( $ifp );

        return $output_file;
    }
}
