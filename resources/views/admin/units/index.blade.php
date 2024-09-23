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

            <table class="table table-bordered data-table">
                <thead>
                <tr class="table-secondary">
                    <th class="text-center">{{__('#')}}</th>
                    <th class="text-center">{{__('Unit PN')}}</th>
                    <th class="text-center">{{__('Unit CMM')}}</th>
                    <th class="text-center">{{__('Unit Image')}}</th>
                    <th class="text-center">{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                @php $pp = 1; @endphp
                @foreach($units as $manualNumber => $groupedUnits)
                    <tr>
                        <td class="text-center">{{ $pp++ }}</td>
                        <td>
                            @foreach($groupedUnits as $unit)
                                @if ($unit->manual)
                                    <p>{{ $unit->part_number }}</p>
                                @else
                                    <p>No CMM data</p>
                                @endif
                            @endforeach
                        </td>
                        <td class="text-center">
                            <a href="#" class="view-cmm-btn" data-cmm-id="{{ $groupedUnits->first()->manuals->id }}">
                                {{ $manualNumber }}
                            </a>
                        </td>
                        <td class="text-center">
                            @if ($groupedUnits->first()->manual && $groupedUnits->first()->manual->img)
                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $groupedUnits->first
                                ()->manual->id }}">
                                    <img src="{{ asset('storage/image/cmm/' . $groupedUnits->first()->manual->img) }}"
                                         style="max-width: 50px; border:1px" alt="Image">
                                </a>
                            @else
                                No Image
                            @endif
                        </td>
                        <td class="text-center">
                            @foreach($groupedUnits as $unit)
                                <div class="d-inline-block mb-2">
                                    <a href="{{ route('admin.units.edit', $unit->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.units.destroy', $unit->id) }}" method="post" style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit"> <i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div><br>
                            @endforeach
                        </td>
                    </tr>

                    @if ($groupedUnits->first()->manual && $groupedUnits->first()->manual->img)
                        <!-- Modal  Big Image Show-->
                        <div class="modal fade" id="imageModal{{ $groupedUnits->first()->manual->id }}" tabindex="-1"
                             role="dialog" aria-labelledby="imageModalLabel{{ $groupedUnits->first()->manual->id }}"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="imageModalLabel{{ $groupedUnits->first()
                                        ->manual->id }}">{{ $groupedUnits->first()->manual->title }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('storage/image/cmm/' . $groupedUnits->first()->manuals->img)
                                         }}" style="max-width: 100%; max-height: 100%;" alt="{{ $groupedUnits->first
                                         ()->manuals->title }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                </tbody>
            </table>



        </div>




      <!-- Таблица юнитов -->

    </div>

    <!-- Modal for viewing CMM details -->
    <div class="modal fade" id="viewCMMModal" tabindex="-1" role="dialog" aria-labelledby="viewCMMModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewCMMModalLabel">{{ __('CMM
                     Data') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @foreach ($manuals as $manual)


                        <div id="cmm-{{ $manual->id }}" class="cmm-details" style="display: none;">
                            <div class="d-flex">
                                <div class="me-2">
                                    {{--                                        <p><strong>{{ __('Изображение:') }}</strong></p>--}}
                                    <img src="{{ asset
                                        ('storage/image/cmm/' . $manual->img)
                                        }}" style="max-width: 200px;"
                                         alt="Image CMM">
                                </div>
                                <div>
                                    <p><strong>{{ __('CMM:') }}</strong> {{
                                         $manual->number }}</p>
                                    <p><strong>{{ __('Description:')
                                        }}</strong> {{ $manual->title }}</p>
                                    <p><strong>{{ __('Revision Date:')
                                        }}</strong> {{ $manual->revision_date }}</p>
                                    <p><strong>{{ __('AirCraft Type:')
                                        }}</strong> {{ $planes[$manual->planes_id] ?? 'N/A' }}</p>
                                    <p><strong>{{ __('MFR:') }}</strong> {{
                                         $builders[$manual->builders_id] ?? 'N/A' }}</p>
                                    <p><strong>{{ __('Scope:')
                                        }}</strong> {{ $scopes[$manual->scopes_id] ?? 'N/A' }}</p>
                                    <p><strong>{{ __('Library: ')
                                        }}</strong> {{ $manual->lib }}</p>

                                </div>

                            </div>


                        </div>


                    @endforeach
                </div>
            </div>
        </div>
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

    </script>
@endsection

