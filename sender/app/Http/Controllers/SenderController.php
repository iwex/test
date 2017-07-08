<?php

namespace App\Http\Controllers;

use App\Domains\Receiver\Api;
use App\Domains\ZipEncrypter\Processor;
use App\FilesHistory;
use App\Http\Requests\SendFileRequest;

class SenderController extends Controller
{
    /**
     * Main page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $history = FilesHistory::all();
        
        return view('welcome', compact('history'));
    }
    
    /**
     * @param \App\Http\Requests\SendFileRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processZip(SendFileRequest $request)
    {
        $uploadedZip = $request->file('zip');
        $zipName     = $uploadedZip->getClientOriginalName();
        
        $encrypter = new Processor();
        [$ok, $files] = $encrypter->process($uploadedZip);
        
        if (!$ok) {
            return $this->redirectError($files);
        }
    
        $apiConnector = new Api();
        [$ok, $result] = $apiConnector->sendFiles($zipName, $files);
        
        if (!$ok) {
            return $this->redirectError($result);
        }
        
        FilesHistory::create(['name' => $zipName]);
        
        return redirect('/');
    }
    
    /**
     * @param $message
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectError($message)
    {
        return redirect('/')->withErrors($message);
    }
}
