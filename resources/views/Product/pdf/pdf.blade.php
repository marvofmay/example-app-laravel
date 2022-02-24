<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $title }}</title>
    </head>
    <body>
        <h1>{{ $title }}</h1>
        <h2>{{ $product->name }}</h2>
        <h3>{{ $product->description }}</h3>
        <p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p> 
        <p>utworzona: {{ $product->created_at->format("Y-m-d, H:i:s") }}</hp>
    </body>
</html>