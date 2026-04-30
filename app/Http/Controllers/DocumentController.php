<?php

namespace App\Http\Controllers;

use App\Models\Document;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the documents (frontend).
     */
    public function index()
    {
        // Récupérer les documents publiés, triés par ordre
        $documents = Document::published()
            ->ordered()
            ->get();

        // Calculer les statistiques pour l'affichage
        $stats = [
            'pdf' => Document::published()->ofType('pdf')->count(),
            'word' => Document::published()->ofType('word')->count(),
            'excel' => Document::published()->ofType('excel')->count(),
            'powerpoint' => Document::published()->ofType('powerpoint')->count(),
        ];

        return view('pages.documents', compact('documents', 'stats'));
    }

    /**
     * Handle document download with tracking.
     */
    public function download(Document $document)
    {

        dd('CONTROLLER HIT!', [
            'id' => $document->id,
            'title' => $document->title,
            'file_path' => $document->file_path,
            'is_published' => $document->is_published,
        ]);
    }

    /**
     * Get MIME type based on file type.
     */
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
