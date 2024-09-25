@extends('layouts.base')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <div class="container">
        <div class="card shadow">

            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div style="width: 450px">
                        <h3>{{__('Manage Units')}}</h3>
                    </div>
                    <!-- Кнопка Добавить юнит -->
                    <button class="btn btn-primary mb-1"
                            data-bs-toggle="modal"
                            data-bs-target="#addUnitModal">{{__('Add Unit')
                            }}</button>
                </div>
            </div>

            <div class="card-body">
                <table id="cmmTable" data-toggle="table"
                       data-search="true"
                       data-pagination="false"
                       data-page-size="5"
                       class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th data-field="number" data-visible="true" data-priority="1" class="text-center">{{__('#')}}</th>
                        <th data-field="part_title" data-visible="true"
                            data-priority="2" class="text-center">{{__('Unit
                            Description')
                            }}</th>
                        <th data-field="part_number" data-visible="true"
                            data-priority="2" class="text-center">{{__('Unit
                            PN')
                            }}</th>
                        <th data-field="number" data-visible="true"
                            data-priority="3" class="text-center">{{__('CMM
                            Unit')}}</th>
                        <th data-field="img" data-visible="true"
                            data-priority="4" class="text-center">{{__('Image')
                            }}</th>
                        <th data-field="action" data-visible="true" data-priority="5" class="text-center">{{__('Действие')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $pp = 1; @endphp

                    @foreach($groupedUnits as $manualNumber => $units)
                        <tr>
                            <td class="text-center">{{ $pp++ }}</td>

                            <td class="text-center">
                                @if ($units->isNotEmpty() && $units->first()->manuals)

                                    {{ $units->first()->manuals->title }}
                                @else
                                    <span>Нет данных о руководстве</span>
                                @endif
                            </td>
                            <td>
                                <select class="form-select">
                                    @foreach($units as $unit)  <!-- Итерируем по $units, а не $groupedUnits -->
                                    @if ($unit->manuals)
                                        <option value="{{ $unit->part_number }}">{{ $unit->part_number }}</option>
                                    @else
                                        <option value="" disabled>Нет данных CMM</option>
                                    @endif
                                    @endforeach
                                </select>
                            </td>

                            <td class="text-center">
                                @if ($units->isNotEmpty() && $units->first()->manuals)
                                    <a href="#" class="view-cmm-btn" data-cmm-id="{{ $units->first()->manuals->id }}">
                                        {{ $manualNumber }}
                                    </a>
                                @else
                                    <span>Нет данных о руководстве</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if ($units->isNotEmpty() && $units->first()->manuals)
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $units->first()->manuals->id }}">
                                        <img src="{{ asset('storage/image/cmm/' . $units->first()->manuals->img) }}" style="max-width: 50px; border:1px" alt="Изображение">
                                    </a>
                                @else
                                    <img src="{{ asset
                                    ('storage/image/No_image.svg') }}"
                                         style="max-width: 50px; border:1px"
                                         alt="Image">
                                @endif
                            </td>

                            <td class="text-center">
                                @foreach($units as $unit)
                                    @php
                                        $partNumbers = is_array($unit->part_numbers) ? $unit->part_numbers : explode(',', $unit->part_numbers);
                                    @endphp
                                @endforeach
                                <div class="d-inline-block mb-2">

                                    <button class="edit-unit-btn"
                                            data-id="{{ $unit->id }}"
                                            data-manuals-id="{{ $unit->manuals_id }}"
                                            data-manual="{{ $unit->manuals->title }}"
                                            data-manual-number="{{ $unit->manuals->number }}"
{{--                                            data-manual-image="{{ $unit->manuals->img }}"--}}
                                            data-manual-image="{{
                                           $units->first()->manuals->img}}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editUnitModal">

                                        <i class="fas fa-edit"></i>
                                    </button>

                           <form action="{{ route('admin.units.destroy', $manualNumber) }}" method="post" style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Вы уверены, что хотите удалить все юниты в этой группе?');">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>

                                </div>
                                <br>

                            </td>
                        </tr>

                        @if ($units->first()->manuals && $units->first()->manuals->img)
                            <!-- Модальное окно для показа большого изображения -->
                            <div class="modal fade" id="imageModal{{ $units->first()->manuals->id }}" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel{{ $units->first()->manuals->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="imageModalLabel{{ $units->first()->manuals->id }}">{{ $units->first()->manuals->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="{{ asset('storage/image/cmm/' . $units->first()->manuals->img) }}" style="max-width: 100%; max-height: 100%;" alt="{{ $units->first()->manuals->title }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Модальное окно для просмотра деталей CMM -->
    <div class="modal fade" id="viewCMMModal" tabindex="-1" role="dialog"
         aria-labelledby="viewCMMModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewCMMModalLabel">
                        {{ __('Данные CMM') }}</h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal" aria-label="Закрыть">
                    </button>
                </div>
                <div class="modal-body">
                    @foreach ($manuals as $manual)
                        <div id="cmm-{{ $manual->id }}" class="cmm-details"
                             style="display: none;">
                            <div class="d-flex">
                                <div class="me-2">
                                    <img src="{{ asset('storage/image/cmm/' .
                                     $manual->img) }}"  style="max-width:
                                     200px;" alt="Image CMM">
                                </div>
                                <div>
                                    <p><strong>{{ __('CMM:') }}</strong> {{ $manual->number }}</p>
                                    <p><strong>{{ __('Description:') }}</strong>
                                        {{ $manual->title }}</p>
                                    <p><strong>{{ __('Revision Date:')
                                    }}</strong> {{ $manual->revision_date }}</p>
                                    <p><strong>{{ __('AirCraft Type:')
                                    }}</strong>
                                        {{ $planes[$manual->planes_id] ?? 'N/A' }}</p>
                                    <p><strong>{{ __('MFR:') }}</strong> {{
                                    $builders[$manual->builders_id] ?? 'N/A' }}</p>
                                    <p><strong>{{ __('Scope:') }}</strong> {{
                                    $scopes[$manual->scopes_id] ?? 'N/A' }}</p>
                                    <p><strong>{{ __('Library:') }}</strong> {{
                                    $manual->lib }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно add Unit -->
    <div class="modal fade" id="addUnitModal" tabindex="-1" aria-labelledby="addUnitLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUnitLabel">Add Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">

                    <!-- Выпадающий список для выбора CMM -->
                    <div class="mb-3">
                        <label for="cmmSelect" class="form-label">Select CMM
                        </label>
                        <select class="form-select" id="cmmSelect">
                            @foreach($manuals as $manual)
                                <option value="{{ $manual->id }}">{{ $manual->title }} ({{ $manual->number }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Поле для ввода PN -->
                    <div id="pnInputs">
                        <div class="input-group mb-2 pn-field">
                            <input type="text" class="form-control" placeholder="Введите PN" style="width: 200px;" name="pn[]">
                            <button class="btn btn-secondary" type="button"
                                    id="addPnField">Add PN</button>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                    <button type="button" id="createUnitBtn" class="btn
                    btn-primary"> Add Unit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно Edit Unit  -->

    <div class="modal fade" id="editUnitModal" tabindex="-1" role="dialog" aria-labelledby="editUnitModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUnitModalLabel"> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col">
                            <div class="modal-body text-center">
                                <img id="cmmImage" src="" style="max-width: 150px;" alt="Image CMM">
{{--                                <img src="{{ asset('storage/image/cmm/' .--}}
{{--                                     $manual->img) }}"  style="max-width:--}}
{{--                                     150px;" alt="Image CMM">--}}
                            </div>
                        </div>
                        <div class="col">

                            @if ($units && $units->count() > 0)
                                <p id="editUnitModalNumber"></p>
                                <div id="partNumbersList"></div>
                            @else
                                <p>No part numbers found for this manual.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="updateUnitButton">Update</button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>

        function deletePartNumber(partNumber) {
            // Логика удаления номера детали
            alert("Deleting part number: " + partNumber);
            // Здесь добавьте свой код для удаления части
        }

        document.getElementById('updateUnitButton').addEventListener('click', function() {
            // Логика обновления единицы
            alert("Updating unit...");
            // Здесь добавьте свой код для обновления единицы
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Initialize DataTable
            var table = $('.data-table').DataTable({
                "order": [],
                "pageLength": 5, // Adjust page length as needed
                // "language": {
                //     "search": "Поиск:",
                //     "paginate": {
                //         "first": "Первая",
                //         "last": "Последняя",
                //         "next": "Следующая",
                //         "previous": "Предыдущая"
                //     },
                //     "info": "Показано _START_ до _END_ из _TOTAL_ записей",
                //     "lengthMenu": "Показать _MENU_ записей",
                // }
            });

            // Ensure modal works with pagination
            $('.data-table').on('draw.dt', function () {
                bindViewCMMEvent();
            });

            // Bind view CMM event
            function bindViewCMMEvent() {
                document.querySelectorAll('.view-cmm-btn').forEach(function (button) {
                    button.addEventListener('click', function () {
                        const cmmId = this.dataset.cmmId;
                        document.querySelectorAll('.cmm-details').forEach(function (cmmDetail) {
                            cmmDetail.style.display = 'none';
                        });
                        document.getElementById('cmm-' + cmmId).style.display = 'block';
                        $('#viewCMMModal').modal('show');
                    });
                });
            }

            // Initial binding
            bindViewCMMEvent();
        });




        // Добавление нового поля ввода PN
        document.getElementById('addPnField').addEventListener('click', function() {
            const newPnField = document.createElement('div');
            newPnField.className = 'input-group mb-2 pn-field';
            newPnField.innerHTML = `
                <input type="text" class="form-control" placeholder="Введите PN" style="width: 200px;" name="pn[]">
                <button class="btn btn-danger removePnField" type="button">Удалить</button>
            `;
            document.getElementById('pnInputs').appendChild(newPnField);
        });

        // Удаление поля ввода PN
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('removePnField')) {
                event.target.parentElement.remove();
            }
        });

        // Логика для создания юнита
        document.getElementById('createUnitBtn').addEventListener('click', function() {
            const cmmId = document.getElementById('cmmSelect').value;
            const pnValues = Array.from(document.querySelectorAll('input[name="pn[]"]')).map(input => input.value.trim());

            // AJAX-запрос для отправки данных на сервер
            if (cmmId && pnValues.length > 0) {
                $.ajax({
                    url: '{{ route('admin.units.store') }}', // Обновите с вашим маршрутом для сохранения юнитов
                    type: 'POST',
                    data: {
                        cmm_id: cmmId,
                        part_numbers: pnValues,
                        _token: '{{ csrf_token() }}' // CSRF токен для Laravel
                    },
                    success: function(response) {
                        // Обработка успешного ответа
                        console.log(response);
                        location.reload(); // Перезагрузка страницы, чтобы увидеть новый юнит в таблице
                    },
                    error: function(xhr) {
                        // Обработка ошибок
                        console.error(xhr.responseText);
                        alert('An error occurred while creating the unit. Please try again.');
                    }
                });
            } else {
                alert('Please select CMM and enter at least one PN.');
            }
        });

        // Логика для Edit Unit
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.edit-unit-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const unitId = button.getAttribute('data-id');
                    const manualId = button.getAttribute('data-manuals-id');
                    const manualTitle = button.getAttribute('data-manual');
                    const manualImage = button.getAttribute('data-manual-image'); // Получаем путь к изображению

                    // Проверка, что путь к изображению передан
                    console.log('Manual Image:', manualImage);


                    const manualNumber = button.getAttribute
                    ('data-manual-number');

                    // Установка данных в модальное окно
                    document.getElementById('editUnitModalLabel').innerText = `Unit: ${manualTitle}`;
                    document.getElementById('editUnitModalNumber').innerText =
                        `CMM: ${manualNumber}`;

                    // Установка изображения
                    const cmmImage = document.getElementById('cmmImage');
                    if (manualImage) {
                        cmmImage.src = `/storage/image/cmm/${manualImage}`;
                    } else {
                        cmmImage.src = `/storage/image/Noimage.svg`;  // Путь к
                        // изображению по умолчанию
                    }


                    // console.log('Fetching units for manualId:', manualId);

                    // Отправка запроса для получения юнитов, связанных с мануалом
                    fetch(`units/${manualId}`)
                        .then(response => response.json())
                        .then(data => {
                            const partNumbersList = document.getElementById('partNumbersList');

                            if (partNumbersList) {
                                partNumbersList.innerHTML = ''; // Очистите текущий список
                            } else {
                                console.error('Элемент с id "partNumbersList" не найден.');
                            }

                            if (data.units && data.units.length > 0) {
                                data.units.forEach(function(unit) {
                                    const listItem = document.createElement('div');
                                    listItem.className = 'mb-2 d-flex';

                                    const input = document.createElement('input');
                                    input.type = 'text';
                                    input.className = 'form-control';
                                    input.style.width = '200px';
                                    input.value = unit.part_number;
                                    input.readOnly = true;

                                    const deleteButton = document.createElement('button');
                                    deleteButton.className = 'btn btn-danger btn-sm ms-1';
                                    deleteButton.innerText = 'Del';
                                    deleteButton.onclick = function() {
                                        deletePartNumber(unit.part_number);
                                    };

                                    listItem.appendChild(input);
                                    listItem.appendChild(deleteButton);
                                    partNumbersList.appendChild(listItem);
                                });
                            } else {
                                const noUnitsItem = document.createElement('div');
                                noUnitsItem.className = 'mb-2';
                                noUnitsItem.innerText = 'No part numbers found for this manual.';
                                partNumbersList.appendChild(noUnitsItem);
                            }
                        })
                        .catch(error => {
                            console.error('Error loading units:', error);
                        });

                    // Открываем модальное окно
                    $('#editUnitModal').modal('show');
                });
            });
        });






        {{--// Логика для update Unit--}}
        {{--document.getElementById('updateUnitBtn').addEventListener('click', function() {--}}
        {{--    const unitId = document.getElementById('partNumberSelect').value;--}}
        {{--    const newPn = document.getElementById('editPnField').value.trim();--}}

        {{--    if (unitId && newPn) {--}}
        {{--        $.ajax({--}}
        {{--            url: `{{ url('units') }}/${unitId}`, // Обновите с вашим маршрутом обновления--}}
        {{--            type: 'PUT',--}}
        {{--            data: {--}}
        {{--                part_number: newPn,--}}
        {{--                _token: '{{ csrf_token() }}' // CSRF токен для Laravel--}}
        {{--            },--}}
        {{--            success: function(response) {--}}
        {{--                console.log(response);--}}
        {{--                location.reload(); // Перезагрузка страницы, чтобы увидеть обновленный юнит в таблице--}}
        {{--            },--}}
        {{--            error: function(xhr) {--}}
        {{--                console.error(xhr.responseText);--}}
        {{--                alert('An error occurred while updating the unit. Please try again.');--}}
        {{--            }--}}
        {{--        });--}}
        {{--    } else {--}}
        {{--        alert('Please select a unit and enter a new PN.');--}}
        {{--    }--}}
        {{--});--}}

        // Инициализация DataTables
        $(document).ready(function() {
            $('#cmmTable').DataTable();
        });
    </script>
@endsection
