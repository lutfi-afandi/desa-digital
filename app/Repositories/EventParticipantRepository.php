<?php

namespace App\Repositories;

use App\Interfaces\EventParticipantRepositoryInterface;
use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Support\Facades\DB;

class EventParticipantRepository implements EventParticipantRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $excecute
    ) {
        $query = EventParticipant::where(function ($q) use ($search) {
            if ($search) {
                $q->search($search);
            }
        });
        if ($limit) {
            $query->limit($limit);
        }
        if ($excecute) {
            return $query->get();
        }
        return $query;
    }

    public function getAllPaginated(
        ?string $search,
        ?int $rowPerPage
    ) {
        $query = $this->getAll(
            $search,
            $rowPerPage,
            false
        );

        return $query->paginate($rowPerPage);
    }

    public function getById(
        string $id
    ) {
        $query = EventParticipant::where('id', $id);
        return $query->first();
    }

    public function create(array $data)
    {
        DB::beginTransaction();


        try {
            $event = Event::findOrFail($data['event_id'])->first();

            $eventParticipant = new EventParticipant();
            $eventParticipant->event_id = $data['event_id'];
            $eventParticipant->head_of_family_id = $data['head_of_family_id'];
            $eventParticipant->quantity = $data['quantity'];
            $eventParticipant->total_price = (float) $event->price * $data['quantity'];

            // dd($eventParticipant->total_price);
            $eventParticipant->payment_status = 'pending';

            $eventParticipant->save();

            DB::commit();
            return $eventParticipant;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(
        string $id,
        array $data
    ) {
        DB::beginTransaction();


        try {
            $event = Event::findOrFail($data['event_id'])->first();

            $eventParticipant =  EventParticipant::find($id);
            $eventParticipant->event_id = $data['event_id'];
            $eventParticipant->head_of_family_id = $data['head_of_family_id'];

            if (isset($data['quantity'])) {
                $eventParticipant->quantity = $data['quantity'];
            } else {
                $data['quantity'] = $eventParticipant->quantity;
            }

            $eventParticipant->total_price = (float) $event->price * $data['quantity'];

            // dd($eventParticipant->total_price);
            $eventParticipant->payment_status = $data['payment_status'];;

            $eventParticipant->save();

            DB::commit();
            return $eventParticipant;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(
        string $id
    ) {
        // Implementation here
    }
}
