<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// We want to see the session cart
$session = $request->getSession();
if ($session) {
    $cart = $session->get('cart');
    file_put_contents('cart_debug.txt', print_r($cart, true));
}
