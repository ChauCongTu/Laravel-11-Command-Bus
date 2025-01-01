<?php
namespace App\Commands\Auth;

class RegisterCommand
{
    private string $email;
    private string $password;
    private string $firstName;
    private string $lastName;
    private string $gender;
    private string $phone;
    private string $prefecture;
    private string $city;
    private string $address;
    private string $etcAddress;

    public function __construct(array $data)
    {
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->firstName = $data['firstName'] ?? null;
        $this->lastName = $data['lastName'] ?? null;
        $this->gender = $data['gender'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->prefecture = $data['prefecture'] ?? null;
        $this->city = $data['city'] ?? null;
        $this->address = $data['address'] ?? null;
        $this->etcAddress = $data['etcAddress'] ?? null;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the value of lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Get the value of firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Get the value of gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Get the value of phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Get the value of prefecture
     */
    public function getPrefecture()
    {
        return $this->prefecture;
    }

    /**
     * Get the value of city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Get the value of address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Get the value of etcAddress
     */
    public function getEtcAddress()
    {
        return $this->etcAddress;
    }
}
