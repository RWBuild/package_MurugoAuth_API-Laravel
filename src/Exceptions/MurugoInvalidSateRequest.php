<?php

namespace RwandaBuild\MurugoAuth\Exceptions;

use Exception;
use RwandaBuild\MurugoAuth\Facades\MurugoAuth2;

class MurugoInvalidSateRequest extends Exception
{
    public function __construct($message = '')
    {
        parent::__construct($message);
        $this->status = 403;
    }

    /**
     * Laravel property
     * This will be called by the framework
     */
    public function render()
    {
        $resp = $this->buildResponse();

        return $resp;
    }

    /**
     * Response to return for this exception
     */
    public function buildResponse()
    {
        return $this->detectResponseType();
    }

    /**
     * reponse for web and ip request
     */
    private function detectResponseType()
    {
        return response()->json($this->buildData(), $this->status);
    }

    /**
     * arrange the response message
     */
    public function buildData()
    {
        return [
            'success' => false,
            'message' => $this->getMessage() 
        ];
    }
}