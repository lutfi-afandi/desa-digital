<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\SocialAssistanceRecipientResource;
use App\Interfaces\SocialAssistenceRecipientRepositoryInterface;
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
            return  ResponseHelper::jsonResponse(true, 'Data Penerima Bantuan Sosial berhasil diambil!', PaginateResource::make($socialAssistenceRecipients), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
