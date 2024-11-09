<?php

namespace swapinvidya\HuggingFaceClient\Exceptions;

use Exception;

class HuggingFaceClientException extends Exception
{
    /**
     * Create a new HuggingFaceClientException instance.
     *
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct($message = 'An error occurred with Hugging Face API', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the custom error message for this exception.
     *
     * @return string
     */
    public function errorMessage()
    {
        return "Hugging Face Client Error: " . $this->getMessage();
    }
}
