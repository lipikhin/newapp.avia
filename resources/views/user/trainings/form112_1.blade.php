<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form 112</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        @media print {
            /* Задаем размер бумаги Letter (8.5 x 11 дюймов) */
            @page {
                size: letter;
                /*margin: .05in; !* Поля страницы можно настроить по своему*/
                усмотрению */
            }

            /* Сбрасываем ненужные стили для печати */
            body {
                font-size: 12pt;
                color: #000;
                background-color: #fff;
                margin: 0;
                padding: 0;
            }

            /* Скрываем элементы, не нужные для печати */
            .no-print {
                display: none;
            }

            /*!* Оптимизируем отображение таблиц *!*/
            /*table {*/
            /*    border-collapse: collapse;*/
            /*    width: 100%;*/
            /*}*/

            /*th, td {*/
            /*    border: 1px solid black;*/
            /*    padding: 8px;*/
            /*    text-align: left;*/
            /*}*/

            /*!* Убираем прокрутку, если есть *!*/
            /*html, body {*/
            /*    overflow: visible;*/
            /*}*/



        }

    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <img src="{{asset('image/AT_logo-rb.svg')}}" alt="Logo"
             style="width: 150px; margin-top: 6px; margin-left: 10px">
    </div>

    <div class="row justify-content-md-center">
        <div class="col-2 "></div>
        <div class="col-6 border border-dark  ">
            <h2 class="pt-2 pb-2 text-black text-center "><strong>The Job
                    Training
                    Record</strong> </h2>
        </div>
        <div class="col-2 "></div>
    </div>


    <h3>User Information</h3>


    <div class="">
        <p><strong>Name:</strong> {{ $training->user->name }}</p>
        <p><strong>Unit:</strong> {{ $training->manual->title }}</p>
        <p><strong>Unit:</strong> {{ $training->manual->units_pn }}</p>
        <p><strong>Training
                Date:</strong> {{ \Carbon\Carbon::parse($training->date_training)->format('m-d-Y') }}
        </p>

        @php
            // Получаем самую раннюю дату тренировки с формой 112 для текущего мануала
            $earliestTrainingDate = $training->manual->trainings()
                ->where('form_type', 112)

                ->min('date_training');
        @endphp

        <p>
            <strong>Duration:</strong>
            @if($training->form_type == 112 && $training->date_training == $earliestTrainingDate)
                {{ $training->manual->units_tr }} hours.
            @else
                2 hours
            @endif
        </p>

    </div>
</div>

<!-- Add more sections as needed based on the form's fields -->

<div class="form-section">
    <h3>Signature</h3>
    <div class="form-content">
        <p>____________________________________</p>
        <p><em>User Signature</em></p>
    </div>
</div>
</div>

</div>

</body>
<button class="btn btn-primary" onclick="window.print()">Print Form</button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>

