<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use App\Models\Person;
use App\Helpers\NumberHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    // En ReportController.php

    public function downloadCertificate($personId)
    {
        $person = Person::findOrFail($personId);
        $history = $this->reportService->getConsolidatedHistory($personId);

        // FUNCIÓN PARA OPTIMIZAR IMÁGENES
        $logoMinedu = $this->convertImageToBase64(public_path('img/logo-minedu.png'));
        $logoInsti = $this->convertImageToBase64(public_path('img/logo-instituto.png'));

        $pdf = Pdf::loadView('reports.certificate', [
            'person' => $person,
            'history' => $history,
            'numberHelper' => new NumberHelper(),
            'logoMinedu' => $logoMinedu, // Pasamos la imagen ya convertida
            'logoInsti' => $logoInsti
        ]);

        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream("Certificado_{$person->dni}.pdf");
    }

    // Helper interno para la conversión
    private function convertImageToBase64($path)
    {
        if (!file_exists($path)) return null;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}
