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

    /**
     * S-12: $message is shown to the end user, so keep it generic. Pass the original error as
     * $previous: its details go to the application log (see context()), never to the user.
     */
    public function __construct($message, $status = null, ?\Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->status = !$status ? $this->status : $status;
    }

    /**
     * Laravel adds this to the log entry when the exception is reported.
     */
    public function context()
    {
        $previous = $this->getPrevious();

        return $previous ? [
            'murugo_status' => $this->status,
            'murugo_error' => $previous->getMessage(),
        ] : [];
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
