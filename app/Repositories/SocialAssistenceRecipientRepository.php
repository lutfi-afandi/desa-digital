<?php

namespace App\Repositories;

use App\Interfaces\SocialAssistenceRecipientRepositoryInterface;
use App\Models\SocialAssistanceRecepient;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        // 'social_assistance_id',
        // 'head_of_family_id',
        // 'amount',
        // 'reason',
        // 'bank',
        // 'account_number',
        // 'proof',
        // 'status',
        try {
            $socialAssistanceRecipient = new SocialAssistanceRecepient();
            $socialAssistanceRecipient->social_assistance_id = $data['social_assistance_id'];
            $socialAssistanceRecipient->head_of_family_id = $data['head_of_family_id'];
            $socialAssistanceRecipient->amount = $data['amount'];
            $socialAssistanceRecipient->reason = $data['reason'];
            $socialAssistanceRecipient->bank = $data['bank'];
            $socialAssistanceRecipient->account_number = $data['account_number'];

            if (isset($data['proof'])) {
                $socialAssistanceRecipient->proof = $data['proof'];
            }

            if (isset($data['status'])) {
                $socialAssistanceRecipient->status = $data['status'];
            }

            $socialAssistanceRecipient->save();

            DB::commit();
            return $socialAssistanceRecipient;
        } catch (\Exception $e) {

            DB::rollBack();
            throw new \Exception('Gagal membuat Penerima Bantuan Sosial: ' . $e->getMessage());
        }
    }

    public function update(
        string $id,
        array $data
    ) {
        DB::beginTransaction();

        try {
            $socialAssistanceRecipient = $this->getById($id);

            if (!$socialAssistanceRecipient) {
                throw new \Exception('Penerima Bantuan Sosial tidak ditemukan');
            }

            $socialAssistanceRecipient->social_assistance_id = $data['social_assistance_id'];
            $socialAssistanceRecipient->head_of_family_id = $data['head_of_family_id'];
            $socialAssistanceRecipient->amount = $data['amount'];
            $socialAssistanceRecipient->reason = $data['reason'];
            $socialAssistanceRecipient->bank = $data['bank'];
            $socialAssistanceRecipient->account_number = $data['account_number'];

            if (isset($data['proof'])) {
                $socialAssistanceRecipient->proof = $data['proof'];
            }

            if (isset($data['status'])) {
                $socialAssistanceRecipient->status = $data['status'];
            }

            $socialAssistanceRecipient->save();

            DB::commit();
            return $socialAssistanceRecipient;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Gagal mengupdate Penerima Bantuan Sosial: ' . $e->getMessage());
        }
    }

    public function delete(
        string $id
    ) {
        DB::beginTransaction();

        try {
            $socialAssistanceRecipient = $this->getById($id);

            if (!$socialAssistanceRecipient) {
                throw new \Exception('Penerima Bantuan Sosial tidak ditemukan');
            }

            $socialAssistanceRecipient->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Gagal menghapus Penerima Bantuan Sosial: ' . $e->getMessage());
        }
    }
}
