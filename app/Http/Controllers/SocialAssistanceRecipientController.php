<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\SocialAssistanceRecipientStoreRequest;
use App\Http\Requests\SocialAssistanceRecipientUpdateRequest;
use App\Http\Requests\SocialAssistanceStoreRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\SocialAssistanceRecipientResource;
use App\Interfaces\SocialAssistenceRecipientRepositoryInterface;
use App\Models\SocialAssistanceRecepient;
use App\Repositories\SocialAssistenceRepository;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class SocialAssistanceRecipientController extends Controller
{
    private SocialAssistenceRecipientRepositoryInterface $socialAssistenceRecipientRepository;

    public function __construct(
        SocialAssistenceRecipientRepositoryInterface $socialAssistenceRecipientRepository
    ) {
        $this->socialAssistenceRecipientRepository = $socialAssistenceRecipientRepository;
    }

    public function index(Request $request)
    {
        try {
            $socialAssistenceRecipientRepository = $this->socialAssistenceRecipientRepository->getAll(
                $request->search,
                $request->limit,
                true
            );
            return  ResponseHelper::jsonResponse(true, 'Data Penerima Bantuan Sosial berhasil diambil!', $socialAssistenceRecipientRepository, 200);
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
            $socialAssistenceRecipients = $this->socialAssistenceRecipientRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );
            return  ResponseHelper::jsonResponse(true, 'Data Penerima Bantuan Sosial berhasil diambil!', PaginateResource::make($socialAssistenceRecipients, SocialAssistanceRecipientResource::class), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(SocialAssistanceRecipientStoreRequest $request)
    {
        $request = $request->validated();

        try {
            $socialAssistenceRecipient = $this->socialAssistenceRecipientRepository->create(
                $request
            );

            return ResponseHelper::jsonResponse(true, 'Penerima Bantuan Sosial berhasil dibuat!', new SocialAssistanceRecipientResource($socialAssistenceRecipient), 200);
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
            $socialAssistenceRecipient = $this->socialAssistenceRecipientRepository->getById(
                $id
            );

            if (!$socialAssistenceRecipient) {
                return ResponseHelper::jsonResponse(false, 'Data Penerima Bantuan Sosial tidak ditemukan!', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data Penerima Bantuan Sosial berhasil diambil!', $socialAssistenceRecipient, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SocialAssistanceRecipientUpdateRequest $request, string $id)
    {
        $request = $request->validated();

        try {
            $socialAssistanceRecipient = $this->socialAssistenceRecipientRepository->getById(
                $id
            );

            if (!$socialAssistanceRecipient) {
                return ResponseHelper::jsonResponse(false, 'Bantuan Sosial Tidak Ditemukan', null, 404);
            }

            $socialAssistanceRecipient = $this->socialAssistenceRecipientRepository->update(
                $id,
                $request
            );

            return ResponseHelper::jsonResponse(true, 'Bantuan Sosial berhasil diupdate', new SocialAssistanceRecipientResource($socialAssistanceRecipient), 201);
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
            $socialAssistanceRecipient = $this->socialAssistenceRecipientRepository->getById(
                $id
            );

            if (!$socialAssistanceRecipient) {
                return ResponseHelper::jsonResponse(false, 'Penerima Bantuan Sosial Tidak Ditemukan', null, 404);
            }

            $this->socialAssistenceRecipientRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Penerima Bantuan Sosial berhasil dihapus', null, 200);
        } catch (\Exception $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }
}
