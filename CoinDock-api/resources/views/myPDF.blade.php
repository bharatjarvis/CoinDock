<!DOCTYPE html>
<html>

<head>
    <title>RecoveryWords</title>
</head>

<body>

    <ol>
        @foreach ($words_array as $word)
        <li>{{$word}}</li>
        @endforeach
    </ol>

</body>

</html>