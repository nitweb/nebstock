<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>404 - Page Not Found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.png') }}">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background: #f8f9fa;
            text-align: center;
        }
        h1 { font-size: 6rem; margin: 0; color: #dc3545; }
        p { font-size: 1.25rem; color: #555; margin: 10px 0 25px; }
        a {
            display: inline-block;
            padding: 10px 24px;
            background: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div>
        <h1>404</h1>
        <p>Sorry, the page you are looking for could not be found.</p>
        <a href="{{ route('index') }}">Go to Homepage</a>
    </div>
</body>
</html>
