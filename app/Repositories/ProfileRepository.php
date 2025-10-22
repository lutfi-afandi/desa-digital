<?php

namespace App\Repositories;

use App\Interfaces\ProfileRepositoryInterface;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function get()
    {
        // karena profile desa ini cuma satu jadi kita ambil yang pertama saja
        return Profile::first();
    }

    public function create(
        array $data
    ) {
        DB::beginTransaction();

        //  'thumbnail',
        // 'name',
        // 'about',
        // 'headman',
        // 'people',
        // 'agricultural_area',
        // 'total_area',
        try {
            $profile = new Profile();
            $profile->thumbnail = $data['thumbnail']->store('asstes/profiles', 'public');
            $profile->name = $data['name'];
            $profile->about = $data['about'];
            $profile->headman = $data['headman'];
            $profile->people = $data['people'];
            $profile->agricultural_area = $data['agricultural_area'];
            $profile->total_area = $data['total_area'];

            if (array_key_exists('images', $data)) {
                foreach ($data['images'] as $image) {
                    $profile->profileImages()->create([
                        'image' => $image->store('asstes/profiles', 'public'),
                    ]);
                }
            }
            $profile->save();
            DB::commit();
            return $profile;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function update(
        array $data
    ) {
        DB::beginTransaction();


        try {
            $profile = Profile::first();

            if (isset($data['thumbnail'])) {
                $profile->thumbnail = $data['thumbnail']->store('asstes/profiles', 'public');
            }

            $profile->name = $data['name'];
            $profile->about = $data['about'];
            $profile->headman = $data['headman'];
            $profile->people = $data['people'];
            $profile->agricultural_area = $data['agricultural_area'];
            $profile->total_area = $data['total_area'];

            if (array_key_exists('images', $data)) {
                foreach ($data['images'] as $image) {
                    $profile->profileImages()->create([
                        'image' => $image->store('asstes/profiles', 'public'),
                    ]);
                }
            }
            $profile->save();
            DB::commit();
            return $profile;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }
    // Implementation of ProfileRepositoryInterface methods would go here
}
