<?php
require_once 'Command.php';
require_once 'Contact.php';
require_once 'Manager.php';
require_once 'ContactManager.php';


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
