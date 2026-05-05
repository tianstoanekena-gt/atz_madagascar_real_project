<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::ordered()
            ->paginate(15);

        return view('admin.documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = ['mg' => 'Malagasy', 'fr' => 'Français', 'en' => 'English'];
        $fileTypes = [
            'pdf' => 'PDF',
            'word' => 'Word',
            'excel' => 'Excel',
            'powerpoint' => 'PowerPoint',
        ];

        return view('admin.documents.create', compact('languages', 'fileTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // Titres (au moins un requis)
            'title_fr' => 'nullable|string|max:255',
            'title_mg' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',

            // Descriptions
            'description_fr' => 'nullable|string|max:5000',
            'description_mg' => 'nullable|string|max:5000',
            'description_en' => 'nullable|string|max:5000',

            // Fichier (requis à la création)
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,odt,ods,odp|max:10240',

            // Statut
            'is_published' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ], [
            'title_fr.required' => 'Au moins un titre (FR, MG ou EN) est requis.',
            'file.required' => 'Le fichier est obligatoire.',
            'file.mimes' => 'Types de fichiers autorisés : PDF, Word, Excel, PowerPoint.',
            'file.max' => 'Le fichier ne doit pas dépasser 10 MB.',
        ]);

        // Vérifier qu'au moins un titre est fourni
        if (empty($request->title_fr) && empty($request->title_mg) && empty($request->title_en)) {
            return redirect()->back()
                ->withErrors(['title_fr' => 'Au moins un titre (FR, MG ou EN) est requis.'])
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Upload du fichier
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();

            // Générer un nom unique
            $fileName = 'doc_' . time() . '_' . uniqid() . '.' . $extension;
            $filePath = $file->storeAs('documents', $fileName, 'public');

            // Déterminer le type de fichier
            $fileType = $this->determineFileType($extension);

            // Créer le document
            Document::create([
                'title_fr' => $request->title_fr,
                'title_mg' => $request->title_mg,
                'title_en' => $request->title_en,
                'description_fr' => $request->description_fr,
                'description_mg' => $request->description_mg,
                'description_en' => $request->description_en,
                'file_path' => $filePath,
                'file_type' => $fileType,
                'file_size' => $fileSize,
                'file_original_name' => $originalName,
                'is_published' => $request->has('is_published'),
                'order' => $request->order ?? 0,
            ]);

            DB::commit();

            return redirect()->route('admin.documents.index')
                ->with('success', 'Document ajouté avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        return redirect()->route('admin.documents.edit', $document->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        $languages = ['mg' => 'Malagasy', 'fr' => 'Français', 'en' => 'English'];
        $fileTypes = [
            'pdf' => 'PDF',
            'word' => 'Word',
            'excel' => 'Excel',
            'powerpoint' => 'PowerPoint',
        ];

        return view('admin.documents.edit', compact('document', 'languages', 'fileTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            // Titres (au moins un requis)
            'title_fr' => 'nullable|string|max:255',
            'title_mg' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',

            // Descriptions
            'description_fr' => 'nullable|string|max:5000',
            'description_mg' => 'nullable|string|max:5000',
            'description_en' => 'nullable|string|max:5000',

            // Fichier (optionnel à la modification)
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,odt,ods,odp|max:10240',

            // Statut
            'is_published' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ], [
            'file.mimes' => 'Types de fichiers autorisés : PDF, Word, Excel, PowerPoint, ODT, ODS, ODP.',
            'file.max' => 'Le fichier ne doit pas dépasser 10 MB.',
        ]);

        // Vérifier qu'au moins un titre est fourni
        if (empty($request->title_fr) && empty($request->title_mg) && empty($request->title_en)) {
            return redirect()->back()
                ->withErrors(['title_fr' => 'Au moins un titre (FR, MG ou EN) est requis.'])
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $data = [
                'title_fr' => $request->title_fr,
                'title_mg' => $request->title_mg,
                'title_en' => $request->title_en,
                'description_fr' => $request->description_fr,
                'description_mg' => $request->description_mg,
                'description_en' => $request->description_en,
                'is_published' => $request->has('is_published'),
                'order' => $request->order ?? 0,
            ];

            // Nouveau fichier uploadé
            if ($request->hasFile('file')) {
                // Supprimer l'ancien fichier
                if (Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                }

                $file = $request->file('file');
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileSize = $file->getSize();

                $fileName = 'doc_' . time() . '_' . uniqid() . '.' . $extension;
                $filePath = $file->storeAs('documents', $fileName, 'public');
                $fileType = $this->determineFileType($extension);

                $data['file_path'] = $filePath;
                $data['file_type'] = $fileType;
                $data['file_size'] = $fileSize;
                $data['file_original_name'] = $originalName;
            }

            $document->update($data);

            DB::commit();

            return redirect()->route('admin.documents.index')
                ->with('success', 'Document mis à jour avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        DB::beginTransaction();
        try {
            // Supprimer le fichier physique
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $document->delete();

            DB::commit();

            return redirect()->route('admin.documents.index')
                ->with('success', 'Document supprimé avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()]);
        }
    }

    private function determineFileType($extension)
    {
        $extension = strtolower($extension);

        return match ($extension) {
            'pdf' => 'pdf',
            'doc', 'docx', 'odt' => 'word',
            'xls', 'xlsx', 'ods' => 'excel',
            'ppt', 'pptx', 'odp' => 'powerpoint',
            default => 'pdf',
        };
    }
}
