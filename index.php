<?php
include("Customer.php");
include("CustomerContainer.php");


function viewClients($clients) {

    if(count($clients) > 0)
    {
        foreach ($clients as $cl) {
            echo $cl;
            echo PHP_EOL;
        }
    }
    else 
    {
        echo "No clients.";
    }
}

function inputChecker($title, $validationType) {
    $input = readline($title);
    while(true) {
        if($validationType == "EMAIL")
        {
            if(filter_var($input, FILTER_VALIDATE_EMAIL))
                break;
        }
        elseif($validationType == "PHONE")
        {
            if (preg_match("/^[0-9]{9,14}\$/", $input))
                break;
        }
        else {
            if(strlen($input) > 0)
                break;
        }
   
        echo "Validation failed. Try again".PHP_EOL;
        $input = readline($title);        
    }
    return $input;
}


//$c2 = new Customer(2,"John","aa@gg.lt", "+37085555", "2012-10-10");
//$c1 = new Customer(55,"Johns","asa@gg.lt", "+370s85555", "2012-10-10");

$container = new CustomerContainer();


// list +
// delete +
// add +
// edit -
// validate -
// import +

while(true) {
    $command = readline("Enter command: ");
    switch ($command) {
        case "list":
            echo "List ".PHP_EOL;
            viewClients($container->getCustomers());
            break;
        case "delete":
            $id = readline("Enter client ID to delete, please: ");
            if(is_numeric($id)) {
                if($container->delete($id))
                    echo "Deleted ! ";
                else
                    echo "Could not delete ! ";
            }
            else
                echo "ID must be integer";
          break;
/*        case "edit":
            $id = readline("Write client ID to edit, please: ");
            if(is_numeric($id)) {
                if(array_key_exists($id, $customers)) {
                    $name = $customers[$id]->getName();
                    echo "current name: ".$name.PHP_EOL;
                    $doChange = readline("enter new: ");
                    echo $doChange;
                    if(!empty($doChange))
                        $name = inputChecker(" name: ", "NONE");

                    $doChange = readline("email: ");
                        if($doChange == 1)
                            $email = inputChecker(" email: ", "EMAIL");
//                    $phone = inputChecker(" phone: ", "PHONE");          
//                    $datetime = inputChecker(" datetime: ", "DATETIME");          
                }
            }
            else
                echo "ID must be integer";            
            break;
*/
        case "add":

 
          echo "Add new client".PHP_EOL;
          $id = rand(0,6000);
          $name = inputChecker(" name: ", "NONE");
          $email = inputChecker(" email: ", "EMAIL");
          $phone = inputChecker(" phone: ", "PHONE");          
          $datetime = inputChecker(" datetime: ", "NONE");          
          $container->insert(new Customer($id, $name, $email, $phone, $datetime));
          echo "Successfuly executed !";
          break;

        case "import":
            $container->importFromCSV("Visitors.csv");
            break;
        default:
          echo "Command does not exists ! add|delete|edit|import";
      }
      echo PHP_EOL;
}


?>