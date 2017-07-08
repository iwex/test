<?php

namespace App\Domains\ZipDecrypter;

use Illuminate\Encryption\Encrypter;

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
        $this->encrypter = $encrypter ?? new Encrypter(config('receiver.encryption_key'));
    }
    
    /**
     * Get list of files and encrypt them
     *
     * @param array $files
     *
     * @return array
     */
    public function process(array $files)
    {
        try {
            $files = $this->decryptFileNames($files);
        } catch (\Throwable $exception) {
            $this->result(false);
        }
        
        return $this->result(true, $files);
    }
    
    /**
     * Encrypt every node
     *
     * @param array $files
     *
     * @return array
     */
    protected function decryptFileNames(array $files)
    {
        return array_map(
            function ($node) {
                return $this->encrypter->decryptString($node);
            },
            $files
        );
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
}