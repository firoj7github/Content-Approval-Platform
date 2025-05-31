<!DOCTYPE html>
<html>
<head>
    <title>Post Status Changed</title>
</head>
<body>
    <h2>Hello {{ $post->user->name }},</h2>
    <p>Your post titled "<strong>{{ $post->title }}</strong>" has been <strong>{{ ucfirst($post->status) }}</strong>.</p>
</body>
</html>
