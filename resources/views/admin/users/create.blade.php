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
                <h4>{{ __('Create User') }}</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.store') }}"
                      enctype="multipart/form-data" id="createUsersForm">
                    @csrf

                    <!-- Поле для имени -->
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" id="name" class="form-control" name="name" required>
                    </div>

                    <!-- Поле для email -->
                    <div class="form-group mt-2">
                        <label for="email">{{ __('Email') }}</label>
                        <input type="email" id="email" class="form-control" name="email" required>
                    </div>

                    <!-- Поле для временного пароля -->
                    <div class="form-group mt-2">
                        <label for="password">{{ __('Temporary Password') }}</label>
                        <input type="password" id="password" class="form-control" name="password" required>
                    </div>

                    <!-- Поле для аватара -->
                    <div class="form-group mt-2">
                        <label for="avatar">{{ __('Avatar') }}</label>
                        <input type="file" name="avatar" class="form-control" placeholder="Avatar">
                    </div>

                    <!-- Поле для роли -->
                    <div class="form-group mt-2">
                        <label for="roles_id">{{ __('Role') }}</label>
                        <select id="roles_id" name="roles_id" class="form-control" required>
                            <option value="">{{ __('Select Role') }}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                            {{ __('Add Role') }}
                        </button>
                    </div>

                    <!-- Поле для команды -->
                    <div class="form-group mt-2">
                        <label for="teams_id">{{ __('Team') }}</label>
                        <select id="teams_id" name="teams_id" class="form-control" required>
                            <option value="">{{ __('Select Team') }}</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addTeamModal">
                            {{ __('Add Team') }}
                        </button>
                    </div>

                    <!-- Остальные поля -->
                    <div class="mt-2">
                        <label for="phone">{{ __('Phone') }}</label>
                        <input id="phone" type="text" class="form-control" name="phone" >
                    </div>

                    <div class="mt-2">
                        <label for="stamp">{{ __('Stamp') }}</label>
                        <input id="stamp" type="text" class="form-control" name="stamp" >
                    </div>

                    <!-- Кнопка для создания пользователя -->
                    <button type="submit" class="btn btn-primary mt-3">{{ __('Create') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
