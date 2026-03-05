<?php

class Contact
{
    private int $id;
    private string $name;
    private string $email;
    private string $phone_number;
    //hydratation
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst(strtolower($key));
            if (method_exists($this, $method)) {
                $this->$method($value);
            } elseif (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
    public function id(): int
    {
        return $this->id;
    }
    public function name(): string
    {
        return $this->name;
    }
    public function email(): string
    {
        return $this->email;
    }
    public function phone_number(): string
    {
        return $this->phone_number;
    }

    public function setName(string $name): void
    {
        $this->name = strtoupper($name);
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function __toString(): string
    {
        return "ID: {$this->id} | Nom: {$this->name} | Email: {$this->email} | Téléphone: {$this->phone_number}";
    }

}