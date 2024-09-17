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
        <p><strong>Unit:</strong> {{ $training->cmm->title }}</p>
        <p><strong>Training Date:</strong> {{ $training->training_end_date }}</p>
        <p><strong>Duration:</strong> {{ $training->cmm->units_tr }} hours (or 2 hours for subsequent trainings)</p>
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

