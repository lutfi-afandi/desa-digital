<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\FamiliMemberStoreRequest;
use App\Http\Requests\FamiliMemberUpdateRequest;
use App\Http\Resources\FamilyMemberResource;
use App\Interfaces\FamilyMemberRepositoryInterface;
use Illuminate\Http\Request;

class FamilyMemberController extends Controller
{

    private FamilyMemberRepositoryInterface $familyMemberRepository;

    public function __construct(FamilyMemberRepositoryInterface $familyMemberRepository)
    {
        $this->familyMemberRepository = $familyMemberRepository;
    }

    public function index(Request $request)
    {

        try {
            $familyMembers = $this->familyMemberRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data Anggota keluarga berhasil diambil!', FamilyMemberResource::collection($familyMembers), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $request = $request->validate([
            'search' => 'nullable|string',
            'row_per_page' => 'required'
        ]);

        try {
            $familyMembers = $this->familyMemberRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );

            return ResponseHelper::jsonResponse(true, 'Data Anggota keluarga berhasil diambil!', FamilyMemberResource::collection($familyMembers), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(FamiliMemberStoreRequest $request)
    {
        $request = $request->validated();

        try {
            $familyMember = $this->familyMemberRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Data Anggota keluarga berhasil ditambahkan', new FamilyMemberResource($familyMember), 201);
        } catch (\Exception $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $familyMember = $this->familyMemberRepository->getById(
                $id
            );

            if (!$familyMember) {
                return ResponseHelper::jsonResponse(false, 'anggota keluarga tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Detail anggota keluarga berhasil diambil', new FamilyMemberResource($familyMember), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FamiliMemberUpdateRequest $request, string $id)
    {
        $request = $request->validated();

        try {
            $familyMember = $this->familyMemberRepository->getById(
                $id
            );

            if (!$familyMember) {
                return ResponseHelper::jsonResponse(false, 'Anggota Keluarga Tidak Ditemukan', null, 404);
            }

            $familyMember = $this->familyMemberRepository->update(
                $id,
                $request
            );

            return ResponseHelper::jsonResponse(true, 'Anggota keluarga berhasil diupdate', new FamilyMemberResource($familyMember), 201);
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
            $familyMember = $this->familyMemberRepository->getById(
                $id
            );

            if (!$familyMember) {
                return ResponseHelper::jsonResponse(false, 'Anggota Keluarga Tidak Ditemukan', null, 404);
            }

            $familyMember = $this->familyMemberRepository->delete($id);


            return ResponseHelper::jsonResponse(true, 'Anggota keluarga berhasil dihapus', null, 201);
        } catch (\Exception $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }
}
