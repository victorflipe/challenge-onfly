<?php

namespace App\Repositories;

use App\Interfaces\TravelRequestRepositoryInterface;
use App\Models\TravelRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class TravelRequestRepository implements TravelRequestRepositoryInterface
{
    public function getAllTravels($request, $perPage = 10)
    {
        $user = Auth::user();

        if (!$user->is_admin) {
            return TravelRequest::where('user_id', $user->id)->paginate($perPage);
        }
    
        return TravelRequest::search($request)->paginate($perPage);
    }

    public function find(int $id)
    {
        return TravelRequest::find($id);
    }

    public function create(array $data): TravelRequest
    {
        return TravelRequest::create($data);
    }

    public function update(int $id, array $data)
    {
        return TravelRequest::update($data);
        // return $travelRequest;
    }

    public function delete(int $id)
    {
        return TravelRequest::delete($id);
    }

    public function allForUser($perPage = 10): Collection
    {
        return TravelRequest::getByUserId(Auth::id())->paginate($perPage);
    }
}
