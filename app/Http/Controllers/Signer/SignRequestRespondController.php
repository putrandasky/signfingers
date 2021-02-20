<?php

namespace App\Http\Controllers\Signer;

use App;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessRespondingSignRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use setasign\Fpdi\Tfpdf;

class SignRequestRespondController extends Controller
{
    public function view()
    {
        return view('apps.sign-request-respond');
    }
    public function show(Request $request, $signer_token)
    {
        $signer = App\Signer::where('token', $signer_token)->with('requester')->first();

        if (!$signer) {
            # code...
            return response()->json(['status' => 'File not found', 'message' => 'Request is not found, please check your link'], 401);
        }
        $signer = App\Signer::where('token', $signer_token)->with('requester', 'signAreas', 'signStatus')->first();

        $encrypted_filename = hash('sha256', $signer->requester->email . $signer->requester->filename . $signer->requester->id);
        $is_file_exist = Storage::disk('local')->exists("requested_files/{$encrypted_filename}");
        if (!$is_file_exist) {
            # code...
            return response()->json(['status' => 'File not found', 'message' => 'The file is already deleted'], 401);
        }
//check if document already signed

        if ($signer->signStatus->id == 3) {
            # code...
            return response()->json(['status' => 'Unauthorized', 'message' => 'Your document already signed'], 401);
        }
        // if ($signer->signStatus->id == 1) {
        //     # code...
        //     return response()->json(['status' => 'Unauthorized', 'message' => 'You can not sign this document for now'], 401);
        // }
        if ($signer->signStatus->id == 2 || $signer->signStatus->id == 1) {
            # code...
            return response()->json(['status' => 'Authorized', 'signer_data' => $signer], 200);
        }

        // return $data;
    }
    public function store(Request $request, $signer_token)
    {
        $signer = App\Signer::where('token', $signer_token)->with('requester', 'signAreas')->first();
        if ($signer->sign_status_id != 2 && $signer->sign_status_id != 1) {
            return response()->json(['status' => 'Unauthorized', 'message' => 'You dont have any authorization'], 401);
        }
        $encrypted_filename = hash('sha256', $signer->requester->email . $signer->requester->filename . $signer->requester->id);
        $is_file_exist = Storage::disk('local')->exists("requested_files/{$encrypted_filename}");
        if (!$is_file_exist) {
            # code...
            return response()->json(['status' => 'File not found', 'message' => 'The file is already deleted'], 401);
        }

        $requester = $signer->requester;
        $sign_areas = $signer->signAreas;
        $encrypted_filename = hash('sha256', $requester->email . $requester->filename . $requester->id);
        $encryptedFile = Storage::get("requested_files/{$encrypted_filename}");
        $decryptedContent = Crypt::decryptString($encryptedFile);

        $tempNewFile = tempnam(sys_get_temp_dir(), Str::random());
        // $handle = fopen($tempNewFile, "w");

        // fwrite($handle, $decryptedContent);
        // fclose($handle);
        // $tempNewFile2 = tempnam(sys_get_temp_dir(), Str::random());
        file_put_contents($tempNewFile, $decryptedContent);
        $tempNewFile2 = tempnam(sys_get_temp_dir(), Str::random());

        shell_exec('gs -dBATCH -dNOPAUSE -dAutoRotatePages=/None -q -sDEVICE=pdfwrite -sOutputFile="' . $tempNewFile2 . '" "' . $tempNewFile . '"');

        $fpdi = new Tfpdf\Fpdi();
        $pagecount = $fpdi->setSourceFile($tempNewFile2);
        // $pagecount = $fpdi->setSourceFile($tempNewFile);
        for ($i = 0; $i < $pagecount; $i++) {

            if ($i == ($sign_areas[0]['target_page'] - 1)) {
                $tppl = $fpdi->importPage($i + 1);
                $sizeTemplate = $fpdi->getTemplatesize($tppl);
                $fpdi->AddPage($sizeTemplate['orientation'], [$sizeTemplate['width'], $sizeTemplate['height']]);
                $fpdi->useTemplate($tppl);
                $targetY = $sign_areas[0]['element_top'] / $sign_areas[0]['parent_height'] * $sizeTemplate['height'];
                $targetX = $sign_areas[0]['element_left'] / $sign_areas[0]['parent_width'] * $sizeTemplate['width'];
                $targetHeight = $sign_areas[0]['height'] / $sign_areas[0]['parent_height'] * $sizeTemplate['height'];
                $targetWidth = $sign_areas[0]['width'] / $sign_areas[0]['parent_width'] * $sizeTemplate['width'];
                // $fpdi->Image("images/stamp.png", $targetX - ($targetWidth / 2), $targetY - ($targetHeight / 2), $targetWidth, $targetHeight, 'PNG');
                $fpdi->Image($request->input('itemSignData'), $targetX - ($targetWidth / 2), $targetY - ($targetHeight / 2), $targetWidth, $targetHeight, 'PNG');
            }
            if ($i != ($sign_areas[0]['target_page'] - 1)) {
                $tppl = $fpdi->importPage($i + 1);
                $sizeTemplate = $fpdi->getTemplatesize($tppl);
                $fpdi->AddPage($sizeTemplate['orientation'], [$sizeTemplate['width'], $sizeTemplate['height']]);
                $fpdi->useTemplate($tppl);
            }

        }
        $encrypted_signed_content = Crypt::encryptString($fpdi->Output('S'));
        $encrypted_signed_filename = hash('sha256', $requester->email . $requester->filename . $requester->id . '-Signed');

        Storage::disk('local')->put("requested_files/{$encrypted_signed_filename}", $encrypted_signed_content);
        $data = App\Signer::where('token', $signer_token)->with('requester')->first();
        dispatch(new ProcessRespondingSignRequest($data));

        $signer->sign_status_id = 3;
        $signer->save();

        return response()->json(['message' => 'success'], 200);

        // $getEncryptedSignedContent = Storage::get("requested_files/encrypted-SIGN.pdf");
        // $decryptedSignedContent = Crypt::decryptString($getEncryptedSignedContent);
        // Storage::disk('local')->put("requested_files/decrypted-SIGN.pdf", $decryptedSignedContent);

        // return response($fpdi->Output('S', "{$requester->filename}-SIGN.pdf", true), 200, array(
        //     'Content-Type' => 'application/pdf', 'Filename' => "{$requester->filename} SIGNED.pdf"));

    }

}
