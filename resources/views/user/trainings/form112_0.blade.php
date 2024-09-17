<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form 112</title>
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
                font-size: 14pt;
                color: #000;
                background-color: #fff;
                margin: 0;
                padding: 0;
            }

            /* Скрываем элементы, не нужные для печати */
            .no-print {
                display: none;
            }

            /* Оптимизируем отображение таблиц */
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                border: 1px solid black;
                padding: 8px;
                text-align: left;
            }

            /* Убираем прокрутку, если есть */
            html, body {
                overflow: visible;
            }
        }



        body {
            font-family: Arial, sans-serif;
            margin: 4px;
            /*border: 1px solid #000;*/

            
        }
        /*.form-section {*/
        /*    margin-bottom: 20px;*/
        /*}*/
        /*.form-section h3 {*/
        /*    margin-bottom: 10px;*/
        /*}*/
        /*.container {*/
        /*    border: 1px solid #000;*/
        /*    padding: 10px;*/
        /*}*/
        /*.form-section {*/
        /*    border: 1px solid #000;*/
        /*    padding: 10px;*/
        /*}*/
        .card {
            align-content: center;

        }
        /*.card-title {*/
        /*    border: 1px solid #000;*/
        /*    width: 400px;*/
        /*    text-align: center;*/
        /*    margin-top: 6px;*/
        /*    margin-left: 200px;*/

        /*}*/
        .nowrap-cell {
            white-space: nowrap;
            padding: 0 5.4pt;
            height: 39pt;
        }

        .center-cell {
            text-align: center;
            background-color: white;
            padding: 0 5.4pt;
            font-size: 18pt;
            font-family: "Times New Roman", serif;
            color: black;
        }

        .label-cell {
            padding: 0 5.4pt;
            font-size: 14pt;
            font-family: "Times New Roman", serif;
        }

        .value-cell {
            text-align: center;
            background-color: #F8F9FA;
            padding: 0 5.4pt;
            font-size: 14pt;
            font-family: "Times New Roman", serif;
            color: black;
        }

        .dash-cell {
            text-align: center;
            font-size: 14pt;
        }

        .empty-cell {
            /*padding: 0 5.4pt;*/
        }

        .row-large {
            height: 39pt;
        }

        .row-medium {
            height: 20.25pt;
        }

        .row-small {
            height: 12.75pt;
        }
        .table-row {
            height: 11.1pt;
        }

        .table-cell {
            padding: 0in 5.4pt;
            font-family: "Times New Roman", serif;
        }

        .nowrap {
            white-space: nowrap;
        }

        .top-align {
            vertical-align: top;
        }

        .bottom-align {
            vertical-align: bottom;
        }

        .center-align {
            text-align: center;
        }

        .border-bottom {
            border-bottom: solid windowtext 1.0pt;
        }

        .empty-space {
            font-size: 14.0pt;
            font-style: italic;
        }

        .placeholder {
            font-size: 12.0pt;
        }

        .title {
            font-size: 14.0pt;
        }

        .small-text {
            font-size: 12.0pt;
        }
        .short-height {
            height: 11.25pt;
        }

        .medium-height {
            height: 24pt;
        }

        .tall-row {
            height: 52.45pt;
        }

        .hrs-topic, .trainer-initials, .hrs, .trainer-signature {
            text-align: center;
            border: solid windowtext 1pt;
        }

        .topic-title, .pn, .desc {
            border: solid windowtext 1pt;
            padding: 0 5.4pt;
        }

        .description {
            padding: 0 5.4pt;
        }
    </style>
</head>
<body >
<div class="">
    <div class="">
        <div class="card-header">
             <img src="{{asset('image/AT_logo-rb.svg')}}" alt="Logo"
                  style="width: 150px; margin-top: 6px; margin-left: 10px">
        </div>
        <div class="card-title ">
            <h2 >On The Job Training Record</h2>
        </div>

{{--        <div class="d-flex justify-content-between">--}}

{{--            <h3 style="margin-left: 10px">For the Week of:</h3>--}}
{{--            1/1/2021 - 1/2/2021--}}

{{--        </div>--}}
        <div class="card-body ">

        <table>
{{--            <tr class="row-large">--}}
{{--                <td class="nowrap-cell" colspan="3"></td>--}}
{{--                <td class="center-cell " colspan="8">On The Job--}}
{{--                    Training Record</td>--}}
{{--                <td class="nowrap-cell " colspan="3"></td>--}}
{{--            </tr>--}}
            <tr class="row-medium ">
                <td class="label-cell border-bottom" colspan="1">For the Week
                    of:</td>
                <td class="value-cell border-bottom" colspan="5"
                    align="right">{{ \Carbon\Carbon::parse ($training->date_training)->subDays(4)->format('m-d-Y') }}</td>
                <td class="dash-cell border-bottom">-</td>
                <td class="value-cell border-bottom" colspan="4">{{
                \Carbon\Carbon::parse($training->date_training)->format('m-d-Y') }}</td>
                <td class="empty-cell border-bottom" colspan="4"></td>
            </tr>
            <tr class="row-small">
                <td colspan="14"></td>
            </tr>
            <tr class="row-medium">
                <td class="label-cell " colspan="4">Trainee (Please print
                    name):</td>
                <td class="center-cell border-bottom" colspan="8">{{ $training->user->name }}</td>
                <td class="empty-cell border-bottom" colspan="2"></td>
            </tr>
            <tr class="short-height">
                <td colspan="12"></td>
                <td rowspan="2" class="hrs-topic"><b>Hrs on Topic</b></td>
                <td rowspan="2" class="trainer-initials"><b>Trainers Initials</b></td>
            </tr>
            <tr class="medium-height">
                <td class="topic-title"><b>Topic</b></td>
                <td colspan="5" class="desc">{{ $training->manual->title }}</td>
                <td colspan="6" class="pn">{{ $training->manual->units_pn
                }}</td>
            </tr>
            <tr class="tall-row">
                <td colspan="12" class="description">
                    1. Introduction, Description and Operation; 2. Testing and Fault Isolation;
                </td>
                <td class="hrs">&amp;h</td>
                <td class="trainer-signature"><b>V.N.</b></td>
            </tr>



            <!-- Repeat similar structure for the following rows -->
            <tr class="table-row">
                <td colspan="2" class="table-cell nowrap top-align">
                    <p><sup><span class="title">Trainee signature</span></sup></p>
                </td>
                <td colspan="5" class="table-cell bottom-align"></td>
                <td colspan="2" class="table-cell nowrap top-align">
                    <p><sup><span class="small-text">Date</span></sup></p>
                </td>
            </tr>

            <tr class="table-row" style="height: 43.7pt;">
                <td colspan="10" class="table-cell border-bottom bottom-align"></td>
                <td colspan="4" class="table-cell border-bottom center-align">
                    <p class="placeholder">&amp;En</p>
                </td>
            </tr>

            <tr class="table-row" style="height: 17.2pt;">
                <td colspan="4" class="table-cell nowrap top-align">
                    <p><sup><span class="small-text">Quality Assurance signature</span></sup></p>
                </td>
                <td colspan="5" class="table-cell bottom-align"></td>
                <td colspan="2" class="table-cell nowrap top-align">
                    <p><sup><span class="small-text">Date</span></sup></p>
                </td>
            </tr>

            <tr class="table-row" style="height: 14.2pt;">
                <td colspan="14" class="table-cell bottom-align"></td>
            </tr>

            <tr class="table-row" style="height: 46.55pt;">
                <td colspan="14" class="table-cell border-bottom center-align">
                    <p class="empty-space">&nbsp;</p>
                </td>
            </tr>



        </table>



            <h3>User Information</h3>



            <div class="">
                <p><strong>Name:</strong> {{ $training->user->name }}</p>
                <p><strong>Unit:</strong> {{ $training->manual->title }}</p>
                <p><strong>Unit:</strong> {{ $training->manual->units_pn }}</p>
                <p><strong>Training Date:</strong> {{ \Carbon\Carbon::parse($training->date_training)->format('m-d-Y') }}</p>

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


<button class="btn btn-primary" onclick="window.print()">Print Form</button>
</body>
</html>

