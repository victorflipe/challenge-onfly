<?php

namespace App\Interfaces;
interface TravelRequestRepositoryInterface
{
    function getAllTravels(string $request, $perPage = null); 
    function allForUser(int $perPage);      
    function find(int $id);
    function delete(int $id);
    function create(array $data);
    function update(int $id, array $data);
}