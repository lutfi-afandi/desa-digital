<?php

namespace App\Repositories;

use App\Interfaces\SocialAssistenceRecipientRepositoryInterface;
use App\Models\SocialAssistanceRecepient;

class SocialAssistenceRecipientRepository implements SocialAssistenceRecipientRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $excecute
    ) {
        $query = SocialAssistanceRecepient::where(function ($query) use ($search) {
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
        $query = SocialAssistanceRecepient::where('id', $id);

        return $query->first();
    }

    public function create(array $data)
    {
        // 'social_assistance_id',
        // 'head_of_family_id',
        // 'amount',
        // 'reason',
        // 'bank',
        // 'account_number',
        // 'proof',
        // 'status',
    }

    public function update(
        string $id,
        array $data
    ) {}

    public function delete(
        string $id
    ) {}
}
