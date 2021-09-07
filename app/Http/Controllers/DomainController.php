<?php

namespace App\Http\Controllers;

use App\Http\Helpers\JsonFormatHelper;
use App\Http\Middleware\SessionProvider;
use App\Service\Domain\DomainService;
use App\Service\Session\SessionValidator;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DomainController extends Controller
{
    private DomainService $domainService;


    public function __construct(DomainService $domainService){
$this->domainService = $domainService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $domains = $this->domainService->getAll();

        return \Response::json($domains);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        return \Response::json(
            $this->domainService->create(
                $request->get('name')
            )
        );
    }


    /**
     * Display the specified resource.
     *
     * @param string $name
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $domain = $this->domainService->getById($id);

        if($domain) {
            return \Response::json( $domain );
        }
        else {
            return \Response::json( "none" );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return bool
     */
    public function update(int $id)
    {
        return $this->domainService->activate($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {
        return $this->domainService->deactivate($id);
    }
}
