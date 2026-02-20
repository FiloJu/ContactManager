<?php

class Command
{
    public function list(): void
    {
        $contactManager = new ContactManager();
        $contacts = $contactManager->findAll();

        foreach ($contacts as $contact) {
            echo $contact . "\n";
        }
    }

    public function detail(int $id): void
    {
        $contactManager = new ContactManager();
        $contact = $contactManager->findById($id);

        echo $contact . "\n";
    }

    public function create(string $nom, string $email, string $telephone): void
    {
        $contactManager = new ContactManager();
        $contactManager->create($nom, $email, $telephone);
    }

    public function delete(int $id): void
    {
        $contactManager = new ContactManager();
        $contactManager->delete($id);
    }

}