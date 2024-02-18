<?php
require __DIR__ . '/../vendor/autoload.php';

$request = new Request();
$router = new Router($request);

$router->get('/(endpoint.php)(\?.*)?', function () {
    return new Response(200, ['response' => 'Hello, World!']);
});

$router->post('/endpoint.php', function (Request $request) {
    $data = $request->getBody();
    $num1 = $data['num1'] ?? null;
    $num2 = $data['num2'] ?? null;

    if ($num1 === null || $num2 === null) {
        return new Response(400, ['error' => 'Both numbers must be provided']);
    }

    if (!filter_var($num1, FILTER_VALIDATE_FLOAT) || !filter_var($num2, FILTER_VALIDATE_FLOAT)) {
        return new Response(400, ['error' => 'Both inputs must be numbers']);
    }

    $result = $num1 + $num2;
    return new Response(200, ['response' => $result]);
});

echo $router->resolve();