<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\DevelopmenApplicantStoreRequest;
use App\Http\Requests\DevelopmenApplicantUpdateRequest;
use App\Http\Resources\DevelopmentApplicantResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\DevelopmentApplicantRepositoryInterface;
use Illuminate\Http\Request;

class DevelopmentApplicantController extends Controller
{
    private DevelopmentApplicantRepositoryInterface $developmentApplicantRepository;

    public function __construct(DevelopmentApplicantRepositoryInterface $developmentApplicantRepository)
    {
        $this->developmentApplicantRepository = $developmentApplicantRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $developmentApplicants = $this->developmentApplicantRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return  ResponseHelper::jsonResponse(true, 'Data Pendaftar pembangunan berhasil diambil!', $developmentApplicants, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $request->validate([
            'row_per_page' => 'required|integer',
            'seacrh' => 'nullable|string',
        ]);

        try {
            $developmentApplicants = $this->developmentApplicantRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );
            return  ResponseHelper::jsonResponse(true, 'Data Pendaftar pembangunan berhasil diambil!', PaginateResource::make($developmentApplicants, DevelopmentApplicantResource::class), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(DevelopmenApplicantStoreRequest $request)
    {
        $request = $request->validated();

        try {
            $developmentApplicant = $this->developmentApplicantRepository->create(
                $request
            );

            return ResponseHelper::jsonResponse(true, 'Data Pendaftar Pembangunan berhasil dibuat!', new DevelopmentApplicantResource($developmentApplicant), 200);
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
            $developmentApplicant = $this->developmentApplicantRepository->getById(
                $id
            );

            if (!$developmentApplicant) {
                return ResponseHelper::jsonResponse(false, 'Data Pendfatar Pembangunan tidak ditemukan!', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data Pendfatar Pembangunan berhasil diambil!', $developmentApplicant, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DevelopmenApplicantUpdateRequest $request, string $id)
    {
        $request = $request->validated();

        try {
            $developmentApplicant = $this->developmentApplicantRepository->getById(
                $id
            );

            if (!$developmentApplicant) {
                return ResponseHelper::jsonResponse(false, 'Data Pendfatar  Pembangunan tidak ditemukan!', null, 404);
            }

            $developmentApplicant = $this->developmentApplicantRepository->update(
                $id,
                $request
            );

            return ResponseHelper::jsonResponse(true, 'Data Pembengunan berhasil diupdate!', new DevelopmentApplicantResource($developmentApplicant), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $developmentApplicant = $this->developmentApplicantRepository->getById(
                $id
            );

            if (!$developmentApplicant) {
                return ResponseHelper::jsonResponse(false, 'Data Pendaftar Pembangunan tidak ditemukan!', null, 404);
            }

            $this->developmentApplicantRepository->delete(
                $id
            );

            return ResponseHelper::jsonResponse(true, 'Data Pendaftar Pembengunan berhasil dihapus!', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
