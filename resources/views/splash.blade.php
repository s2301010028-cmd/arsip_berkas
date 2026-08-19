<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Notice Pajak - Samsat Gerung</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        /* =====================================================
           RESET
        ====================================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        html,
        body {
            width: 100%;
            height: 100%;
        }


        body {
            font-family:
                Inter,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            overflow: hidden;

            background: #f8fafc;
        }


        /* =====================================================
           SPLASH SCREEN
        ====================================================== */

        .splash-screen {

            position: fixed;
            inset: 0;

            width: 100%;
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            overflow: hidden;

            background:
                radial-gradient(
                    circle at 50% 42%,
                    rgba(37, 99, 235, .08),
                    transparent 34%
                ),
                linear-gradient(
                    135deg,
                    #f8fafc 0%,
                    #ffffff 45%,
                    #eff6ff 100%
                );

        }


        /* =====================================================
           DEKORASI BACKGROUND
        ====================================================== */

        .background-circle {

            position: absolute;

            border-radius: 50%;

            filter: blur(1px);

            pointer-events: none;

        }


        .circle-one {

            width: 430px;
            height: 430px;

            top: -230px;
            right: -150px;

            background:
                rgba(37, 99, 235, .07);

        }


        .circle-two {

            width: 350px;
            height: 350px;

            bottom: -200px;
            left: -120px;

            background:
                rgba(14, 165, 233, .06);

        }


        /* =====================================================
           CONTENT
        ====================================================== */

        .splash-content {

            position: relative;

            z-index: 5;

            width: min(460px, 90%);

            text-align: center;

            animation:
                splashContentIn
                .7s
                cubic-bezier(.22, 1, .36, 1)
                both;

        }


        /* =====================================================
           LOGO WRAPPER
        ====================================================== */

        .logo-wrapper {

            position: relative;

            width: 130px;
            height: 130px;

            margin:
                0 auto
                25px;

            display: flex;
            align-items: center;
            justify-content: center;

        }


        /* RING LUAR */

        .logo-ring {

            position: absolute;

            inset: 0;

            border-radius: 50%;

            border:
                2px solid
                rgba(37, 99, 235, .12);

            animation:
                ringPulse
                1.8s
                ease-in-out
                infinite;

        }


        .logo-ring::before {

            content: "";

            position: absolute;

            inset: 8px;

            border-radius: 50%;

            border:
                1px solid
                rgba(37, 99, 235, .12);

        }


        /* LOGO BOX */

        .logo-box {

            position: relative;

            z-index: 2;

            width: 96px;
            height: 96px;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 12px;

            border:
                1px solid
                #e2e8f0;

            border-radius: 24px;

            background: #ffffff;

            box-shadow:
                0 15px 40px
                rgba(15, 23, 42, .10);

            animation:
                logoFloat
                2s
                ease-in-out
                infinite;

        }


        .logo-box img {

            width: 100%;
            height: 100%;

            display: block;

            object-fit: contain;

        }


        /* =====================================================
           TEXT
        ====================================================== */

        .splash-label {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            margin-bottom: 12px;

            padding:
                6px
                11px;

            border:
                1px solid
                #dbeafe;

            border-radius: 100px;

            background: #eff6ff;

            color: #2563eb;

            font-size: 10px;

            font-weight: 700;

            letter-spacing: .8px;

            text-transform: uppercase;

        }


        .splash-label span {

            width: 6px;
            height: 6px;

            border-radius: 50%;

            background: #2563eb;

            animation:
                dotPulse
                1.2s
                infinite;

        }


        .splash-title {

            margin: 0;

            color: #0f172a;

            font-size: 30px;

            font-weight: 800;

            line-height: 1.2;

            letter-spacing: -.6px;

        }


        .splash-subtitle {

            margin-top: 7px;

            color: #64748b;

            font-size: 14px;

            font-weight: 500;

        }


        /* =====================================================
           DIVIDER
        ====================================================== */

        .splash-divider {

            width: 45px;
            height: 3px;

            margin:
                18px auto;

            border-radius: 10px;

            background: #2563eb;

        }


        /* =====================================================
           SYSTEM TEXT
        ====================================================== */

        .system-text {

            color: #94a3b8;

            font-size: 11px;

            letter-spacing: .2px;

        }


        /* =====================================================
           LOADING
        ====================================================== */

        .loading-area {

            width: 230px;

            margin:
                26px auto
                0;

        }


        .loading-bar {

            position: relative;

            width: 100%;
            height: 5px;

            overflow: hidden;

            border-radius: 50px;

            background: #e2e8f0;

        }


        .loading-progress {

            width: 0%;
            height: 100%;

            border-radius: inherit;

            background:
                linear-gradient(
                    90deg,
                    #1d4ed8,
                    #2563eb,
                    #38bdf8
                );

            animation:
                loadingProgress
                2.7s
                cubic-bezier(.25, .1, .25, 1)
                forwards;

        }


        .loading-info {

            margin-top: 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            color: #94a3b8;

            font-size: 10px;

        }


        /* =====================================================
           LOADING DOT
        ====================================================== */

        .loading-dots {

            display: inline-flex;

            gap: 3px;

        }


        .loading-dots span {

            width: 4px;
            height: 4px;

            border-radius: 50%;

            background: #2563eb;

            animation:
                loadingDot
                1s
                infinite;

        }


        .loading-dots span:nth-child(2) {

            animation-delay: .15s;

        }


        .loading-dots span:nth-child(3) {

            animation-delay: .3s;

        }


        /* =====================================================
           FOOTER
        ====================================================== */

        .splash-footer {

            position: absolute;

            left: 0;
            right: 0;
            bottom: 28px;

            z-index: 5;

            text-align: center;

            color: #94a3b8;

            font-size: 9px;

            letter-spacing: .3px;

        }


        /* =====================================================
           EXIT ANIMATION
        ====================================================== */

        .splash-screen.hide {

            animation:
                splashOut
                .35s
                ease
                forwards;

        }


        .splash-screen.hide
        .splash-content {

            animation:
                contentOut
                .35s
                ease
                forwards;

        }


        /* =====================================================
           ANIMATIONS
        ====================================================== */

        @keyframes splashContentIn {

            from {

                opacity: 0;

                transform:
                    translateY(18px)
                    scale(.98);

            }

            to {

                opacity: 1;

                transform:
                    translateY(0)
                    scale(1);

            }

        }


        @keyframes logoFloat {

            0%,
            100% {

                transform:
                    translateY(0);

            }

            50% {

                transform:
                    translateY(-5px);

            }

        }


        @keyframes ringPulse {

            0%,
            100% {

                transform:
                    scale(.92);

                opacity: .45;

            }

            50% {

                transform:
                    scale(1.06);

                opacity: 1;

            }

        }


        @keyframes dotPulse {

            0%,
            100% {

                opacity: .35;

                transform:
                    scale(.8);

            }

            50% {

                opacity: 1;

                transform:
                    scale(1.2);

            }

        }


        @keyframes loadingProgress {

            0% {

                width: 0%;

            }

            25% {

                width: 22%;

            }

            55% {

                width: 58%;

            }

            80% {

                width: 83%;

            }

            100% {

                width: 100%;

            }

        }


        @keyframes loadingDot {

            0%,
            100% {

                opacity: .25;

                transform:
                    translateY(0);

            }

            50% {

                opacity: 1;

                transform:
                    translateY(-2px);

            }

        }


        @keyframes splashOut {

            from {

                opacity: 1;

            }

            to {

                opacity: 0;

                visibility: hidden;

            }

        }


        @keyframes contentOut {

            from {

                opacity: 1;

                transform:
                    translateY(0)
                    scale(1);

            }

            to {

                opacity: 0;

                transform:
                    translateY(-8px)
                    scale(.98);

            }

        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 576px) {

            .logo-wrapper {

                width: 115px;
                height: 115px;

            }


            .logo-box {

                width: 85px;
                height: 85px;

                border-radius: 21px;

            }


            .splash-title {

                font-size: 25px;

            }


            .splash-subtitle {

                font-size: 13px;

            }


            .loading-area {

                width: 210px;

            }

        }


        /* =====================================================
           REDUCE MOTION
        ====================================================== */

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {

                animation-duration:
                    .01ms !important;

                animation-iteration-count:
                    1 !important;

            }

        }

    </style>

</head>


<body>


    <!-- =====================================================
         SPLASH SCREEN
    ====================================================== -->

    <div
        class="splash-screen"
        id="splashScreen"
    >


        <!-- BACKGROUND DECORATION -->

        <div class="background-circle circle-one"></div>

        <div class="background-circle circle-two"></div>



        <!-- =================================================
             CONTENT
        ================================================== -->

        <div class="splash-content">


            <!-- LOGO -->

            <div class="logo-wrapper">

                <div class="logo-ring"></div>


                <div class="logo-box">

                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="Logo Samsat Gerung"
                    >

                </div>

            </div>



            <!-- LABEL -->

            <div class="splash-label">

                <span></span>

                Sistem Arsip Digital

            </div>



            <!-- TITLE -->

            <h1 class="splash-title">

                NOTICE PAJAK

            </h1>


            <p class="splash-subtitle">

                Samsat Gerung

            </p>



            <div class="splash-divider"></div>



            <p class="system-text">

                Sistem Pengarsipan Notice Pajak Digital

            </p>



            <!-- =================================================
                 LOADING
            ================================================== -->

            <div class="loading-area">

                <div class="loading-bar">

                    <div
                        class="loading-progress"
                        id="loadingProgress"
                    ></div>

                </div>


                <div class="loading-info">

                    <span id="loadingText">

                        Memuat sistem

                    </span>


                    <div class="loading-dots">

                        <span></span>
                        <span></span>
                        <span></span>

                    </div>

                </div>

            </div>


        </div>



        <!-- =================================================
             FOOTER
        ================================================== -->

        <div class="splash-footer">

            © {{ date('Y') }} Samsat Gerung

        </div>


    </div>



    <!-- =====================================================
         JAVASCRIPT
    ====================================================== -->

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const splash =
                    document.getElementById(
                        'splashScreen'
                    );

                const loadingText =
                    document.getElementById(
                        'loadingText'
                    );


                /*
                |--------------------------------------------------------------------------
                | PERUBAHAN TEXT LOADING
                |--------------------------------------------------------------------------
                */

                setTimeout(
                    function () {

                        loadingText.textContent =
                            'Menyiapkan aplikasi';

                    },
                    900
                );


                setTimeout(
                    function () {

                        loadingText.textContent =
                            'Memuat halaman login';

                    },
                    1900
                );


                /*
                |--------------------------------------------------------------------------
                | SETELAH 3 DETIK
                |--------------------------------------------------------------------------
                */

                setTimeout(
                    function () {

                        loadingText.textContent =
                            'Selesai';


                        splash.classList.add(
                            'hide'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | REDIRECT SETELAH ANIMASI KELUAR
                        |--------------------------------------------------------------------------
                        */

                        setTimeout(
                            function () {

                                window.location.href =
                                    "{{ route('login') }}";

                            },
                            350
                        );

                    },
                    3000
                );

            }
        );

    </script>


</body>

</html>