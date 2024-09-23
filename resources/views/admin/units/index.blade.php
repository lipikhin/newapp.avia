@extends('layouts.base')

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div style="width: 450px">
                        <h3>Units</h3>
                    </div>
                    <!-- Поисковое окно -->
{{--                    <input type="text" class="form-control mb-3" placeholder="Search Units" id="unitSearch">--}}

                    <!-- Кнопка Add Unit -->
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUnitModal">Add Unit</button>


                </div>
            </div>
            <div class="card-body">

            </div>

            <table id="unitTable" data-toggle="table"
                   data-search="true" data-pagination="false"
                   class="table table-bordered">
                <thead>
                <tr>
                    <th  data-priority="1"  data-visible="true"
                         class="text-center
                        align-middle">#</th>
                    <th  data-priority="2"  data-visible="true"
                         class="text-center
                        align-middle">Unit PN</th>
                    <th  data-priority="3"  data-visible="true"
                         class="text-center
                        align-middle">Unit CMM</th>
                    <th  data-priority="4"  data-visible="true"
                         class="text-center
                        align-middle">Unit Image</th>
                    <th data-priority="5"  data-visible="true"
                    class="text-center
                    align-middle" >Action</th>

                </tr>
                </thead>
                <tbody>
                @foreach($units as $unit)
                    <tr>
                        <td>{{ $loop->iteration }}</td> <!-- Номер по порядку -->
                        <td>{{ $unit->part_number }}</td> <!-- PN -->
                        <td>{{ $unit->manuals->number ?? 'No CMM' }}</td> <!-- CMM -->
                        <td>{{ $unit->manuals->title ?? 'No Title' }}</td> <!-- Image -->
                        <td>
                            <!-- Кнопки для действий -->
                            <a href="{{ route('admin.units.edit', $unit->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.units.destroy', $unit->id) }}" method="POST"
                                  style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach


                </tbody>
            </table>



        </div>




      <!-- Таблица юнитов -->

    </div>

    <!-- Модальное окно Add Unit -->
    <div class="modal fade" id="addUnitModal" tabindex="-1" aria-labelledby="addUnitLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUnitLabel">Add Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Дропдаун для выбора CMM -->
                    <div class="mb-3">
                        <label for="cmmSelect" class="form-label" >Select CMM</label>
                        <select class="form-select" id="cmmSelect">
                            @foreach($manuals as $manual)
                                <option value="{{ $manual->id }}">{{ $manual->title }} ({{ $manual->number }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Поле для ввода PN -->
                    <div id="pnInputs">
                        <div class="input-group mb-2 pn-field">
                            <input type="text" class="form-control" placeholder="Enter PN" style="width: 200px;" name="pn[]">
                            <button class="btn btn-secondary" type="button" id="addPnField">Add PN</button>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="createUnitBtn">Create</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        // Добавление нового поля PN
        document.getElementById('addPnField').addEventListener('click', function() {
            let pnInputs = document.getElementById('pnInputs');
            let newField = document.createElement('div');
            newField.className = "input-group mb-2 pn-field";
            newField.innerHTML = `<input type="text" class="form-control" placeholder="Enter PN" style="width: 200px;" name="pn[]">
<!--                              <button class="btn btn-secondary" type="button" id="addPnField">Add PN</button>-->`;
            pnInputs.appendChild(newField);
        });



        // Логика отправки данных для создания юнита
        document.getElementById('createUnitBtn').addEventListener('click', function() {
            let cmmId = document.getElementById('cmmSelect').value;
            let pnFields = document.querySelectorAll('.pn-field input');
            let pnValues = [];

            pnFields.forEach(function(field) {
                let pnValue = field.value.trim();
                if (pnValue !== '') {
                    pnValues.push(pnValue);
                }
            });

            // AJAX запрос для отправки данных на сервер
            if (cmmId && pnValues.length > 0) {
                let token = "{{ csrf_token() }}"; // Получаем CSRF токен

                fetch("{{ route('admin.units.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token
                    },
                    body: JSON.stringify({
                        cmm_id: cmmId,
                        part_numbers: pnValues
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Units successfully added!');
                            location.reload(); // Перезагрузка страницы для обновления таблицы
                        } else {
                            alert('Failed to add units');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            } else {
                alert('Please select CMM and enter at least one part number.');
            }
        });
    </script>
@endsection

