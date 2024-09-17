@extends('layouts.base')

<style>
    .card {
        max-width: 750px;
    }

    .card-body {
        max-width: 750px;
    }
</style>

@section('content')
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
                <table id="trainingsTable" data-toggle="table" data-search="true" data-pagination="false" data-page-size="5" class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center align-middle">{{ __('Training (Yes/No)') }}</th>
                        <th class="text-center align-middle">{{ __('Form 132') }}</th>
                        <th class="text-center align-middle">{{ __('Unit PN') }}</th>
                        <th class="text-center align-middle">{{ __('Description') }}</th>
                        <th class="text-center align-middle">{{ __('First Training Date') }}</th>
                        <th class="text-center align-middle">{{ __('Last Training Date') }}</th>
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
