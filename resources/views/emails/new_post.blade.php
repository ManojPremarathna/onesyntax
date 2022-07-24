<!DOCTYPE html>
<html>
<head>
    <title>New Post : {{ $post->website->name }}</title>
</head>
<body>

<h2>
    {{ $post->title }}
</h2>

<p>{{ $post->description }}</p>

</body>
</html>
