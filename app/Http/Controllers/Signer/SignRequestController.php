<?php

namespace App\Http\Controllers\Signer;

use App;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessSignRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SignRequestController extends Controller
{
    public function view()
    {
        return view('apps.sign-request');
    }
    public function store(Request $request)
    {
        $item = json_decode($request->input('itemInput'), true);

        $requester = new App\Requester();
        $requester->name = $item['requester']['name'];
        $requester->email = $item['requester']['email'];
        $requester->message = $item['requester']['messages'];
        $requester->filename = $item['fileName'];
        $requester->public_id = Str::random(100) . time();
        $requester->save();

        for ($i = 0; $i < count($item['signer']); $i++) {
            $signer = new App\Signer();
            $signer->name = $item['signer'][$i]['name'];
            $signer->email = $item['signer'][$i]['email'];
            $signer->token = Str::random(100) . time();
            $signer->sign_status_id = 1;
            $signer->requester_id = $requester->id;
            $signer->save();
            for ($a = 0; $a < count($item['signer'][$i]['area']); $a++) {
                $area_data = $item['signer'][$i]['area'][$a];
                $sign_area = App\SignArea::create([
                    'width' => $area_data['width'],
                    'height' => $area_data['height'],
                    'element_top' => $area_data['elementTop'],
                    'element_left' => $area_data['elementLeft'],
                    'top' => $area_data['top'],
                    'left' => $area_data['left'],
                    'parent_width' => $area_data['parentWidth'],
                    'parent_height' => $area_data['parentHeight'],
                    'target_page' => $area_data['targetPage'],
                    'signer_id' => $signer->id]
                );
            }

        }
        $encrypted_filename = hash('sha256', $requester->email . $requester->filename . $requester->id);
        $file = $request->file('itemFile');
        // $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileContent = $file->get();
        $encryptedContent = Crypt::encryptString($fileContent);

        Storage::disk('local')->put("requested_files/{$encrypted_filename}", $encryptedContent);
        // Storage::disk('local')->putFileAs("requested_files", $encryptedContent, "{$fileName}.pdf");

        // $encryptedFile = Storage::get("requested_files/file.dat");
        // $decryptedContent = Crypt::decryptString($encryptedFile);
        // Storage::disk('local')->put("requested_files/file.pdf", $decryptedContent);
        $data = App\Requester::where('id', $requester->id)->with('signers')->first();
        dispatch(new ProcessSignRequest($data));

        return response()->json(['message' => 'success'], 200);
    }
}
