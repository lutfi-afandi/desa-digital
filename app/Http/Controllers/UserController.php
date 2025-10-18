<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        try {
            $users = $this->userRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'User berhasil diambil!', UserResource::collection($users), 200);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $request = $request->validate([
            'search' => 'nullable|string',
            'row_per_page' => 'required'
        ]);

        try {
            $users = $this->userRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );

            return ResponseHelper::jsonResponse(true, 'User berhasil diambil!', PaginateResource::make($users, UserResource::class), 200);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    public function store(UserStoreRequest  $request)
    {
        // menangkap validasi dari UserStoreREquest
        $request = $request->validated();

        try {
            $user = $this->userRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'User berhasil ditambahkan', new UserResource($user), 201);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    public function show(string $id)
    {
        try {
            $user  = $this->userRepository->getById($id);

            if (!$user) {

                return ResponseHelper::jsonResponse(false, 'User tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data user berhasil diambil', new UserResource($user), 200);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
            //throw $th;
        }
    }
    public function update(UserUpdateRequest $request, string $id)
    {

        $request = $request->validated();
        try {
            $user  = $this->userRepository->getById($id);

            if (!$user) {

                return ResponseHelper::jsonResponse(false, 'User tidak ditemukan', null, 404);
            }

            $user = $this->userRepository->update(
                $id,
                $request
            );

            return ResponseHelper::jsonResponse(true, 'Data user berhasil diupdate', new UserResource($user), 200);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
            //throw $th;
        }
    }
    public function destroy(string $id)
    {
        try {
            $user  = $this->userRepository->getById($id);

            if (!$user) {
                return ResponseHelper::jsonResponse(false, 'User tidak ditemukan', null, 404);
            }

            $user = $this->userRepository->delete(
                $id,
            );

            return ResponseHelper::jsonResponse(true, 'Data user berhasil dihapus', new UserResource($user), 200);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
            //throw $th;
        }
    }
}
