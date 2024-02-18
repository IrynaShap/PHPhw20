<?php

class Request
{
    /**
     * @var array
     */
    protected array $server;
    /**
     * @var array
     */
    protected array $post;
    /**
     * @var array
     */
    protected array $get;
    /**
     * @var mixed
     */
    protected mixed $body;

    /**
     *
     */
    public function __construct()
    {
        $this->server = $_SERVER;
        $this->post = $_POST;
        $this->get = $_GET;
        $this->body = $this->getContents();
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->server['REQUEST_URI'];
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    /**
     * @return mixed
     */
    public function getBody(): mixed
    {
        return $this->body;
    }

    /**
     * @return array
     */
    private function getContents(): array
    {
        if ($this->getMethod() === "POST") {
            return $this->post;
        }

        return $this->get;
    }

}