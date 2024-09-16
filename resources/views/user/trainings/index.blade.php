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
                                           onchange="handleCheckboxChange(this, '{{ $trainingList['first_training']->manuals_id }}', '{{ $trainingList['first_training']->date_training }}')">
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

    <<script>
        function handleCheckboxChange(checkbox, manualsId, dateTraining) {
            if (checkbox.checked) {
                // Определяем номер недели и год последней тренировки
                const lastTrainingDate = new Date(dateTraining);
                const lastTrainingYear = lastTrainingDate.getFullYear();
                const lastTrainingWeek = getWeekNumber(lastTrainingDate);

                // Получаем текущую дату
                const currentYear = new Date().getFullYear();
                let messages = [];

                // Генерируем сообщения для создания тренингов за следующие годы
                for (let year = lastTrainingYear + 1; year <= currentYear; year++) {
                    const trainingDate = getDateFromWeekAndYear(lastTrainingWeek, year);
                    messages.push(`Создание тренинга для формы 112:\nManuals ID: ${manualsId}\nДата тренировки: ${trainingDate.toLocaleDateString()}`);
                }

                // Показываем все сообщения
                alert(messages.join('\n\n'));
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
    </script><script>
        function handleCheckboxChange(checkbox, manualsId, dateTraining) {
            if (checkbox.checked) {
                // Определяем номер недели и год последней тренировки
                const lastTrainingDate = new Date(dateTraining);
                const lastTrainingYear = lastTrainingDate.getFullYear();
                const lastTrainingWeek = getWeekNumber(lastTrainingDate);

                // Получаем текущую дату
                const currentYear = new Date().getFullYear();

                // Создаем массив для данных, которые будем отправлять
                let trainingData = [];

                // Генерируем данные для создания тренингов за следующие годы
                for (let year = lastTrainingYear + 1; year <= currentYear + 1; year++) {
                    const trainingDate = getDateFromWeekAndYear(lastTrainingWeek, year);
                    trainingData.push({
                        manuals_id: manualsId,
                        date_training: trainingDate.toISOString().split('T')[0], // Преобразуем в YYYY-MM-DD
                        form_type: '112'
                    });
                }

                // Отправка AJAX-запроса для сохранения тренингов
                fetch('/trainings/createTraining', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Включаем CSRF токен
                    },
                    body: JSON.stringify(trainingData)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Тренинги успешно созданы!');
                        } else {
                            alert('Ошибка при создании тренингов.');
                        }
                    })
                    .catch(error => console.error('Ошибка:', error));
            } else {
                checkbox.checked = false; // Убедитесь, что чекбокс снят
            }
        }


    </script>


@endsection
