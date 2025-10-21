<?php

namespace App\Repositories;

use App\Interfaces\SocialAssistenceRepositoryInterface;
use App\Models\SocialAssistance;
use Exception;
use Illuminate\Support\Facades\DB;

class SocialAssistenceRepository implements SocialAssistenceRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $excecute
    ) {
        $query = SocialAssistance::where(function ($query) use ($search) {
            // jika ada parameter $search, maka akan melakukan pencarian pada model yang kita definisikandi model HeadOfFamily
            if ($search) {
                $query->search($search);
            }
        });

        $query->orderBy('created_at', 'desc');

        if ($limit) {
            // take mangambil data berdasarkan limit
            $query->take($limit);
        }

        if ($excecute) {
            return    $query->get();
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
        $query = SocialAssistance::where('id', $id);

        return $query->first();
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {

            $socialAssistance = new SocialAssistance();
            $socialAssistance->thumbnail = $data['thumbnail']->store('assets/social-assistances', 'public');
            $socialAssistance->name = $data['name'];
            $socialAssistance->category = $data['category'];
            $socialAssistance->amount = $data['amount'];
            $socialAssistance->provider = $data['provider'];
            $socialAssistance->description = $data['description'];
            $socialAssistance->is_available = $data['is_available'];

            $socialAssistance->save();

            DB::commit();

            return $socialAssistance;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function update(
        string $id,
        array $data
    ) {
        // implementation...
    }

    public function delete(
        string $id
    ) {
        // implementation...
    }
}
