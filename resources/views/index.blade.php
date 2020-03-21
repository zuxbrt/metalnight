<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:url"                content="http://34.89.230.253/" />
        <meta property="og:type"               content="website" />
        <meta property="og:title"              content="MetalNightRadio" />
        <meta property="og:description"        content="Metal Night je živ, zdrav i brutalniji nego ikad u borbi protiv komšiluka!" />
        <meta property="og:image"              content="{{url('images/poster.png')}}" />

        <title>MetalNightRadio</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300i&display=swap" rel="stylesheet">
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: black;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            audio {
                background-color: black;
            }

            body{
                background-image: url("{{url('images/poster.png')}}");
                height: 100%;
                background-position: center;
                background-repeat: no-repeat;
                background-size: contain;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .background{
                position: absolute;
                width: 100%;
                height: auto;
            }

            #stream-player{
                /* visibility: hidden; */
                margin-left: auto;
                margin-right: auto;
                margin-top: 10px;
            }

            #info{
                position: fixed;
                bottom: 0;
                width: 100%;
                background: black;
                text-align: center;
                justify-content: center;
                height: auto;
                color: white;
                display: flex;
                flex-direction: column;
                flex-wrap: nowrap;
                padding-left: 30px;
                padding-right: 30px;
                padding-bottom: 1%;
                border-radius: 20px;
                /* border: 1px solid red; */
                font-size: 4em;
                font-weight: 600;
                /* opacity: 0.8; */
                -webkit-box-shadow: 2px 2px 15px 3px rgba(255,0,0,1);
                -moz-box-shadow: 2px 2px 15px 3px rgba(255,0,0,1);
                box-shadow: 2px 2px 15px 3px rgba(255,0,0,1);
                padding-top: 15px;
                padding-bottom: 20px;
            }
            #currentsongdiv, #nextsongdiv{
                display: flex;
                flex-direction: row;
                flex-wrap: nowrap;
                justify-content: center;
            }

            .infotext{
                font-size: 14px;
                font-weight: 500;
                margin-top: 5px;
                margin-bottom: 5px;
                font-weight: 600;
            }

            .infotext.next, .infotext.current{
                margin-left: 10px;
            }

            .title-main{
                margin-top: 10px;
                margin-bottom: 15px;
                font-size: 20px;
            }

            #nextsongdiv{
                margin-bottom: 10px;
            }

            .credits{
                width: 200px;
                height: auto;
            }

            #poweredby{
                position: absolute;
                display: flex;
                flex-direction: column;
                right: 100px;
            }

            .by{
                position: absolute;
                right: 10px;
                top: 10px;
                text-decoration: none;
                color: white;
                font-weight: 300;
                font-size: 15px;
                cursor: pointer;
            }
            .listeners{
                color: white;
                position: absolute;
                top: 10px;
                left: 10px;
                font-size: 15px;
            }

        </style>
    </head>
    </script>
    <body>
        <div class="flex-center position-ref full-height">
        <a class="by" href="https://zuxbrt.github.io/">by zux</a>
        <div class='listeners'>
            Listening:&nbsp{{$listeners}}
        </div>
        @if($streamactive)
                <div id="info">
                    <p class='title-main'>Metal Night Radio</p>
                    <div id="currentsongdiv">
                        <p class='infotext'>Now playing:</p>
                        <p id="currentsong" class='infotext current'>{{$currentsong}}</p> 
                    </div>
                    <div id="nextsongdiv">
                    @if(isset($info['NEXTTITLE']))
                        <p class='infotext'>Up next:</p>
                        <p id="nextsong" class='infotext next'>{{$nextsong}}</p> 
                    @endif
                    </div>

                    <audio id="stream-player" src="{{$streamurl}}" autoplay allow="autoplay" controls="true" volume="0.8"></audio>

                </div>
        @endif
        </div>
    </body>
</html>
<script>
    $( document ).ready(function() {
        let active = {!! json_encode($streamactive) !!};
        if(active){
            $("#stream-player").get(0).play();
            console.clear();
            //setInterval(function() {
                $.ajax({
                    url: '{{route('getInfo')}}',
                    type: "GET",
                    success: function(data, textStatus, jqXHR) {
                        document.getElementById('currentsong').innerHTML    = data.currentsong;
                        if(data.nextsong){
                            document.getElementById('nextsong').innerHTML       = data.nextsong;
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        //alert('Error occurred!');
                    }
                });
            //}, 60 * 1000);
        }
        
    });
   
</script>
