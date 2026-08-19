<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Login Admin - Notice Pajak</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {

            min-height: 100vh;

            font-family:
                "Segoe UI",
                Arial,
                Helvetica,
                sans-serif;

            background: #eef4fc;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 20px;

        }


        /* =========================================================
           LOGIN WRAPPER
        ========================================================= */

        .login-wrapper {

            width: 100%;

            max-width: 1280px;

            min-height: 720px;

            background: #ffffff;

            border-radius: 30px;

            overflow: hidden;

            display: grid;

            grid-template-columns: 1fr 1fr;

            box-shadow:
                0 25px 70px
                rgba(15, 23, 42, 0.15);

        }


        /* =========================================================
           LEFT SIDE
        ========================================================= */

        .login-brand {

            position: relative;

            min-height: 720px;

            padding: 55px;

            color: #ffffff;

            display: flex;

            flex-direction: column;

            justify-content: space-between;

            overflow: hidden;


            /*
            =====================================================
            FOTO BACKGROUND
            =====================================================

            File:

            public/images/samsat.jpeg

            */

            background-image:

                linear-gradient(
                    rgba(7, 18, 45, 0.68),
                    rgba(9, 25, 62, 0.82)
                ),

                url("{{ asset('images/samsat.jpeg') }}");

            background-size: cover;

            background-position: center;

            background-repeat: no-repeat;

        }


        /* =========================================================
           OVERLAY
        ========================================================= */

        .login-brand-overlay {

            position: absolute;

            inset: 0;

            background:
                linear-gradient(
                    180deg,
                    rgba(5, 15, 35, 0.10),
                    rgba(5, 15, 35, 0.20)
                );

            pointer-events: none;

        }


        .brand-content {

            position: relative;

            z-index: 2;

        }


        /* =========================================================
           LOGO NTB
        ========================================================= */

        .brand-logo {

            width: 115px;

            height: 115px;

            margin-bottom: 28px;

            display: flex;

            align-items: center;

            justify-content: center;

            position: relative;

            z-index: 3;

        }


        .brand-logo img {

            width: 100%;

            height: 100%;

            object-fit: contain;

            display: block;

            filter:
                drop-shadow(
                    0 8px 15px
                    rgba(0, 0, 0, 0.30)
                );

        }


        /* =========================================================
           BRAND TITLE
        ========================================================= */

        .brand-title {

            font-size: 42px;

            line-height: 1.1;

            font-weight: 800;

            letter-spacing: -1px;

            margin-bottom: 18px;

            text-shadow:
                0 3px 15px
                rgba(0, 0, 0, 0.30);

        }


        .brand-description {

            max-width: 530px;

            font-size: 17px;

            line-height: 1.8;

            color:
                rgba(255, 255, 255, 0.92);

            text-shadow:
                0 2px 10px
                rgba(0, 0, 0, 0.30);

        }


        /* =========================================================
           FEATURES
        ========================================================= */

        .brand-features {

            position: relative;

            z-index: 2;

            display: flex;

            flex-direction: column;

            gap: 16px;

        }


        .brand-feature {

            display: flex;

            align-items: center;

            gap: 15px;

            color: #ffffff;

            font-size: 15px;

            font-weight: 500;

            text-shadow:
                0 2px 8px
                rgba(0, 0, 0, 0.35);

        }


        .feature-icon {

            width: 44px;

            height: 44px;

            flex-shrink: 0;

            border-radius: 12px;

            background:
                rgba(255, 255, 255, 0.13);

            border:
                1px solid
                rgba(255, 255, 255, 0.18);

            display: flex;

            align-items: center;

            justify-content: center;

            backdrop-filter: blur(5px);

        }


        .feature-icon svg {

            width: 21px;

            height: 21px;

            fill: none;

            stroke: #ffffff;

            stroke-width: 1.8;

        }


        /* =========================================================
           RIGHT SIDE
        ========================================================= */

        .login-form-side {

            background: #ffffff;

            padding: 65px;

            display: flex;

            align-items: center;

            justify-content: center;

        }


        .login-form {

            width: 100%;

            max-width: 500px;

        }


        /* =========================================================
           HEADER
        ========================================================= */

        .form-title {

            font-size: 38px;

            line-height: 1.2;

            color: #0f172a;

            font-weight: 800;

            margin-bottom: 10px;

        }


        .form-subtitle {

            color: #64748b;

            font-size: 15px;

            line-height: 1.6;

            margin-bottom: 35px;

        }


        /* =========================================================
           ALERT SUCCESS
        ========================================================= */

        .alert-success {

            display: flex;

            align-items: center;

            gap: 10px;

            padding: 13px 15px;

            margin-bottom: 22px;

            border-radius: 10px;

            background: #f0fdf4;

            border: 1px solid #bbf7d0;

            color: #166534;

            font-size: 13px;

        }


        /* =========================================================
           ALERT ERROR
        ========================================================= */

        .alert-error {

            padding: 13px 15px;

            margin-bottom: 22px;

            border-radius: 10px;

            background: #fef2f2;

            border: 1px solid #fecaca;

            color: #b91c1c;

            font-size: 13px;

        }


        /* =========================================================
           FORM GROUP
        ========================================================= */

        .form-group {

            margin-bottom: 22px;

        }


        .form-label {

            display: block;

            margin-bottom: 9px;

            color: #1e293b;

            font-size: 14px;

            font-weight: 700;

        }


        .input-wrapper {

            position: relative;

        }


        .input-icon {

            position: absolute;

            left: 17px;

            top: 50%;

            transform: translateY(-50%);

            width: 21px;

            height: 21px;

            color: #94a3b8;

            pointer-events: none;

        }


        .input-icon svg {

            width: 100%;

            height: 100%;

            fill: none;

            stroke: currentColor;

            stroke-width: 1.8;

        }


        .form-input {

            width: 100%;

            height: 56px;

            border: 1px solid #dbe3ef;

            background: #f8fafc;

            border-radius: 13px;

            padding: 0 50px;

            color: #0f172a;

            font-size: 14px;

            outline: none;

            transition: 0.2s ease;

        }


        .form-input::placeholder {

            color: #94a3b8;

        }


        .form-input:focus {

            background: #ffffff;

            border-color: #2563eb;

            box-shadow:
                0 0 0 4px
                rgba(37, 99, 235, 0.10);

        }


        /* =========================================================
           PASSWORD TOGGLE
        ========================================================= */

        .password-toggle {

            position: absolute;

            right: 15px;

            top: 50%;

            transform: translateY(-50%);

            width: 32px;

            height: 32px;

            border: none;

            background: transparent;

            color: #94a3b8;

            cursor: pointer;

            display: flex;

            align-items: center;

            justify-content: center;

        }


        .password-toggle:hover {

            color: #2563eb;

        }


        .password-toggle svg {

            width: 20px;

            height: 20px;

            fill: none;

            stroke: currentColor;

            stroke-width: 1.8;

        }


        /* =========================================================
           REMEMBER
        ========================================================= */

        .form-options {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-top: 4px;

            margin-bottom: 27px;

        }


        .remember-label {

            display: flex;

            align-items: center;

            gap: 9px;

            color: #64748b;

            font-size: 13px;

            cursor: pointer;

        }


        .remember-checkbox {

            width: 17px;

            height: 17px;

            accent-color: #2563eb;

            cursor: pointer;

        }


        /* =========================================================
           LOGIN BUTTON
        ========================================================= */

        .login-button {

            width: 100%;

            height: 58px;

            border: none;

            border-radius: 13px;

            background: #2563eb;

            color: #ffffff;

            font-size: 15px;

            font-weight: 700;

            cursor: pointer;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 10px;

            transition:
                background .2s ease,
                transform .2s ease,
                box-shadow .2s ease;

        }


        .login-button:hover {

            background: #1d4ed8;

            transform: translateY(-1px);

            box-shadow:
                0 10px 25px
                rgba(37, 99, 235, 0.22);

        }


        .login-button:active {

            transform: translateY(0);

        }


        .login-button svg {

            width: 19px;

            height: 19px;

            fill: none;

            stroke: currentColor;

            stroke-width: 2;

        }


        /* =========================================================
           FOOTER
        ========================================================= */

        .form-footer {

            margin-top: 30px;

            padding-top: 22px;

            border-top: 1px solid #e2e8f0;

            text-align: center;

            color: #94a3b8;

            font-size: 12px;

        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1000px) {

            .login-wrapper {

                max-width: 900px;

            }


            .login-brand {

                padding: 40px;

            }


            .login-form-side {

                padding: 40px;

            }


            .brand-title {

                font-size: 34px;

            }


            .form-title {

                font-size: 32px;

            }

        }


        @media (max-width: 760px) {

            body {

                padding: 0;

            }


            .login-wrapper {

                min-height: 100vh;

                border-radius: 0;

                grid-template-columns: 1fr;

            }


            .login-brand {

                min-height: 430px;

                padding: 40px 30px;

            }


            .login-form-side {

                padding: 40px 30px;

            }


            .brand-title {

                font-size: 32px;

            }


            .brand-description {

                font-size: 15px;

            }

        }


        @media (max-width: 480px) {

            .login-brand {

                min-height: 390px;

                padding: 30px 22px;

            }


            .login-form-side {

                padding: 35px 22px;

            }


            .brand-logo {

                width: 85px;

                height: 85px;

                margin-bottom: 22px;

            }


            .brand-title {

                font-size: 28px;

            }


            .form-title {

                font-size: 28px;

            }


            .form-input {

                height: 52px;

            }


            .login-button {

                height: 54px;

            }

        }

    </style>

</head>


<body>


<div class="login-wrapper">


    <!-- =========================================================
         BAGIAN KIRI
    ========================================================== -->

    <section class="login-brand">


        <div class="login-brand-overlay"></div>


        <div class="brand-content">


            <!-- =====================================================
                 LOGO NTB
            ====================================================== -->

            <div class="brand-logo">

                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Logo Nusa Tenggara Barat"
                >

            </div>


            <!-- =====================================================
                 TITLE
            ====================================================== -->

            <h1 class="brand-title">

                NOTICE PAJAK

            </h1>


            <!-- =====================================================
                 DESCRIPTION
            ====================================================== -->

            <p class="brand-description">

                Sistem Arsip Digital Notice Pajak
                Samsat Gerung untuk mengelola
                data notice secara cepat, rapi,
                dan terorganisir.

            </p>


        </div>


        <!-- =========================================================
             FEATURES
        ========================================================== -->

        <div class="brand-features">


            <!-- FEATURE 1 -->

            <div class="brand-feature">

                <div class="feature-icon">

                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >

                        <path
                            d="M3 7h18"
                        />

                        <path
                            d="M5 7v13h14V7"
                        />

                        <path
                            d="M8 3h8v4H8z"
                        />

                        <path
                            d="M8 11h8"
                        />

                        <path
                            d="M8 15h5"
                        />

                    </svg>

                </div>


                <span>

                    Arsip notice digital

                </span>

            </div>


            <!-- FEATURE 2 -->

            <div class="brand-feature">

                <div class="feature-icon">

                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >

                        <rect
                            x="3"
                            y="4"
                            width="18"
                            height="17"
                            rx="2"
                        />

                        <path
                            d="M8 2v4"
                        />

                        <path
                            d="M16 2v4"
                        />

                        <path
                            d="M3 10h18"
                        />

                        <path
                            d="M8 14h3"
                        />

                        <path
                            d="M8 17h3"
                        />

                    </svg>

                </div>


                <span>

                    Arsip harian dan bulanan

                </span>

            </div>


            <!-- FEATURE 3 -->

            <div class="brand-feature">

                <div class="feature-icon">

                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >

                        <path
                            d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"
                        />

                        <path
                            d="M9 12l2 2 4-4"
                        />

                    </svg>

                </div>


                <span>

                    Akses administrator

                </span>

            </div>


        </div>


    </section>


    <!-- =========================================================
         BAGIAN KANAN
    ========================================================== -->

    <section class="login-form-side">


        <div class="login-form">


            <!-- =====================================================
                 HEADER
            ====================================================== -->

            <h2 class="form-title">

                Selamat Datang

            </h2>


            <p class="form-subtitle">

                Silakan login untuk masuk ke
                Dashboard Administrator.

            </p>


            <!-- =====================================================
                 SUCCESS MESSAGE
            ====================================================== -->

            @if (session('success'))

                <div class="alert-success">

                    <span>✓</span>

                    <span>

                        {{ session('success') }}

                    </span>

                </div>

            @endif


            <!-- =====================================================
                 ERROR MESSAGE
            ====================================================== -->

            @if ($errors->any())

                <div class="alert-error">

                    {{ $errors->first() }}

                </div>

            @endif


            <!-- =====================================================
                 LOGIN FORM
            ====================================================== -->

            <form
                action="{{ route('login.process') }}"
                method="POST"
            >

                @csrf


                <!-- =================================================
                     EMAIL
                ================================================== -->

                <div class="form-group">


                    <label
                        for="email"
                        class="form-label"
                    >

                        Email Administrator

                    </label>


                    <div class="input-wrapper">


                        <div class="input-icon">

                            <svg
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >

                                <rect
                                    x="3"
                                    y="5"
                                    width="18"
                                    height="14"
                                    rx="2"
                                />

                                <path
                                    d="M3 7l9 6 9-6"
                                />

                            </svg>

                        </div>


                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input"
                            value="{{ old('email') }}"
                            placeholder="admin@noticepajak.com"
                            autocomplete="email"
                            required
                        >


                    </div>


                </div>


                <!-- =================================================
                     PASSWORD
                ================================================== -->

                <div class="form-group">


                    <label
                        for="password"
                        class="form-label"
                    >

                        Password

                    </label>


                    <div class="input-wrapper">


                        <div class="input-icon">

                            <svg
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >

                                <rect
                                    x="5"
                                    y="10"
                                    width="14"
                                    height="11"
                                    rx="2"
                                />

                                <path
                                    d="M8 10V7a4 4 0 018 0v3"
                                />

                            </svg>

                        </div>


                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >


                        <button
                            type="button"
                            class="password-toggle"
                            id="passwordToggle"
                            aria-label="Tampilkan password"
                        >


                            <svg
                                id="eyeIcon"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >

                                <path
                                    d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="2.5"
                                />

                            </svg>


                        </button>


                    </div>


                </div>


                <!-- =================================================
                     REMEMBER ME
                ================================================== -->

                <div class="form-options">


                    <label class="remember-label">


                        <input
                            type="checkbox"
                            name="remember"
                            class="remember-checkbox"
                        >


                        <span>

                            Ingat saya

                        </span>


                    </label>


                </div>


                <!-- =================================================
                     LOGIN BUTTON
                ================================================== -->

                <button
                    type="submit"
                    class="login-button"
                >


                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >

                        <path
                            d="M10 17l5-5-5-5"
                        />

                        <path
                            d="M15 12H3"
                        />

                        <path
                            d="M21 3v18"
                        />

                    </svg>


                    <span>

                        Masuk ke Dashboard

                    </span>


                </button>


            </form>


            <!-- =====================================================
                 FOOTER
            ====================================================== -->

            <div class="form-footer">

                © {{ date('Y') }}
                Notice Pajak — Samsat Gerung

            </div>


        </div>


    </section>


</div>


<script>

    /* =========================================================
       PASSWORD TOGGLE
    ========================================================= */

    const passwordInput =
        document.getElementById('password');


    const passwordToggle =
        document.getElementById('passwordToggle');


    const eyeIcon =
        document.getElementById('eyeIcon');


    if (
        passwordInput &&
        passwordToggle &&
        eyeIcon
    ) {


        passwordToggle.addEventListener(
            'click',
            function () {


                if (
                    passwordInput.type === 'password'
                ) {


                    passwordInput.type = 'text';


                    passwordToggle.setAttribute(
                        'aria-label',
                        'Sembunyikan password'
                    );


                    eyeIcon.innerHTML = `

                        <path
                            d="M3 3l18 18"
                        />

                        <path
                            d="M10.6 10.6a2 2 0 002.8 2.8"
                        />

                        <path
                            d="M9.9 5.1A10.7 10.7 0 0112 5c6.5 0 10 7 10 7a17 17 0 01-3.1 3.9"
                        />

                        <path
                            d="M6.2 6.2C3.5 8.2 2 12 2 12s3.5 7 10 7c1.5 0 2.8-.3 4-.8"
                        />

                    `;


                } else {


                    passwordInput.type = 'password';


                    passwordToggle.setAttribute(
                        'aria-label',
                        'Tampilkan password'
                    );


                    eyeIcon.innerHTML = `

                        <path
                            d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z"
                        />

                        <circle
                            cx="12"
                            cy="12"
                            r="2.5"
                        />

                    `;

                }

            }
        );

    }

</script>


</body>

</html>