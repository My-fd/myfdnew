<?php

namespace App\Services\Address;

use App\Models\Address;

class AddressService
{
    public function create(array $data): Address
    {
        return Address::create($data);
    }

    public function update(Address $address, array $data): Address
    {
        $address->update($data);
        return $address;
    }

    public function delete(Address $address): void
    {
        $address->delete();
    }

    public function ac(string $addressString): array
    {
        return [];
    }
}
