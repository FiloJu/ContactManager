<?php
require_once 'Command.php';
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
abstract class Manager
{
    protected ?\PDO $database = null;

    public function __construct()
    {
        if ($this->database === null) {
            $this->database = new \PDO('mysql:host=127.0.0.1;dbname=contact_manager;charset=utf8', 'root', 'root');
        }
    }
}

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

$contactManager = new ContactManager();
$contacts = $contactManager->findAll();

while (true) {
    $line = readline("Entrez votre commande : ");
    $command = new Command();

    if ($line === 'list') {
        $command->list();

    } elseif (preg_match('/^detail (\d+)$/', $line, $matches)) {
        $command->detail((int) $matches[1]);

    } elseif (preg_match('/^create ([^,]+),([^,]+),([^,]+)$/', $line, $matches)) {
        $command->create($matches[1], $matches[2], $matches[3]);

    } elseif (preg_match('/^delete (\d+)$/', $line, $matches)) {
        $command->delete((int) $matches[1]);

    } else {
        echo "Commande inconnue !\n";
    }
}
