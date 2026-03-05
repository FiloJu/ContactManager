<?php

class ContactManager extends Manager
{
    public function findAll()
    {
        $statement = $this->database->query('SELECT * FROM contact');
        $contacts = $statement->fetchAll(\PDO::FETCH_CLASS, 'Contact');
        return $contacts;
    }

    public function findById(int $id): Contact
    {
        $stmt = $this->database->prepare("SELECT * FROM contact WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return new Contact($row);
    }

    public function create(string $name, string $email, string $phone_number): void
    {
        $stmt = $this->database->prepare(
            "INSERT INTO contact (name, email, phone_number) 
             VALUES (:name, :email, :phone_number)"
        );
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone_number
        ]);

        echo "Contact créé avec succès !\n";
    }

    public function delete(int $id): void
    {
        $stmt = $this->database->prepare("DELETE FROM contact WHERE id = :id");
        $stmt->execute(['id' => $id]);

        echo "Contact supprimé avec succès !\n";
    }
}