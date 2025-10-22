<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\EventParticipantStoreRequest;
use App\Http\Requests\EventParticipantUpdateRequest;
use App\Http\Resources\EventParticipantResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\EventParticipantRepositoryInterface;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Repositories\EventParticipantRepository;
use Illuminate\Http\Request;

class EventParticipantController extends Controller
{

    private EventParticipantRepositoryInterface $eventParticipantRepository;

    public function __construct(
        EventParticipantRepositoryInterface $eventParticipantRepository
    ) {
        $this->eventParticipantRepository = $eventParticipantRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $eventParticipants = $this->eventParticipantRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return  ResponseHelper::jsonResponse(true, 'Data Peserta Event berhasil diambil!', $eventParticipants, 200);
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
            $eventParticipants = $this->eventParticipantRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );
            return  ResponseHelper::jsonResponse(true, 'Data Peserta Event berhasil diambil!', PaginateResource::make($eventParticipants, EventParticipantResource::class), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventParticipantStoreRequest $request)
    {
        $request = $request->validated();

        try {
            $eventParticipant = $this->eventParticipantRepository->create(
                $request
            );

            return ResponseHelper::jsonResponse(true, 'Data Peserta Event berhasil dibuat!', new EventParticipantResource($eventParticipant), 200);
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
            $eventparticipant = $this->eventParticipantRepository->getById(
                $id
            );

            if (!$eventparticipant) {
                return ResponseHelper::jsonResponse(false, 'Data Peserta Event tidak ditemukan!', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data Peserta Event berhasil diambil!', $eventparticipant, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventParticipantUpdateRequest $request, string $id)
    {
        $request = $request->validated();

        try {
            $eventparticipant = $this->eventParticipantRepository->getById(
                $id
            );
            if (!$eventparticipant) {
                return ResponseHelper::jsonResponse(false, 'Data Pesrta Event tidak ditemukan!', null, 404);
            }

            $eventparticipant = $this->eventParticipantRepository->update(
                $id,
                $request
            );


            return ResponseHelper::jsonResponse(true, 'Data Peserta Event berhasil diupdate!', new EventParticipantResource($eventparticipant), 200);
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
            $eventparticipant = $this->eventParticipantRepository->getById(
                $id
            );
            if (!$eventparticipant) {
                return ResponseHelper::jsonResponse(false, 'Data Peserta Event tidak ditemukan!', null, 404);
            }

            $eventparticipant->delete();

            return ResponseHelper::jsonResponse(true, 'Data Peserta Event berhasil dihapus!', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
