<?php
require("Customer.php");
require("CustomerContainer.php");
require("cli_functions.php");


// prints customers in console
// $clients - array of customers
function viewCustomers($clients) {
    if(@count($clients) > 0)
    {
        foreach ($clients as $cl)
            echo $cl.PHP_EOL;
    }
    else 
    {
        echo "No clients.";
    }
}

$container = new CustomerContainer();
$run = true;

// commands in each case can be found in file "cli_functions.php"
while($run) {
    $command = readline("Enter new command: ");
    switch ($command) {
        case "list":
            viewCustomers($container->getCustomers());
            break;
        case "delete":
            deleteCommand($container);
          break;
        case "edit":
            editCommand($container);
            break;
        case "add":
            addCommand($container);
          break;
        case "import":
            importCommand($container);
            break;
        default:
          echo "Command does not exists ! Possible commands: add | delete | edit | import | list ";
      }
      echo PHP_EOL;
}

?>
