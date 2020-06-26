<?php

namespace RwandaBuild\MurugoAuth\Exceptions;

//namespace App\Exceptions;

use Exception;

class MurugoAuthException extends Exception
{

    /**
     * will contain the error status
     * default = 400
     * @var int
     */
    protected $status = 400;

    public function __construct($message, $status = null)
    {
        parent::__construct($message);
        $this->status = !$status ? $this->status : $status;
    }

    /**
     * Laravel method which will render page or return json
     * This will be called by the framework
     */
    public function render()
    {
        return $this->detectResponseType();
    }

    /**
     * This is a custom method which check if request is json or not
     * Response for web page or return api response
     */
    private function detectResponseType()
    {
        return response()->json($this->buildData(), $this->status);
    }

    /**
     * Arrange the response message
     * And return message
     */
    public function buildData()
    {
        return [
            'success' => false,
            'message' => $this->getMessage(),
        ];
    }
}
