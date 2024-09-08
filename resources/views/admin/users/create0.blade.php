@extends('layouts.base')

@section('content')

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Create User') }}</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data" id="createUsersForm">
                    @csrf

                    <div class="form-group">
                        <div>
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" id="name" class="form-control" name="name" required>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <div class="form-group">
                                <strong>Avatar:</strong>
                                <input type="file" name="avatar" class="form-control" placeholder="Avatar">
                            </div>
                        </div>

                        <div>
                            <label for="is_admin">{{ __('Admin') }}</label>
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="is_admin">
                        </div>

                        <div class="form-group mt-2">
                            <label for="roles_id">{{ __('Role') }}</label>
                            <select id="roles_id" name="roles_id" class="form-control" required>
                                <option value="">{{ __('Roles') }}</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addRoleModal">{{ __('Add Role') }}</button>
                        </div>

                        <div class="form-group mt-2">
                            <label for="teams_id">{{ __('Team') }}</label>
                            <select id="teams_id" name="teams_id" class="form-control" required>
                                <option value="">{{ __('Teams') }}</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addTeamModal">{{ __('Add Team') }}</button>
                        </div>

                        <div class="mt-2">
                            <label for="phone">{{ __('Phone') }}</label>
                            <input id="phone" type="text" class="form-control" name="phone" required>
                        </div>

                        <div class="mt-2">
                            <label for="stamp">{{ __('Stamp') }}</label>
                            <input id="stamp" type="text" class="form-control" name="stamp" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">{{ __('Create') }}</button>

                </form>
            </div>
        </div>
    </div>

@endsection
