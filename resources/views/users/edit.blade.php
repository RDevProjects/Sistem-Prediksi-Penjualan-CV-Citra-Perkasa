@extends('include.layout')
@section('content')
    <div class="page-header">
        <h3 class="mb-3 fw-bold">Data Admin</h3>
        <ul class="mb-3 breadcrumbs">
            <li class="nav-home">
                <a href="#">
                    <i class="icon-home"></i>
                </a>
            </li>

            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin') }}">Data Admin</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="">Edit Data Admin</a>
            </li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Tambah Admin</div>
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
                <div class="card-body">
                    <form action="{{ route('update.admin', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Name" value="{{ old('name', $user->name) }}" required />
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="Enter Username" value="{{ old('name', $user->username) }}" required />
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter Email" value="{{ old('name', $user->email) }}" required />
                            <small id="emailHelp" class="form-text text-muted">Kami tidak akan pernah membagikan email Anda
                                dengan orang lain.</small>
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="password">Password</label>
                                <div class="d-flex align-items-center">
                                    <input type="checkbox" id="enablePassword" onclick="togglePassword()">
                                    <p class="mb-0 ms-2">Edit Password</p>
                                </div>
                            </div>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter Password" value="{{ old('password') }}" disabled />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById('password');
            passwordInput.disabled = !passwordInput.disabled;
        }
    </script>
@endpush
