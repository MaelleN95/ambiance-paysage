<?php

namespace App\DTO;

class ContactData
{
    public ?string $company = null;
    public ?string $firstName = null;
    public ?string $lastName = null;
    public ?string $address = null;
    public ?int $phone = null;
    public ?string $email = null;
    public $service = [];
    public ?string $message = null;
}
