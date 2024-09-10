@extends('layouts.base')

@section('content')
    <style>
        .container {
            max-width: 600px;
        }
        .push-top {
            margin-top: 50px;
        }
    </style>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Создать новый CMM
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.cmms.store') }}" enctype="multipart/form-data" id="createCMMForm">
                    @csrf

                    <div class="form-group d-flex">
                        <div class="mt-2 m-3 border p-2">
                            <div >
                                <label for="wo">{{ __('Номер CMM') }}</label>
                                <input id='wo' type="text" class="form-control" name="number" required>
                                @error('number')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-4">
                                <label for="title">{{ __('Description') }}</label>
                                <input id='title' type="text" class="form-control" name="title" required>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
                                <div class="form-group">
                                    <strong>{{__('Image:')}}</strong>
                                    <input type="file" name="img" class="form-control" placeholder="изображение">
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="revision_date">{{ __('Revision Date') }}</label>
                                <input id='revision_date' type="date" class="form-control" name="revision_date" required>
                            </div>
                            <div class="mt-4">
                                <label for="units_pn">{{ __('Units PN') }}</label>
                                <input id='units_pn' type="text" class="form-control" name="units_pn" required>
                            </div>
                        </div>
                       <div style="width: 320px" class="m-3 p-2 border">
                           <div class="form-group ">
                               <label for="air_crafts_id">{{ __('AirCraft Type')
                            }}</label>
                               <select id="air_crafts_id" name="air_crafts_id" class="form-control" required>
                                   <option value="">{{ __('Select AirCraft')
                                }}</option>
                                   @foreach ($airCrafts as $airCraft)
                                       <option value="{{ $airCraft->id }}">{{ $airCraft->type }}</option>
                                   @endforeach
                               </select>
                               <button type="button" class="btn btn-link" data-bs-toggle="modal"
                                       data-bs-target="#addAirCraftModal">{{ __('Add AirCraft') }}</button>
                           </div>

                           <div class="form-group ">
                               <label for="m_f_r_s_id">{{ __('MFR') }}</label>
                               <select id="m_f_r_s_id" name="m_f_r_s_id" class="form-control" required>
                                   <option value="">{{ __('Select MFR') }}</option>
                                   @foreach ($mfrs as $mfr)
                                       <option value="{{ $mfr->id }}">{{ $mfr->name }}</option>
                                   @endforeach
                               </select>
                               <button type="button" class="btn btn-link" data-bs-toggle="modal"
                                       data-bs-target="#addMFRModal">{{ __('Add MFR') }}</button>
                           </div>

                           <div class="form-group ">
                               <label for="scopes_id">{{ __('Scope') }}</label>
                               <select id="scopes_id" name="scopes_id" class="form-control" required>
                                   <option value="">{{ __('Select Scope') }}</option>
                                   @foreach ($scopes as $scope)
                                       <option value="{{ $scope->id }}">{{ $scope->scope }}</option>
                                   @endforeach
                               </select>
                               <button type="button" class="btn btn-link" data-bs-toggle="modal"
                                       data-bs-target="#addScopeModal">{{ __('Add Scope') }}</button>
                           </div>
                           <div >
                               <label for="lib">{{ __('Library Number') }}</label>
                               <input id='lib' type="text" class="form-control" name="lib" required>
                           </div>

                       </div>

                    </div>

                    <button type="submit" class="btn btn-primary mt-3">
                        {{ __('Create') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Модальное окно для добавления самолета -->
    <div class="modal fade" id="addAirCraftModal" tabindex="-1" aria-labelledby="addAirCraftModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAirCraftModalLabel">{{ __('Add AirCraft') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <form method="POST" id="addAirCraftForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="airCraftName">{{ __('AirCraft Type') }}</label>
                            <input type="text" class="form-control" id="airCraftName" name="type" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Модальное окно для добавления MFR -->
    <div class="modal fade" id="addMFRModal" tabindex="-1" aria-labelledby="addMFRModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMFRModalLabel">{{ __('Add MFR') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" id="addMFRForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="mfrName">{{ __('Название MFR') }}</label>
                            <input type="text" class="form-control" id="mfrName" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Модальное окно для добавления Scope -->
    <div class="modal fade" id="addScopeModal" tabindex="-1" aria-labelledby="addScopeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addScopeModalLabel">{{ __('Add Scope') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" id="addScopeForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="scopeName">{{ __('Scope') }}</label>
                            <input type="text" class="form-control" id="scopeName" name="scope" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Функция для обработки отправки форм для самолетов, MFR и Scope
        function handleFormSubmission(formId, route, selectId, dataKey, dataValue) {
            document.getElementById(formId).addEventListener('submit', function(event) {
                event.preventDefault();
                if (this.submitted) {
                    return;
                }
                this.submitted = true;

                let formData = new FormData(this);
                fetch(route, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        // Добавить новый вариант в селект
                        let select = document.getElementById(selectId);
                        let option = document.createElement('option');
                        option.value = data[dataKey];
                        option.text = data[dataValue];
                        select.add(option);
                        // Закрыть модальное окно
                        let modal = bootstrap.Modal.getInstance(document.getElementById(formId));
                        modal.hide();
                    })
                    .catch(error => console.error('Ошибка:', error));
            });
        }

        // Вызов функции для каждой модальной формы
        handleFormSubmission('addAirCraftForm', '{{ route('admin.aircrafts.store') }}', 'air_crafts_id', 'id', 'type');
        handleFormSubmission('addMFRForm', '{{ route('admin.mfrs.store') }}', 'm_f_r_s_id', 'id', 'name');
        handleFormSubmission('addScopeForm', '{{ route('admin.scopes.store') }}', 'scopes_id', 'id', 'scope');
    </script>
@endsection
