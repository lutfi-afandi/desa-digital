<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\SocialAssistanceStoreRequest;
use App\Http\Requests\SocialAssistanceUpdateRequest;
use App\Http\Resources\SocialAssistanceResource;
use App\Interfaces\SocialAssistenceRepositoryInterface;
use App\Models\SocialAssistance;
use App\Repositories\SocialAssistenceRepository;
use Illuminate\Http\Request;

class SocialAssistanceController extends Controller
{
    private SocialAssistenceRepositoryInterface $socialAssistenceRepository;

    public function __construct(
        SocialAssistenceRepositoryInterface $socialAssistenceRepository
    ) {
        $this->socialAssistenceRepository = $socialAssistenceRepository;
    }

    public function index(Request $request)
    {
        try {
            $socialAssistances = $this->socialAssistenceRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data Bantuan Sosial berhasil diambil!', SocialAssistanceResource::collection($socialAssistances), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        try {
            $socialAssistances = $this->socialAssistenceRepository->getAllPaginated(
                $request['search'],
                $request['row_per_page']
            );

            return ResponseHelper::jsonResponse(true, 'Data Bantuan Sosial berhasil diambil!', SocialAssistanceResource::collection($socialAssistances), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SocialAssistanceStoreRequest $request)
    {

        $request = $request->validated();

        try {
            $socialAssistance = $this->socialAssistenceRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Data Bantuan Sosial berhasil ditambahkan!', new SocialAssistanceResource($socialAssistance), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $socialAssistance = $this->socialAssistenceRepository->getById($id);

            if (!$socialAssistance) {
                return ResponseHelper::jsonResponse(false, 'Data Bantuan Sosial tidak ditemukan!', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data Bantuan Sosial berhasil diambil!', new SocialAssistanceResource($socialAssistance), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SocialAssistanceUpdateRequest $request, string $id)
    {
        $request = $request->validated();

        try {
            $socialAssistance = $this->socialAssistenceRepository->getById(
                $id
            );

            if (!$socialAssistance) {
                return ResponseHelper::jsonResponse(false, 'Bantuan Sosial Tidak Ditemukan', null, 404);
            }

            $socialAssistance = $this->socialAssistenceRepository->update(
                $id,
                $request
            );

            return ResponseHelper::jsonResponse(true, 'Bantuan Sosial berhasil diupdate', new SocialAssistenceRepository($socialAssistance), 201);
        } catch (\Exception $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $socialAssistance = $this->socialAssistenceRepository->getById(
                $id
            );

            if (!$socialAssistance) {
                return ResponseHelper::jsonResponse(false, 'Bantuan Sosial Tidak Ditemukan', null, 404);
            }

            $socialAssistance = $this->socialAssistenceRepository->delete($id);


            return ResponseHelper::jsonResponse(true, 'Bantuan Sosial berhasil dihapus', null, 201);
        } catch (\Exception $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }
}
