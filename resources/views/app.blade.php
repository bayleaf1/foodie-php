<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <!-- <link rel="preconnect" href="https://fonts.bunny.net"> -->
    <!-- <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" /> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playwrite+NG+Modern:wght@100..400&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="font-sans antialiased bg-white">
    <div id="app"></div>
    @vite('resources/js/app.js')
    <script type="text/javascript">

        ;[...document.querySelectorAll('link')].forEach((e) => {
            let href = e.getAttribute('href') || ''
            console.log(href)
            e.setAttribute('href', href.replace('http://foodie', 'https://foodie'))
        })

            ;[...document.querySelectorAll('script')].forEach((e) => {
                // let href = e.getAttribute('src') || ''
                // console.log(href)
                let upd = href.replace('http://foodie', 'https://foodie');
                let s = document.createElement('script')
                s.setAttribute('src', upd)
                s.setAttribute('type', "module")
                document.body.appendChild(s);

            })


    </script>
</body>

</html>