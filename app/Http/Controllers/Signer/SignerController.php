<?php

namespace App\Http\Controllers\Signer;

use App\Http\Controllers\Controller;
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



        //$fpdi->Write(0, “Hello World”);
        for ($i = 0; $i < $pagecount; $i++) {
            if ($i == ( $signedPage - 1)) {
                $fpdi->AddPage();
                $tppl = $fpdi->importPage($i + 1);
                $fpdi->useTemplate($tppl);
                $fpdi->Image("logo.png", 40, 80, 15, 15);
            }
            if ($i != ( $signedPage - 1)) {
                $fpdi->AddPage();
                $tppl = $fpdi->importPage($i + 1);
                $fpdi->useTemplate($tppl);
            }



        }
        $fpdi->Output();
    }
}
