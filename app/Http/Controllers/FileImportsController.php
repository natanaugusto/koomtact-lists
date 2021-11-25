<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessFileImports;
use App\Models\Contact;
use App\Models\FileImport;
use App\Models\User;
use App\Services\FileImportsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class FileImportsController extends Controller
{
    /**
     * @var FileImportsService
     */
    protected FileImportsService $service;

    /**
     * Store the uploaded file and save a register on `file_imports`
     * @param Request $request
     * @return RedirectResponse
     */
    public function import(Request $request): RedirectResponse
    {
        $file = $this->getService(
            $request->user()
        )->create($request->file('file'));
        return response()->redirectTo(route(
            'file.from-to',
            ['hash' => $file->hash->toString()]
        ));
    }

    /**
     * @param Request $request
     * @param string $hash
     * @return View
     */
    public function fromTo(Request $request, string $hash): View
    {
        $fromTo = $this->getService(
            $request->user()
        )->getFromToColumns(Contact::class, $hash);
        return view('from-to-form', array_merge($fromTo, ['hash' => $hash]));
    }

    /**
     * @param Request $request
     * @param string $hash
     * @return Response
     */
    public function storeFromTo(Request $request, string $hash): Response
    {
        $fileImport = $this->getService($request->user())->getHandlerByHash($hash, true);
        $fileImport->from_to = $request->all();
        $fileImport->save();
        ProcessFileImports::dispatch($fileImport);
        return response(null, SymfonyResponse::HTTP_CREATED);
    }

    /**
     * @param User $user
     * @return FileImportsService
     */
    protected function getService(User $user): FileImportsService
    {
        if (empty($this->service)) {
            $this->service = new FileImportsService($user);
        }
        return $this->service;
    }
}
