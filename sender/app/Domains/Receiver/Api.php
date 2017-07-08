<?php

namespace App\Domains\Receiver;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Response;

class Api
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;
    
    public function __construct(Client $client = null)
    {
        $this->client = $client ?? new Client;
    }
    
    public function sendFiles(string $zipName, array $files)
    {
        try {
            $this->client->post(
                config('services.receiver.url'),
                [
                    'json' => ['content' => $files, 'name' => $zipName],
                    'auth' => $this->credentials()
                ]
            );
        } catch (RequestException $exception) {
            $message = 'Something went wrong';
            
            if ($this->checkAuth($exception)) {
                $message = 'Wrong username or password';
            }
            
            return $this->result(false, $message);
        }
        
        return $this->result(true);
    }
    
    
    /**
     * Get credentials for receiver
     *
     * @return array
     */
    public function credentials()
    {
        return [config('auth.auth_username'), config('auth.auth_password')];
    }
    
    /**
     * @param RequestException $exception
     *
     * @return bool
     */
    protected function checkAuth(RequestException $exception) : bool
    {
        return $exception->getCode() == Response::HTTP_UNAUTHORIZED;
    }
    
    /**
     * @param string $status
     * @param string $message
     *
     * @return array
     */
    public function result(string $status, string $message = '')
    {
        return [$status, $message];
    }
}