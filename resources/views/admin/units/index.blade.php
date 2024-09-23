@extends('layouts.base')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <div class="container">
        <div class="card shadow">

            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div style="width: 450px">
                        <h3>{{__('Управление юнитами')}}</h3>
                    </div>
                    <!-- Кнопка Добавить юнит -->
                    <button class="btn btn-primary mb-1"
                            data-bs-toggle="modal"
                            data-bs-target="#addUnitModal">{{__('Добавить юнит')}}</button>
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
                        <th data-field="part_number" data-visible="true" data-priority="2" class="text-center">{{__('PN юнита')}}</th>
                        <th data-field="number" data-visible="true" data-priority="3" class="text-center">{{__('CMM юнита')}}</th>
                        <th data-field="img" data-visible="true" data-priority="4" class="text-center">{{__('Изображение юнита')}}</th>
                        <th data-field="action" data-visible="true" data-priority="5" class="text-center">{{__('Действие')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $pp = 1; @endphp

                    @foreach($units as $manualNumber => $groupedUnits)
                        <tr>
                            <td class="text-center">{{ $pp++ }}</td>

                            <td>
                                <select class="form-select">
                                    @foreach($groupedUnits as $unit)
                                        @if ($unit->manuals)
                                            <option value="{{ $unit->part_number }}">{{ $unit->part_number }}</option>
                                        @else
                                            <option value="" disabled>Нет данных CMM</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>

                            <td class="text-center">
                                @if ($groupedUnits->isNotEmpty() && $groupedUnits->first()->manuals)
                                    <a href="#" class="view-cmm-btn" data-cmm-id="{{ $groupedUnits->first()->manuals->id }}">
                                        {{ $manualNumber }}
                                    </a>
                                @else
                                    <span>Нет данных о руководстве</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if ($groupedUnits->isNotEmpty() && $groupedUnits->first()->manuals)
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $groupedUnits->first()->manuals->id }}">
                                        <img src="{{ asset('storage/image/cmm/' . $groupedUnits->first()->manuals->img) }}" style="max-width: 50px; border:1px" alt="Изображение">
                                    </a>
                                @else
                                    Нет изображения
                                @endif
                            </td>
                            <td class="text-center">
                                @php
                                    $partNumbers = is_array($unit->part_numbers) ? $unit->part_numbers : explode(',', $unit->part_numbers);
                                @endphp

                                <div class="d-inline-block mb-2">
                                    <button class="edit-unit-btn"
                                            data-id="{{ $unit->id }}"
                                            data-cmm="{{ $unit->cmm_id }}"
                                            data-pn="{{ $unit->part_number }}"
                                            data-part-numbers="{{ implode(',', $partNumbers) }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editUnitModal">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('admin.units.destroy', $unit->id) }}" method="post" style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>


                                <br>
                            </td>
                        </tr>

                        @if ($groupedUnits->first()->manuals && $groupedUnits->first()->manuals->img)
                            <!-- Модальное окно для показа большого изображения -->
                            <div class="modal fade" id="imageModal{{ $groupedUnits->first()->manuals->id }}" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel{{ $groupedUnits->first()->manuals->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="imageModalLabel{{ $groupedUnits->first()->manuals->id }}">{{ $groupedUnits->first()->manuals->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="{{ asset('storage/image/cmm/' . $groupedUnits->first()->manuals->img) }}" style="max-width: 100%; max-height: 100%;" alt="{{ $groupedUnits->first()->manuals->title }}">
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
    <div class="modal fade" id="viewCMMModal" tabindex="-1" role="dialog" aria-labelledby="viewCMMModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewCMMModalLabel">{{ __('Данные CMM') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    @foreach ($manuals as $manual)
                        <div id="cmm-{{ $manual->id }}" class="cmm-details" style="display: none;">
                            <div class="d-flex">
                                <div class="me-2">
                                    <img src="{{ asset('storage/image/cmm/' . $manual->img) }}" style="max-width: 200px;" alt="Изображение CMM">
                                </div>
                                <div>
                                    <p><strong>{{ __('CMM:') }}</strong> {{ $manual->number }}</p>
                                    <p><strong>{{ __('Описание:') }}</strong> {{ $manual->title }}</p>
                                    <p><strong>{{ __('Дата ревизии:') }}</strong> {{ $manual->revision_date }}</p>
                                    <p><strong>{{ __('Тип самолета:') }}</strong> {{ $planes[$manual->planes_id] ?? 'N/A' }}</p>
                                    <p><strong>{{ __('Изготовитель:') }}</strong> {{ $builders[$manual->builders_id] ?? 'N/A' }}</p>
                                    <p><strong>{{ __('Область применения:') }}</strong> {{ $scopes[$manual->scopes_id] ?? 'N/A' }}</p>
                                    <p><strong>{{ __('Библиотека:') }}</strong> {{ $manual->lib }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно Добавить юнит -->
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

    <!-- Модальное окно Редактировать юнит -->
    <!-- Modal -->
    <div class="modal fade" id="editUnitModal" tabindex="-1" aria-labelledby="editUnitModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUnitModalLabel">
                        @if ($manuals && $manuals->count() > 0)
                            Unit {{ $manuals->first()->title }}
                        @else
                            Unit Not Found
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($manuals && $manuals->count() > 0)
                        <p>CMM {{ $manuals->first()->number }}</p>

                        @if (!empty($unit->part_numbers))
                            @foreach ($unit->part_numbers as $partNumber)
                                <div class="mb-2">
                                    <input type="text" class="form-control" value="{{ $partNumber }}" readonly>
                                    <button type="button" class="btn btn-danger btn-sm mt-1" onclick="deletePartNumber('{{ $partNumber }}')">Del</button>
                                </div>
                            @endforeach
                        @else
                            <p>No part numbers found.</p>
                        @endif

                    @else
                        <p>No manuals found.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="updateUnitButton">Update</button>
                </div>
            </div>
        </div>
    </div>

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
    </script>







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
                        alert('Произошла ошибка при создании юнита. Пожалуйста, попробуйте снова.');
                    }
                });
            } else {
                alert('Пожалуйста, выберите CMM и введите хотя бы один PN.');
            }
        });

        // Логика для редактирования юнита
        document.querySelectorAll('.edit-unit-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const unitId = button.getAttribute('data-id');
                const cmmId = button.getAttribute('data-cmm');
                const pn = button.getAttribute('data-pn');
                const partNumbers = button.getAttribute('data-part-numbers').split(','); // Получите все PN в виде массива

                // Установка деталей в модальном окне редактирования
                document.getElementById('partNumberSelect').value = unitId;
                document.getElementById('editPnField').value = pn;
                document.getElementById('cmmDetails').innerText = `CMM: ${cmmId}`; // Настройте по мере необходимости

                // Заполнение списка PN
                const partNumbersList = document.getElementById('partNumbersList');
                partNumbersList.innerHTML = ''; // Очистите текущий список
                partNumbers.forEach(function(partNumber) {
                    const listItem = document.createElement('li');
                    listItem.className = 'list-group-item';
                    listItem.innerText = partNumber; // Установка текста на основе PN
                    partNumbersList.appendChild(listItem);
                });

                // Открытие модального окна редактирования
                $('#editUnitModal').modal('show');
            });
        });


        // Логика для обновления юнита
        document.getElementById('updateUnitBtn').addEventListener('click', function() {
            const unitId = document.getElementById('partNumberSelect').value;
            const newPn = document.getElementById('editPnField').value.trim();

            if (unitId && newPn) {
                $.ajax({
                    url: `{{ url('units') }}/${unitId}`, // Обновите с вашим маршрутом обновления
                    type: 'PUT',
                    data: {
                        part_number: newPn,
                        _token: '{{ csrf_token() }}' // CSRF токен для Laravel
                    },
                    success: function(response) {
                        console.log(response);
                        location.reload(); // Перезагрузка страницы, чтобы увидеть обновленный юнит в таблице
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Произошла ошибка при обновлении юнита. Пожалуйста, попробуйте снова.');
                    }
                });
            } else {
                alert('Пожалуйста, выберите юнит и введите новый PN.');
            }
        });

        // Инициализация DataTables
        $(document).ready(function() {
            $('#cmmTable').DataTable();
        });
    </script>
@endsection
