@extends('layouts.base')

@section('content')
    <style>
        .container {
            max-width: 450px;
        }
        .push-top {
            margin-top: 50px;
        }
    </style>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Редактировать пользователя') }}</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Метод PUT для обновления -->

                    <!-- Поле для имени -->
                    <div class="form-group">
                        <label for="name">{{ __('Имя') }}</label>
                        <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <!-- Поле для email -->
                    <div class="form-group mt-2">
                        <label for="email">{{ __('Email') }}</label>
                        <input type="email" id="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <!-- Поле для аватара -->
                    <div class="form-group mt-2">
                        <label for="avatar">{{ __('Аватар') }}</label>
                        <input type="file" name="avatar" class="form-control" placeholder="Avatar">
                        @if ($user->avatar)
                            <img src="{{ asset('avatars/' . $user->avatar) }}" style="height: 50px;" alt="Текущий аватар">
                        @endif
                    </div>

                    <!-- Поле для роли -->
                    <div class="form-group mt-2">
                        <label for="roles_id">{{ __('Роль') }}</label>
                        <select id="roles_id" name="roles_id" class="form-control" required>
                            <option value="">{{ __('Выберите роль') }}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->roles_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                            {{ __('Добавить роль') }}
                        </button>
                    </div>

                    <!-- Поле для команды -->
                    <div class="form-group mt-2">
                        <label for="teams_id">{{ __('Команда') }}</label>
                        <select id="teams_id" name="teams_id" class="form-control" required>
                            <option value="">{{ __('Выберите команду') }}</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}" {{ $user->teams_id == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addTeamModal">
                            {{ __('Добавить команду') }}
                        </button>
                    </div>

                    <!-- Остальные поля -->
                    <div class="mt-2">
                        <label for="phone">{{ __('Телефон') }}</label>
                        <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}">
                    </div>

                    <div class="mt-2">
                        <label for="stamp">{{ __('Штамп') }}</label>
                        <input id="stamp" type="text" class="form-control" name="stamp" value="{{ old('stamp', $user->stamp) }}">
                    </div>

                    <!-- Кнопка для сохранения изменений -->
                    <button type="submit" class="btn btn-primary mt-3">{{ __('Обновить') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
