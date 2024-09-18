@extends('layouts.base')


@section('content')

    {{--    <style>--}}
    {{--    .card {--}}
    {{--        max-width: 850px;--}}
    {{--    }--}}
    {{--    .card-body {--}}
    {{--        max-width: 850px;--}}
    {{--    }--}}
    {{--</style>--}}


    <div class="container ">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div class="d-flex" style="width: 450px">
                        <h3>{{ __('Trainings') }}</h3>
                        <a href="#" class="btn btn-primary ms-3">{{ __('Complete Training') }}</a>
                    </div>
                    <div class="align-middle">
                        <a href="{{ route('user.trainings.create') }}" class="btn btn-primary align-middle">
                            {{ __('Add Unit') }}</a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                {{--                <pre>{{ print_r($formattedTrainingLists, true) }}</pre> <!-- Здесь вывод данных -->--}}
                <table id="trainingsTable" data-toggle="table" data-search="true" data-pagination="false"
                       data-page-size="5" class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center align-middle">{{ __('Training (Yes/No)') }}</th>
                        <th class="text-center align-middle">{{ __('Form 132') }}</th>
                        <th class="text-center align-middle">{{ __('Unit PN') }}</th>
                        <th class="text-center align-middle">{{ __('Description') }}</th>
                        <th class="text-center align-middle">{{ __('First Training Date') }}</th>
                        <th class="text-center align-middle">{{ __('Last Training Date') }}</th>
                        <th class="text-center align-middle">{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($formattedTrainingLists as $trainingList)
                        <tr>
                            <td class="text-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox"
                                           @if(isset($trainingList['last_training']) && \Carbon\Carbon::parse($trainingList['last_training']->date_training)
                                           ->diffInDays(\Carbon\Carbon::now()) < 340)
                                               disabled
                                           @endif
                                           onchange="handleCheckboxChange(this, '{{ $trainingList['first_training']->manuals_id }}', '{{ $trainingList['first_training']->date_training }}', '{{ $trainingList['first_training']->manual->title ?? 'N/A' }}')">
                                    <label class="form-check-label" for="flexSwitchCheckChecked"></label>

                                </div>
                            </td>
                            <td class="text-center">
                                @if(isset($trainingList['first_training']) && $trainingList['first_training']->form_type == 132)
                                    <label>OK</label>
                                @else
                                    <label>No</label>
                                @endif
                            </td>

                            <td class="text-center">{{ $trainingList['first_training']->manual->units_pn ?? 'N/A' }}</td>
                            <td class="text-center">{{ $trainingList['first_training']->manual->title ?? 'N/A' }}</td>

                            <td class="text-center">
                                {{ isset($trainingList['first_training']) ? \Carbon\Carbon::parse($trainingList['first_training']->date_training)->format('m-d-Y') : 'N/A' }}
                            </td>

                            <td class="text-center"
                                @if(isset($trainingList['last_training']) && \Carbon\Carbon::parse($trainingList['last_training']->date_training)->diffInDays(\Carbon\Carbon::now()) > 340)
                                    style="color: red"
                                @endif>
                                {{ isset($trainingList['last_training']) ? \Carbon\Carbon::parse($trainingList['last_training']->date_training)->format('m-d-Y') : 'N/A' }}
                            </td>

                            <td class="text-center">
                                <!-- Кнопка для вызова модального окна или страницы -->
                                <button class="btn btn-primary" data-toggle="modal"
                                        data-target="#trainingModal{{ $trainingList['first_training']->manuals_id }}">
                                    View Training
                                </button>

                                <!-- Модальное окно -->
                                <div class="modal fade"
                                     id="trainingModal{{ $trainingList['first_training']->manuals_id }}" tabindex="-1"
                                     aria-labelledby="trainingModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="trainingModalLabel">Select Training
                                                    for {{ $trainingList['first_training']->manual->title }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @foreach($trainingList['trainings'] as $training)
                                                    <div class="form-group">
                                                        <label>{{ $training->date_training }} (Form
                                                            Type: {{ $training->form_type }})</label>
                                                        @if($training->form_type == '112')
                                                            <a href="{{ route
                                                            ('user.trainings.form112', $training->id) }}"
                                                               class="btn btn-success" target="_blank">View/Print Form
                                                                112</a>
                                                        @elseif($training->form_type == '132')
                                                            <a href="{{ route('user.trainings.form132', $training->id) }}"
                                                               class="btn btn-info" target="_blank">View/Print Form
                                                                132</a>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function handleCheckboxChange(checkbox, manualsId, dateTraining, manualsTitle) {
            if (checkbox.checked) {
// Определяем номер недели и год последней тренировки
                const lastTrainingDate = new Date(dateTraining);
                const lastTrainingYear = lastTrainingDate.getFullYear();
                const lastTrainingWeek = getWeekNumber(lastTrainingDate);

// Получаем текущую дату
                const currentYear = new Date().getFullYear();

// Создаем массив для данных, которые будем отправлять
                let trainingData = {
                    manuals_id: [],
                    date_training: [],
                    form_type: []
                };

// Генерируем данные для создания тренингов за следующие годы
                for (let year = lastTrainingYear + 1; year <= currentYear; year++) {
                    const trainingDate = getDateFromWeekAndYear(lastTrainingWeek, year);
                    trainingData.manuals_id.push(manualsId);
                    trainingData.date_training.push(trainingDate.toISOString().split('T')[0]); // Преобразуем в формат YYYY-MM-DD
                    trainingData.form_type.push('112');
                }

// Подготовка сообщения для подтверждения
                let confirmationMessage = "Предоставленные данные для создания тренингов:\n";
                trainingData.manuals_id.forEach((id, index) => {
                    confirmationMessage += `\nTraining for ${lastTrainingYear + index + 1} years:\n`;
                    confirmationMessage += `Manuals ID: ${id} ${manualsTitle}\n`;
                    confirmationMessage += `Дата тренировки: ${trainingData.date_training[index]} \n`;
                    confirmationMessage += `Форма: ${trainingData.form_type[index]} \n`;
                });

// Показываем сообщение для подтверждения
                if (confirm(confirmationMessage + "\nВы уверены, что хотите продолжить создание тренингов?")) {
// Если пользователь подтвердил, выполняем запрос
                    fetch('{{ route('user.trainings.createTraining') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(trainingData) // Отправляем ассоциативный массив
                    })
                        .then(response => response.json())

                        .then(data => {
                            if (data.success) {
                                alert('Тренинги успешно созданы!');
                                location.reload();
                                checkbox.checked = false;
                            } else {
                                alert('Ошибка при создании тренингов.');
                            }
                        })

                        .catch(error => {
                            console.error('Ошибка:', error);
                            alert('Произошла ошибка: ' + error.message);
                        });
                } else {
// Если пользователь отказался, снимаем галочку
                    checkbox.checked = false;
                }
            }
        }


        function getWeekNumber(d) {
            const oneJan = new Date(d.getFullYear(), 0, 1);
            const numberOfDays = Math.floor((d - oneJan) / (24 * 60 * 60 * 1000));
            return Math.ceil((numberOfDays + oneJan.getDay() + 1) / 7);
        }

        function getDateFromWeekAndYear(week, year) {
            const firstJan = new Date(year, 0, 1);
            const days = (week - 1) * 7 - firstJan.getDay() + 1;
            return new Date(year, 0, 1 + days);
        }
    </script>

@endsection
