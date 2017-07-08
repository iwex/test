<?php

namespace App\Domains\ZipEncrypter;

use Comodojo\Exception\ZipException;
use Comodojo\Zip\Zip;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\UploadedFile;

class Processor
{
    /**
     * @var \Illuminate\Encryption\Encrypter
     */
    private $encrypter;
    
    /**
     * ZipProcessor constructor.
     *
     * @param \Illuminate\Encryption\Encrypter|null $encrypter
     */
    public function __construct(Encrypter $encrypter = null)
    {
        $this->encrypter = $encrypter ?? new Encrypter(config('app.encryption_key'));
    }
    
    /**
     * Get list of files and encrypt them
     *
     * @param \Illuminate\Http\UploadedFile $file
     *
     * @return array
     */
    public function process(UploadedFile $file)
    {
        try {
            Zip::check($file->path());
        } catch (ZipException $exception) {
            return $this->result(false, 'Corrupted file');
        }
    
        $zip = Zip::open($file->path());
    
        $files = $this->encryptFileNames($zip->listFiles());
        
        return $this->result(true, $files);
    }
    
    /**
     * @param $status
     * @param $result
     *
     * @return array
     */
    public function result(bool $status, $result = null)
    {
        return [$status, $result];
    }
    
    /**
     * Encrypt every node
     *
     * @param array $files
     *
     * @return array
     */
    protected function encryptFileNames(array $files)
    {
        return array_map(function ($node) {
            return $this->encrypter->encryptString($node);
        }, $files);
    }
}