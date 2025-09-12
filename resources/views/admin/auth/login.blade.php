{{-- Uses ArchitectUI style assets. Adjust asset paths if your files are in different folders --}}

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- ArchitectUI CSS: adjust path as needed -->
    <link rel="stylesheet" href="{{ asset('admin_assets/css/base.min.css')}}">
    <style>
        /* small centering helpers */
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f4f6f9;
            padding: 2rem;
        }

        .card-auth {
            width: 420px;
            max-width: 95%;
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="card card-auth shadow-sm">
            <div class="card-body p-4">
                <h4 class="text-center mb-4">Admin Sign In</h4>

                {{-- Error messages --}}
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form id="loginForm" method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <div class="form-group mb-3">
                        <label class="form-label">Username</label>
                        <input type="text"
                            name="username"
                            value="{{ old('username') }}"
                            class="form-control"
                            placeholder="Enter username"
                            required autofocus>
                        <div class="invalid-feedback d-none" id="usernameError"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Password</label>
                        <input type="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter password"
                            required>
                        <div class="invalid-feedback d-none" id="passwordError"></div>
                    </div>

                    <div class="alert alert-danger small d-none" id="loginError"></div>

                    <div class="form-check mb-3">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label small" for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/metismenu"></script>
    <script src="{{ asset('admin_assets/js/scripts-init/app.js')}}"></script>
    <script>
        $(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                // reset error messages
                $('#usernameError, #passwordError, #loginError').addClass('d-none').text('');
                $('input').removeClass('is-invalid');

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(res) {
                        if (res.success) {
                            window.location.href = res.redirect; // go to dashboard
                        } else {
                            $('#loginError').removeClass('d-none').text(res.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.username) {
                                $('#usernameError').removeClass('d-none').text(errors.username[0]);
                                $('[name="username"]').addClass('is-invalid');
                            }
                            if (errors.password) {
                                $('#passwordError').removeClass('d-none').text(errors.password[0]);
                                $('[name="password"]').addClass('is-invalid');
                            }
                        } else {
                            $('#loginError').removeClass('d-none').text('Something went wrong. Please try again.');
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>