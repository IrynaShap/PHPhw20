<?php

class Response
{
    /**
     * @var int
     */
    protected int $statusCode;
    /**
     * @var array
     */
    protected array $data;

    /**
     * @param int $statusCode
     * @param array $data
     */
    public function __construct(int $statusCode, array $data = [])
    {
        $this->statusCode = $statusCode;
        $this->data = $data;
    }

    /**
     * @return string
     * @throws JsonException
     */
    public function __toString(): string
    {
        http_response_code($this->statusCode);
        return $this->processBody();
    }

    /**
     * @throws JsonException
     */
    protected function processBody(): string
    {
        header('Content-Type: application/json');
        return json_encode($this->data, JSON_THROW_ON_ERROR);
    }
}