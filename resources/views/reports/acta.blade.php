<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 1cm; }
        body { font-family: sans-serif; font-size: 9px; }
        .header-table { width: 100%; border: none; }
        .title { text-align: center; font-size: 14px; font-weight: bold; margin: 10px 0; }
        .info-table { width: 100%; margin-bottom: 10px; border-collapse: collapse; }
        .info-table td { border: 1px solid #ccc; padding: 3px; }

        .main-table { width: 100%; border-collapse: collapse; }
        .main-table th, .main-table td { border: 1px solid black; padding: 4px; text-align: center; }
        .text-left { text-align: left !important; }
        .bg-gray { background-color: #f2f2f2; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td width="20%"><img src="{{ $logoMinedu }}" width="100"></td>
            <td class="title">ACTA DE EVALUACIÓN FINAL - PROMOCIÓN {{ $section->academicPeriod->name }}</td>
            <td width="20%" style="text-align: right;"><img src="{{ $logoInsti }}" width="50"></td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td class="bg-gray font-bold">PROGRAMA DE ESTUDIOS:</td>
            <td>{{ $section->course->studyPlan->studyProgram->name ?? 'N/A' }}</td>
            <td class="bg-gray font-bold">CURSO / MÓDULO:</td>
            <td>{{ $section->course->name }}</td>
        </tr>
        <tr>
            <td class="bg-gray font-bold">DOCENTE:</td>
            <td>{{ $section->teacher->full_name }}</td>
            <td class="bg-gray font-bold">NRO. ACTA:</td>
            <td>{{ $section->acta_number }}</td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr class="bg-gray">
                <th width="30">Nº</th>
                <th>APELLIDOS Y NOMBRES</th>
                <th width="60">DNI</th>
                @foreach($section->course->competencies as $comp)
                    <th width="40">{{ $comp->code }}</th>
                @endforeach
                <th width="50" class="font-bold">PROMEDIO</th>
                <th width="100">LETRAS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="text-left uppercase">{{ $student['name'] }}</td>
                <td>{{ $student['dni'] }}</td>

                @php $sum = 0; $count = 0; @endphp
                @foreach($section->course->competencies as $comp)
                    @php
                        $grade = $student['grades'][$comp->id] ?? null;
                        if($grade) { $sum += $grade; $count++; }
                    @endphp
                    <td>{{ $grade ?? '-' }}</td>
                @endforeach

                <td class="font-bold bg-gray">{{ number_format($student['final_score'], 0) }}</td>
                <td class="font-bold uppercase">{{ $numberHelper::noteToWords($student['final_score']) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: center;">
        <div style="display: inline-block; width: 250px; border-top: 1px solid black; margin: 0 40px;">
            <p>FIRMA DEL DOCENTE</p>
        </div>
        <div style="display: inline-block; width: 250px; border-top: 1px solid black; margin: 0 40px;">
            <p>SECRETARÍA ACADÉMICA</p>
        </div>
    </div>
</body>
</html>
