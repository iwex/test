<?php

namespace App\Http\Controllers;

use App\Domains\ZipDecrypter\Processor;
use App\File;
use Illuminate\Http\Request;

class ReceiverController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function process(Request $request)
    {
        $files = $request->input('content', []);
        
        $fileName = $request->input('name');
        
        $decrypter = new Processor;
        [$ok, $files] = $decrypter->process($files);
        
        if (!$ok) {
            return response('internal error', 500);
        }
        
        File::create(
            [
                'name'    => $fileName,
                'content' => $files
            ]
        );
        
        return response('ok');
    }
}
