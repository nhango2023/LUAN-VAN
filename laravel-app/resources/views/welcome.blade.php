<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @vite('resources/js/app.js')
</body>
<script>
    setTimeout(() => {
        console.log('test');
        window.Echo.channel('testChannel')
            .listen('testingEvent', (e) => {
                console.log(e);
            })
    }, 2000);
</script>

</html>
