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
            <div class="card_heater">
                Create New CMM
            </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.cmms.store') }}" enctype="multipart/form-data" id="createCMMForm">
                @csrf


                <div class="form-group">
                    <div>
                        <label id="wo">{{ __('CMM Number') }}</label>
                        <input id='wo' type="text" class="form-control" name="number" required>
                    </div>
                    <div class="mt-2">
                        <label id="title">{{ __('Title') }}</label>
                        <input id='title' type="text" class="form-control" name="title" required>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                        <div class="form-group">
                            <strong>Image:</strong>
                            <input type="file" name="img" class="form-control" placeholder="image">
                        </div>
                    </div>

                    <div class="mt-2">
                        <label id="revision_date">{{ __('Revision Date') }}</label>
                        <input id='revision_date' type="date" class="form-control" name="revision_date" required>
                    </div>

                    <div class="form-group mt-2">
                        <label for="air_crafts_id">{{ __('Air Craft') }}</label>
                        <select id="air_crafts_id" name="air_crafts_id" class="form-control" required>
                            <option value="">{{ __('Select Air Craft') }}</option>
                            @foreach ($airCrafts as $airCraft)
                                <option value="{{ $airCraft->id }}">{{ $airCraft->type }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#addAirCraftModal">{{ __('Add Air Craft') }}</button>
                    </div>

                    <div class="form-group mt-2">
                        <label for="m_f_r_s_id">{{ __('MFR') }}</label>
                        <select id="m_f_r_s_id" name="m_f_r_s_id" class="form-control" required>
                            <option value="">{{ __('Select MFR') }}</option>
                            @foreach ($mfrs as $mfr)
                                <option value="{{ $mfr->id }}">{{ $mfr->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#addMFRModal">{{ __('Add MFR') }}</button>
                    </div>

                    <div class="form-group mt-2">
                        <label for="scopes_id">{{ __('Scope') }}</label>
                        <select id="scopes_id" name="scopes_id" class="form-control" required>
                            <option value="">{{ __('Select Scope') }}</option>
                            @foreach ($scopes as $scope)
                                <option value="{{ $scope->id }}">{{ $scope->scope }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#addScopeModal">{{ __('Add Scope') }}</button>
                    </div>

                    <div class="mt-2">
                        <label id="lib">{{ __('Library No') }}</label>
                        <input id='lib' type="text" class="form-control" name="lib" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">
                    {{ __('Create') }}
                </button>
            </form>

        </div>

        </div>
    </div>

    <!-- Add Air Craft Modal -->
    <div class="modal fade" id="addAirCraftModal" tabindex="-1" role="dialog" aria-labelledby="addAirCraftModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAirCraftModalLabel">{{ __('Add Air Craft') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="addAirCraftForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="airCraftName">{{ __('Air Craft Name') }}</label>
                            <input type="text" class="form-control" id="airCraftName" name="type" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add MFR Modal -->
    <div class="modal fade" id="addMFRModal" tabindex="-1" role="dialog" aria-labelledby="addMFRModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMFRModalLabel">{{ __('Add MFR') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="addMFRForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="mfrName">{{ __('MFR Name') }}</label>
                            <input type="text" class="form-control" id="mfrName" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Scope Modal -->
    <div class="modal fade" id="addScopeModal" tabindex="-1" role="dialog" aria-labelledby="addScopeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addScopeModalLabel">{{ __('Add Scope') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="addScopeForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="scopeName">{{ __('Scope Name') }}</label>
                            <input type="text" class="form-control" id="scopeName" name="scope" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // AirCraft
        document.getElementById('addAirCraftForm').addEventListener('submit', function(event) {
            event.preventDefault();
            if (this.submitted) {
                return; // Если форма уже была отправлена, выходим
            }
            this.submitted = true; // Устанавливаем флаг отправки формы

            let formData = new FormData(this);
            fetch("{{ route('admin.aircrafts.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    let airCraftSelect = document.getElementById('air_crafts_id');
                    airCraftSelect.innerHTML += `<option value="${data.id}">${data.type}</option>`;
                    airCraftSelect.value = data.id;
                    $('#addAirCraftModal').modal('hide'); // Закрытие модального окна
                    this.submitted = false; // Сбрасываем флаг отправки формы
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.submitted = false; // Сбрасываем флаг отправки формы в случае ошибки
                });
        });

        // MFR
        document.getElementById('addMFRForm').addEventListener('submit', function(event) {
            event.preventDefault();
            if (this.submitted) {
                return; // Если форма уже была отправлена, выходим
            }
            this.submitted = true; // Устанавливаем флаг отправки формы

            let formData = new FormData(this);
            fetch("{{ route('admin.mfrs.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    let mfrSelect = document.getElementById('m_f_r_s_id');
                    mfrSelect.innerHTML += `<option value="${data.id}">${data.name}</option>`;
                    mfrSelect.value = data.id;
                    $('#addMFRModal').modal('hide'); // Закрытие модального окна
                    this.submitted = false; // Сбрасываем флаг отправки формы
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.submitted = false; // Сбрасываем флаг отправки формы в случае ошибки
                });
        });

        // Scope
        document.getElementById('addScopeForm').addEventListener('submit', function(event) {
            event.preventDefault();
            if (this.submitted) {
                return; // Если форма уже была отправлена, выходим
            }
            this.submitted = true; // Устанавливаем флаг отправки формы

            let formData = new FormData(this);
            fetch("{{ route('admin.scopes.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    let scopeSelect = document.getElementById('scopes_id');
                    scopeSelect.innerHTML += `<option value="${data.id}">${data.scope}</option>`;
                    scopeSelect.value = data.id;
                    $('#addScopeModal').modal('hide'); // Закрытие модального окна
                    this.submitted = false; // Сбрасываем флаг отправки формы
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.submitted = false; // Сбрасываем флаг отправки формы в случае ошибки
                });
        });


    </script>
@endsection

