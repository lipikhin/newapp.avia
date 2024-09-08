@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Profile') }}</div>

                    <div class="card-body">
                        <form id="profile-form" method="POST" action="{{ route('user.profile.store') }}" enctype="multipart/form-data">
                            @csrf

                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="row">
                                <div class="d-flex justify-content-center">
                                    <img id="avatar-preview"
                                         src="{{ asset('storage/avatars/' . auth()->user()->avatar) }}"
                                         style="width:120px; margin-top: 10px; cursor: pointer;">
                                    <input id="avatar" type="file" class="d-none @error('avatar') is-invalid @enderror" name="avatar" accept="image/*">
                                    @error('avatar')
                                    <span role="alert" class="text-danger">
            <strong>{{ $message }}</strong>
        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Name: </label>
                                    <input class="form-control" type="text" id="name" name="name" value="{{ auth()->user()->name }}" autofocus="">
                                    @error('name')
                                    <span role="alert" class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Email: </label>
                                    <input class="form-control" type="text" id="email" name="email" value="{{ auth()->user()->email }}" autofocus="">
                                    @error('email')
                                    <span role="alert" class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="phone" class="form-label">Phone: </label>
                                    <input class="form-control" type="text" id="phone" name="phone" value="{{ auth()->user()->phone }}" autofocus="">
                                    @error('phone')
                                    <span role="alert" class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="stamp" class="form-label">Stamp: </label>
                                    <input class="form-control" type="text" id="stamp" name="stamp" value="{{ auth()->user()->stamp }}" autofocus="">
                                    @error('stamp')
                                    <span role="alert" class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Новые поля для изменения пароля -->
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="password" class="form-label">New Password: </label>
                                    <input class="form-control" type="password" id="password" name="password">
                                    @error('password')
                                    <span role="alert" class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="password_confirmation" class="form-label">Confirm Password: </label>
                                    <input class="form-control" type="password" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">{{ __('Update Profile') }}</button>
                                    <button type="button" id="cancel-button" class="btn btn-secondary ms-2">
                                        <a href="/home" style="color: white">{{ __('Cancel') }}</a>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Сохранить начальное состояние формы
        const initialAvatarSrc = document.getElementById('avatar-preview').src; // Исправлено здесь
        const initialFormState = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            stamp: document.getElementById('stamp').value,
        };

        // Нажатие на аватар для выбора файла
        document.getElementById('avatar-preview').addEventListener('click', function() {
            document.getElementById('avatar').click(); // Открытие диалогового окна для выбора файла
        });

        // Предпросмотр нового аватара после выбора файла
        document.getElementById('avatar').addEventListener('change', function() {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result; // Обновление изображения
            };
            if (this.files && this.files[0]) {
                reader.readAsDataURL(this.files[0]); // Чтение выбранного файла
            }
        });

        // Сброс полей формы в начальное состояние
        document.getElementById('cancel-button').addEventListener('click', function() {
            document.getElementById('avatar-preview').src = initialAvatarSrc; // Исправлено здесь
            document.getElementById('avatar').value = ''; // Очистка значения ввода
            document.getElementById('name').value = initialFormState.name;
            document.getElementById('email').value = initialFormState.email;
            document.getElementById('phone').value = initialFormState.phone;
            document.getElementById('stamp').value = initialFormState.stamp;
        });
    </script>
@endsection
