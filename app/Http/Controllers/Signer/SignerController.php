<?php

namespace App\Http\Controllers\Signer;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use setasign\Fpdi\Tfpdf;

class SignerController extends Controller
{
    public function view()
    {
        return view('apps.app');

    }
    public function generate(Request $request)
    {
        $fpdi = new Tfpdf\Fpdi();

        $item = json_decode($request->input('itemInput'), true);
        $signedPage = $item['page'];
        $openedFile = $request->file('itemFile')->getRealPath();

        $fileName = pathinfo($request->file('itemFile')->getClientOriginalName(), PATHINFO_FILENAME);

        $filepdf = fopen($openedFile, "r"); // read pdf file first line because pdf first line contains pdf version information
        if ($filepdf) {
            $line_first = fgets($filepdf);
            fclose($filepdf);
        } else {
            echo "error opening the file.";
        }

        preg_match_all('!\d+!', $line_first, $matches); // extract number such as 1.4,1.5 from first read line of pdf file

 
        $pdfversion = implode('.', $matches[0]); // save that number in a variable
        if ($pdfversion > "1.4") { //if above 1.4 version, using ghostscript version
            $tempNewFile = tempnam(sys_get_temp_dir(), Str::random());

            shell_exec('gs -dBATCH -dNOPAUSE -dAutoRotatePages=/None -q -sDEVICE=pdfwrite -sOutputFile="' . $tempNewFile . '" "' . $request->file('itemFile') . '"');

            $pagecount = $fpdi->setSourceFile($tempNewFile);

        } else { //if 1.4 and below, using tfpdf instead

            $pagecount = $fpdi->setSourceFile($openedFile);

        }

        for ($i = 0; $i < $pagecount; $i++) {


            if ($i == ($signedPage - 1)) {
                $tppl = $fpdi->importPage($i + 1);
                $sizeTemplate = $fpdi->getTemplatesize($tppl);
                $fpdi->AddPage($sizeTemplate['orientation'], [$sizeTemplate['width'], $sizeTemplate['height']]);
                $fpdi->useTemplate($tppl);
                $targetY = $item['elementTop'] / $item['parentHeight'] * $sizeTemplate['height'];
                $targetX = $item['elementLeft'] / $item['parentWidth'] * $sizeTemplate['width'];
                $targetHeight = $item['height'] / $item['parentHeight'] * $sizeTemplate['height'];
                $targetWidth = $item['width'] / $item['parentWidth'] * $sizeTemplate['width'];
                // $fpdi->Image("images/stamp.png", $targetX - ($targetWidth / 2), $targetY - ($targetHeight / 2), $targetWidth, $targetHeight, 'PNG');
                $fpdi->Image($request->input('itemSignData'), $targetX - ($targetWidth / 2), $targetY - ($targetHeight / 2), $targetWidth, $targetHeight, 'PNG');
            }
            if ($i != ($signedPage - 1)) {
                $tppl = $fpdi->importPage($i + 1);
                $sizeTemplate = $fpdi->getTemplatesize($tppl);
                $fpdi->AddPage($sizeTemplate['orientation'], [$sizeTemplate['width'], $sizeTemplate['height']]);
                $fpdi->useTemplate($tppl);
            }

        }
        // $fpdi->Output("D","{$fileName}-SIGN.pdf",true);
        // setlocale(LC_TIME, 'id');
        $tz = $request->input('timeZone') ?? null;
        $tz = $tz != 'undefined' ? $tz : null;
        $dateTime = Carbon::now($tz)->format('d-M-y His');
        return response($fpdi->Output('S', "{$fileName}-SIGN.pdf", true), 200, array(
            'Content-Type' => 'application/pdf', 'Filename' => "{$fileName} SIGNED {$dateTime}.pdf"));
        // return new Response();
    }
    public function base64_to_jpeg($base64_string, $output_file)
    {

        $ifp = fopen($output_file, 'wb');

        return $output_file;
    }
}
