<?php

namespace App\Services;

use App\Interfaces\TravelRequestRepositoryInterface;
// use App\Interfaces\TravelRequestServiceInterface;
use App\Models\TravelRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class TravelRequestService
{
    public function __construct(protected TravelRequestRepositoryInterface $repository) {}

    public function all($perPage = null)
    {
        return $this->repository->getAllTravels($perPage);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function getById(int $id)
    {
        return $this->repository->find($id);
    }

    public function update(TravelRequest $request, array $data)
    {
        return $this->repository->update($request->id, $data);
    }

    public function delete(TravelRequest $request)
    {
        return $this->repository->delete($request->id);
    }

    public function allForUser(): Collection
    {
        //return TravelRequest::where('user_id', Auth::id())->get();
        return $this->repository->allForUser();
    }
}
