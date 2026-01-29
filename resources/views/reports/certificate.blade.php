<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Certificado Oficial - {{ $person->dni }}</title>
    <style>
        @page { margin: 2cm; }
        body { font-family: 'Helvetica', sans-serif; line-height: 1.4; color: #333; }

        /* Encabezado con Logos */
        .header-table { width: 100%; border: none; margin-bottom: 10px; }
        .logo { width: 80px; }
        .header-text { text-align: center; font-size: 14px; font-weight: bold; }

        .main-title { text-align: center; text-decoration: underline; font-size: 16px; margin-top: 20px; margin-bottom: 20px; }

        .institution-name { text-align: center; font-weight: bold; font-size: 14px; margin-bottom: 5px; }
        .certifies-text { text-align: center; font-size: 18px; font-weight: bold; letter-spacing: 5px; margin: 20px 0; }

        .intro-body { text-align: justify; font-size: 13px; margin-bottom: 20px; }

        /* Tabla de Notas Estilo MINEDU */
        .notes-table { width: 100%; border-collapse: collapse; font-size: 11px; }
        .notes-table th, .notes-table td { border: 1px solid #000; padding: 4px 6px; }
        .notes-table th { background-color: #f2f2f2; text-align: center; font-weight: bold; }

        .bg-grey { background-color: #f9f9f9; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }

        /* Firmas y Fecha */
        .date-container { text-align: right; margin-top: 40px; font-size: 13px; }

        .signature-container { width: 100%; margin-top: 80px; }
        .signature-box { width: 45%; text-align: center; display: inline-block; vertical-align: top; }
        .line { border-top: 1px solid #000; width: 80%; margin: 0 auto 5px auto; }
        .post-firma { font-size: 10px; line-height: 1.2; }
    </style>
</head>
<body>

    <!-- Encabezado -->
    <table class="header-table" style="vertical-align: middle;">
        <tr>
            <td style="width: 25%; text-align: left; vertical-align: middle;">
                @if($logoMinedu)
                    <img src="{{ $logoMinedu }}" width="110">
                @endif
            </td>
            <td style="width: 50%; text-align: center; vertical-align: middle;">
                <div style="font-size: 14px; font-weight: bold; line-height: 1.2;">
                    CERTIFICADO DE ESTUDIOS DE EDUCACIÓN SUPERIOR PEDAGÓGICA
                </div>
            </td>
            <td style="width: 25%; text-align: right; vertical-align: middle;">
                @if($logoInsti)
                    <img src="{{ $logoInsti }}" width="65">
                @endif
            </td>
        </tr>
    </table>

    <div class="institution-name">
        Instituto de Educación Superior Pedagógico Público<br>
        "HNO. VICTORINO ELORZ GOICOECHEA" - CAJAMARCA
    </div>

    <p style="font-size: 13px; margin-bottom: 0;">El que suscribe:</p>
    <div class="certifies-text">CERTIFICA</div>

    <div class="intro-body">
        Que Don (ña): <strong class="uppercase">{{ $person->last_name_p }} {{ $person->last_name_m }}, {{ $person->names }}</strong><br>
        Ha cursado las asignaturas correspondientes a la Especialidad de:<br>
        <strong>EDUCACIÓN SECUNDARIA, ESPECIALIDAD MATEMÁTICA (RVM 143-2020-MINEDU)</strong><br>
        Siendo el resultado final de las evaluaciones el siguiente:
    </div>

    <!-- Tabla de Notas -->
    <table class="notes-table">
        <thead>
            <tr>
                <th rowspan="2" width="5%">CICLO</th>
                <th rowspan="2">ASIGNATURAS / UNIDADES DIDÁCTICAS</th>
                <th colspan="2">CALIFICATIVOS</th>
                <th rowspan="2" width="7%">CRÉD.</th>
                <th rowspan="2" width="7%">PUNTAJE</th>
                <th rowspan="2" width="12%">FECHA EVAL.</th>
            </tr>
            <tr>
                <th width="8%">NÚMEROS</th>
                <th width="20%">LETRAS</th>
            </tr>
        </thead>
        <tbody>
            @php $totalPuntaje = 0; $totalCreditos = 0; @endphp
            @foreach($history as $item)
            <tr>
                <td class="text-center">{{ $item->cycle }}</td>
                <td>{{ $item->course_name }}</td>
                <td class="text-center font-bold">{{ number_format($item->grade, 0) }}</td>
                <td class="uppercase" style="font-size: 9px;">{{ $numberHelper::noteToWords($item->grade) }}</td>
                <td class="text-center">{{ $item->credits }}</td>
                <td class="text-center">{{ number_format($item->grade * $item->credits, 2) }}</td>
                <td class="text-center" style="font-size: 9px;">{{ $item->period_name }}</td>
            </tr>
            @php
                $totalPuntaje += ($item->grade * $item->credits);
                $totalCreditos += $item->credits;
            @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-grey font-bold">
                <td colspan="4" class="text-center text-uppercase">Promedio Ponderado Final</td>
                <td class="text-center">{{ $totalCreditos }}</td>
                <td class="text-center">{{ number_format($totalPuntaje, 2) }}</td>
                <td class="text-center font-bold">
                    {{ $totalCreditos > 0 ? number_format($totalPuntaje / $totalCreditos, 2) : '0.00' }}
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- Fecha -->
    <div class="date-container">
        Cajamarca, {{ date('d') }} de {{ \Carbon\Carbon::now()->translatedFormat('F') }} de {{ date('Y') }}
    </div>

    <!-- Firmas -->
    <div class="signature-container">
        <div class="signature-box">
            <div class="line"></div>
            <strong>FERNANDO MARTÍN VERGARA ABANTO</strong><br>
            <span class="post-firma uppercase text-center">Director General<br>Firma, Post firma y Sello</span>
        </div>
        <div class="signature-box" style="float: right;">
            <div class="line"></div>
            <strong>SEGUNDO MARIO ROMERO LUNA</strong><br>
            <span class="post-firma uppercase text-center">Secretario Académico<br>Firma, Post firma y Sello</span>
        </div>
    </div>

</body>
</html>
