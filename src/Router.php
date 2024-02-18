<?php

class Router
{
    /**
     * @var Request
     */
    protected Request $request;
    /**
     * @var array|array[]
     */
    protected array $routes = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param callable $handler
     * @return void
     */
    public function addRoute(string $method, string $uri, callable $handler): void
    {
        $uri = str_replace('/', '\/', $uri);
        $uri = '/^' . $uri . '$/';
        $this->routes[$method][$uri] = $handler;
    }

    /**
     * @param string $uri
     * @param callable $handler
     * @return void
     */
    public function get(string $uri, callable $handler): void
    {
        $this->addRoute('GET', $uri, $handler);
    }

    /**
     * @param string $uri
     * @param callable $handler
     * @return void
     */
    public function post(string $uri, callable $handler): void
    {
        $this->addRoute('POST', $uri, $handler);
    }

    /**
     * @return Response
     */
    public function resolve(): Response
    {
        $requestedUri = $this->request->getUri();
        $requestedMethod = $this->request->getMethod();

        foreach ($this->routes[$requestedMethod] as $uri => $handler) {
            if (preg_match($uri, $requestedUri)) {
                return $handler($this->request);
            }
        }

        return new Response(404, ["response" => "Not Found"]);
    }
}