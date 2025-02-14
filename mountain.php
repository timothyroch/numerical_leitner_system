<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Background Animation</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        body {
            background-color: hsla(200, 40%, 30%, 0.4);
            background-image:   
                url('https://78.media.tumblr.com/cae86e76225a25b17332dfc9cf8b1121/tumblr_p7n8kqHMuD1uy4lhuo1_540.png'), 
                url('https://78.media.tumblr.com/66445d34fe560351d474af69ef3f2fb0/tumblr_p7n908E1Jb1uy4lhuo1_1280.png'),
                url('https://78.media.tumblr.com/8cd0a12b7d9d5ba2c7d26f42c25de99f/tumblr_p7n8kqHMuD1uy4lhuo2_1280.png'),
                url('https://78.media.tumblr.com/5ecb41b654f4e8878f59445b948ede50/tumblr_p7n8on19cV1uy4lhuo1_1280.png'),
                url('https://78.media.tumblr.com/28bd9a2522fbf8981d680317ccbf4282/tumblr_p7n8kqHMuD1uy4lhuo3_1280.png');
            background-repeat: repeat-x;
            background-position: 
                0 20%,
                0 100%,
                0 50%,
                0 100%,
                0 0;
            background-size: 
                5000px,
                1600px,
                1000px 400px,
                2000px,
                800px 520px;
            animation: 50s para infinite linear;
        }

        @keyframes para {
            100% {
                background-position: 
                    -5000px 20%,
                    -1600px 95%,
                    1000px 50%,
                    2000px 100%,
                    800px 0;
            }
        }
    </style>
</head>
<body>
</body>
</html>
