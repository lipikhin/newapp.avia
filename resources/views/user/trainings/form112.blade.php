<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form 112</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .form-section {
            margin-bottom: 20px;
        }
        .form-section h3 {
            margin-bottom: 10px;
        }
        .form-content {
            border: 1px solid #000;
            padding: 10px;
        }
    </style>
</head>
<body>
<h1>Form 112</h1>
<div class="form-section">
    <h3>User Information</h3>
    <div class="form-content">
        <p><strong>Name:</strong> {{ $training->user->name }}</p>
        <p><strong>Unit:</strong> {{ $training->manual->title }}</p>
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

<button onclick="window.print()">Print Form</button>
</body>
</html>

