<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\FileImport;
use App\Services\FileImportsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FileImportsController extends Controller
{
    /**
     * @var FileImportsService
     */
    protected FileImportsService $service;

    public function __construct(Request $request)
    {
        $this->service = new FileImportsService($request->user());
    }

    /**
     * Store the uploaded file and save a register on `file_imports`
     * @param Request $request
     * @return RedirectResponse
     */
    public function import(Request $request): RedirectResponse
    {
        $file = $this->service->create($request->file('file'));
        return response()->redirectTo(route(
            'file.from-to',
            ['hash' => $file->hash->toString()]
        ));
    }

    public function fromTo(Request $request, string $hash)
    {
        $fromTo = $this->service->getFromToColumns($hash, Contact::class);
        return response()->json($fromTo);
    }
}
