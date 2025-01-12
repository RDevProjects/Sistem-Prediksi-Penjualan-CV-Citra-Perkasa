@php
    $targetDate = env('TARGET');
    $currentDate = now()->format('Y-m-d');
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page - {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://unpkg.com/bs-brain@2.0.4/components/registrations/registration-3/assets/css/registration-3.css">
    <style>
        body {
            background: rgb(238, 174, 202);
            background: radial-gradient(circle, rgba(238, 174, 202, 1) 0%, rgba(148, 187, 233, 1) 100%);
        }
    </style>
</head>

<body>
    @if ($currentDate < $targetDate)
        <section class="p-3 p-md-4 p-xl-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="rounded col-12 col-md-8 bsb-tpl-bg-lotion d-flex justify-content-center">
                        <div class="p-3 p-md-4 p-xl-5 w-100" style="max-width: 500px;">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-5">
                                        <h2 class="h3">Masuk</h2>
                                        <h3 class="m-0 fs-6 fw-normal text-secondary">Masukkan kredensial Anda untuk
                                            masuk
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form action="{{ route('login.store') }}" method="POST">
                                @csrf
                                <div class="overflow-hidden row gy-3 gy-md-4">
                                    <div class="col-12">
                                        <label for="email" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="nama@contoh.com" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="password" class="form-label">Kata Sandi <span
                                                class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="password" id="password"
                                            value="" required>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="iAgree" id="iAgree" required>
                                            <label class="form-check-label text-secondary" for="iAgree">
                                                Saya setuju dengan <a href="#!"
                                                    class="link-primary text-decoration-none">syarat dan ketentuan</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button class="btn bsb-btn-xl btn-primary" type="submit">Masuk</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="p-3 p-md-4 p-xl-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="rounded col-12 col-md-8 bsb-tpl-bg-lotion d-flex justify-content-center">
                        <div class="p-3 p-md-4 p-xl-5 w-100" style="max-width: 500px;">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-5">
                                        <h2 class="h3">Masuk</h2>
                                        <h3 class="m-0 fs-6 fw-normal text-secondary">Maaf, masa trial telah berakhir.
                                            Silakan
                                            hubungi admin untuk informasi lebih lanjut.</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
</body>

</html>
