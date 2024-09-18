<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form 112</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous">
    <style>
        @media print {
            /* Задаем размер бумаги Letter (8.5 x 11 дюймов) */
            @page {
                size: letter;
                /*margin: .05in; !* Поля страницы можно настроить по своему*/
                /*усмотрению *!*/
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
<p class="container-fluid">
<div class="row">
    <img src="{{asset('image/AT_logo-rb.svg')}}" alt="Logo"
         style="width: 150px; margin-top: 6px; margin-left: 10px">
</div>

<div class="row justify-content-md-center">
    <div class="col-2 "></div>
    <div class="col-6 border border-dark  ">
        <h2 class="pt-2 pb-2 text-black text-center "><strong>The Job
                Training Record</strong></h2>
    </div>
    <div class="col-2 "></div>
</div>

<div class="row ps-2 pe-2 mt-3">
    <div class="col-3 text-black border-bottom border-dark">
        <h4>
            <strong>For the Week of:</strong>
        </h4>
    </div>
    <div class="col-3 text-black text-center border-bottom border-dark">
        <h5>
            <strong>{{\Carbon\Carbon::parse ($training->date_training)->subDay(4)->format('m-d-Y')}}
            </strong>
        </h5>
    </div>
    <div class="col-1 border-bottom border-dark">-</div>

    <div class="col-3 text-black text-left border-bottom border-dark">
        <h5>
            <strong>{{\Carbon\Carbon::parse ($training->date_training)->format('m-d-Y')}}</strong>
        </h5>
    </div>
    <div class="col-2 border-bottom border-dark"></div>
</div>

<div class="row   ps-2 pe-2 mt-3">
    <div class="col-4 text-black">
        <h5><strong>Trainee (Please print name):</strong></h5>
    </div>
    <div class="col-4 text-black text-center border-bottom border-dark">
        <h5>
            <strong>
                {{ $training->user->name }}
            </strong>
        </h5>
    </div>
    <div class="col-4 border-bottom border-dark"></div>
</div>

@php
    // Получаем самую раннюю дату тренировки с формой 112 для текущего мануала
    $earliestTrainingDate = $training->manual->trainings()
        ->where('form_type', 112)

        ->min('date_training');
@endphp

<div class="row  ps-2 pe-2 mt-3">
    <div class="col-1 text-black border
        border-dark pt-4" style="width:
        100px"><h6><strong>Topic</strong></h6></div>
    <div class="col-8 text-black text-center border-bottom
        border-dark pt-4" style="width: 600px"><h5>
            <strong>{{ $training->manual->title }} {{'  '}}{{
                $training->manual->units_pn }} </strong></h5>
    </div>
    <div class="col-2 text-black text-center border  border-dark pt-1"
         style="width: 100px">
        <h6><strong>Hrs on Topic</strong></h6>
    </div>
    <div class="col-1 text-black text-center border border-dark pt-1"
         style="width: 100px">
        <h6><strong>Trainers Initials</strong></h6>
    </div>
</div>
<div class="row ps-2 pe-2">
    <div class="col-9 text-black text-left border
        border-dark pt-1" style="width: 700px">
        <h6>1. Introduction, Description and Operation;</h6>
        <h6>2. Testing and Fault Isolation;</h6>
    </div>
    <div class="col-2 text-black text-center border
        border-dark pt-3"
         style="width: 100px">
        <h5>
            @if($training->form_type == 112 && $training->date_training == $earliestTrainingDate)
                {{ $training->manual->units_tr }}
            @else
                2
            @endif
        </h5>
    </div>
    <div class="col-1 text-black text-center border border-dark pt-3"
         style="width: 100px">
        <h5>{{__('V.N.')}}</h5>
    </div>
</div>


<div>
    <div class="row  ps-2 pe-2 mt-3">
        <div class="col-1 text-black border-start border-end border-top
        border-dark pt-4" style="width:
        100px"><h6><strong>Topic</strong></h6></div>
        <div class="col-8 text-black text-center border-end
        border-dark pt-4" style="width: 600px"><h5>
                <strong>{{ $training->manual->title }} {{'  '}}{{
                $training->manual->units_pn }} </strong></h5>
        </div>
        <div class="col-2 border-left border-dark"
             style="width: 100px">

        </div>
        <div class="col-1 "
             style="width: 100px">

        </div>
    </div>
    <div class="row ps-2 pe-2">
        <div class="col-9 text-black text-left border
        border-dark pt-1" style="width: 700px">
            <h6>3. Disassembly; </h6>
            <h6>4. Cleaning;</h6>
            <h6>5. Check;</h6>
        </div>
        <div class="col-2 text-black text-center border-bottom border-top
        border-dark pt-3"
             style="width: 100px">
            <h5>
                @if($training->form_type == 112 && $training->date_training == $earliestTrainingDate)
                    {{ $training->manual->units_tr }}
                @else
                    2
                @endif
            </h5>
        </div>
        <div class="col-1 text-black text-center border border-dark pt-3"
             style="width: 100px">
            <h5>{{__('V.N.')}}</h5>
        </div>
    </div>
</div>
<div>
    <div class="row  ps-2 pe-2 mt-3">
        <div class="col-1 text-black border-start border-end border-top
        border-dark pt-4" style="width:
        100px"><h6><strong>Topic</strong></h6></div>
        <div class="col-8 text-black text-center border-end
        border-dark pt-4" style="width: 600px"><h5>
                <strong>{{ $training->manual->title }} {{'  '}}{{
                $training->manual->units_pn }} </strong></h5>
        </div>
        <div class="col-2 border-left border-dark"
             style="width: 100px">

        </div>
        <div class="col-1 "
             style="width: 100px">

        </div>
    </div>
    <div class="row ps-2 pe-2">
        <div class="col-9 text-black text-left border
        border-dark pt-1" style="width: 700px">
            <h6>6. Fits and Clearance;</h6>
            <h6>7. Repair;</h6>
        </div>
        <div class="col-2 text-black text-center border-bottom border-top
        border-dark pt-3"
             style="width: 100px">
            <h5>
                @if($training->form_type == 112 && $training->date_training == $earliestTrainingDate)
                    {{ $training->manual->units_tr }}
                @else
                    2
                @endif
            </h5>
        </div>
        <div class="col-1 text-black text-center border border-dark pt-3"
             style="width: 100px">
            <h5>{{__('V.N.')}}</h5>
        </div>
    </div>
</div>
<div>
    <div class="row  ps-2 pe-2 mt-3">
        <div class="col-1 text-black border-start border-end border-top
        border-dark pt-4" style="width:
        100px"><h6><strong>Topic</strong></h6></div>
        <div class="col-8 text-black text-center border-end
        border-dark pt-4" style="width: 600px"><h5>
                <strong>{{ $training->manual->title }} {{'  '}}{{
                $training->manual->units_pn }} </strong></h5>
        </div>
        <div class="col-2 border-left border-dark"
             style="width: 100px">

        </div>
        <div class="col-1 "
             style="width: 100px">

        </div>
    </div>
    <div class="row ps-2 pe-2">
        <div class="col-9 text-black text-left border
        border-dark pt-1" style="width: 700px">
            <h6>8. Service Bulletins;</h6>
            <h6>9. Assembly;</h6>
        </div>
        <div class="col-2 text-black text-center border-bottom border-top
        border-dark pt-3"
             style="width: 100px">
            <h5>
                @if($training->form_type == 112 && $training->date_training == $earliestTrainingDate)
                    {{ $training->manual->units_tr }}
                @else
                    2
                @endif
            </h5>
        </div>
        <div class="col-1 text-black text-center border border-dark pt-3"
             style="width: 100px">
            <h5>{{__('V.N.')}}</h5>
        </div>
    </div>
</div>
<div>
    <div class="row  ps-2 pe-2 mt-3">
        <div class="col-1 text-black border-start border-end border-top
        border-dark pt-4" style="width:
        100px"><h6><strong>Topic</strong></h6></div>
        <div class="col-8 text-black text-center border-end
        border-dark pt-4" style="width: 600px"><h5>
                <strong>{{ $training->manual->title }} {{'  '}}{{
                $training->manual->units_pn }} </strong></h5>
        </div>
        <div class="col-2 border-left border-dark"
             style="width: 100px">

        </div>
        <div class="col-1 "
             style="width: 100px">

        </div>
    </div>
    <div class="row ps-2 pe-2">
        <div class="col-9 text-black text-left border
        border-dark pt-1" style="width: 700px">
            <h6>10. Special Tools, Fixtures and Equipment;</h6>
            <h6>11. Final Check.</h6>
        </div>
        <div class="col-2 text-black text-center border-bottom border-top
        border-dark pt-3"
             style="width: 100px">
            <h5>
                @if($training->form_type == 112 && $training->date_training == $earliestTrainingDate)
                    {{ $training->manual->units_tr }}
                @else
                    2
                @endif
            </h5>
        </div>
        <div class="col-1 text-black text-center border border-dark pt-3"
             style="width: 100px">
            <h5>{{__('V.N.')}}</h5>
        </div>
    </div>
</div>

*Please use another sheet if necessary.

<div class="row ps-2 pe-2 mt-4">
    <div class="col-9 text-black text-center border-bottom border-dark
    pt-3"></div>
    <div class="col-3  text-center border-bottom border-dark">
        <strong>{{ \Carbon\Carbon::parse($training->date_training)
    ->format('m-d-Y') }}</strong>
    </div>
    <div class="d-flex row justify-contend-between">
        <div class="col-8">
            Trainee signature
        </div>
        <div class="col-1">Date</div>

    </div>

</div>

<div class="row ps-2 pe-2 mt-4">
    <div class="col-9 text-black text-center border-bottom border-dark
    pt-3"></div>
    <div class="col-3  text-center border-bottom border-dark">
        <strong>{{ \Carbon\Carbon::parse($training->date_training)
    ->format('m-d-Y') }}</strong>
    </div>
    <div class="d-flex row justify-contend-between">
        <div class="col-8">
            Quality Assurance signature
        </div>
        <div class="col-1">Date</div>

    </div>

</div>
<div class="row  mt-3 border border-dark">
    <div class="col-12" style="height: 60px"></div>
</div>

<button class="btn btn-primary mt-5" onclick="window.print()">Print Form
</button>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</body>


</html>

