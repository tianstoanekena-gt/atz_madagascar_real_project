<?php

namespace App\Http\Controllers;

use App\Models\Document;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{

    public function index()
    {
        $documents = Document::published()
            ->ordered()
            ->get();

        $stats = [
            'pdf' => Document::published()->ofType('pdf')->count(),
            'word' => Document::published()->ofType('word')->count(),
            'excel' => Document::published()->ofType('excel')->count(),
            'powerpoint' => Document::published()->ofType('powerpoint')->count(),
        ];

        return view('pages.documents', compact('documents', 'stats'));
    }


    public function download($locale, Document $document)
    {
        // Vérifier que le document est publié
        if (!$document->is_published) {
            abort(404);
        }

        // Vérifier que le fichier existe
        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404);
        }

        // Incrémenter les compteurs
        $document->incrementViewCount();
        $document->incrementDownloadCount();

        // Télécharger le fichier avec les bons headers
        return Storage::disk('public')->download(
            $document->file_path,
            $document->file_original_name,
            [
                'Content-Type' => $this->getMimeType($document->file_type),
            ]
        );
    }




    private function getMimeType($fileType)
    {
        return match ($fileType) {
            'pdf' => 'application/pdf',
            'word' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'excel' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'powerpoint' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            default => 'application/octet-stream',
        };
    }
}
