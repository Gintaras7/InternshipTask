<?php

// deletes user from container
function deleteCommand($container) {
    $id = readline("Enter client ID to delete, please: ");
    if(is_numeric($id)) {
        $result = $container->delete($id) ? "Deleted" : "Could not delete";
        echo $result;
    }
    else
    {
        echo "ID must be integer";
    }    
}


// edits specified customer by id in container
function editCommand($container) {
    $id = readline("Write client ID to edit, please: ");
    if(is_numeric($id)) {
        $customer = $container->getCustomer($id);
        if($customer != null) {
            $data = array();
            $data["name"] = editPart("name", $customer->getName());
            $data["email"] = editPart("email", $customer->getEmail(), "EMAIL");                    
            $data["phone"] = editPart("phone", $customer->getPhone(), "PHONE");                                        
            $data["datetime"] = editPart("datetime", $customer->getDatetime());                                        
            $container->updateCustomer($id, $data);
        }
        else
        {
            echo "Client does not exists";
        }
    }
    else
        echo "ID must be integer";            
}

// adds customer into container.
function addCommand($container) {
    echo "Add new customer".PHP_EOL;
    $id = rand(0,6000);
    $name = inputChecker("name", "NONE");
    $email = inputChecker("email", "EMAIL");
    $phone = inputChecker("phone (ex. +37061111111)", "PHONE");          
    $datetime = inputChecker("datetime", "NONE");          
    $container->insert(new Customer($id, $name, $email, $phone, $datetime));
    echo "Successfuly executed !";
}

// imports data from CSV file
function importCommand($container) {
    $file = readline("Enter CSV filename (ex. Visitors.csv) ");
    $result = $container->importFromCSV($file);
    echo $result ? "Done" : "Error. File does not exists";
}

// does validation. If validation fails, then user must enter new value, until is valid
// $title - field name
// $validationType - what type of data is expected
// $input - by default empty. If not empty, user write some text in console
function inputChecker($title, $validationType, $input = "") {   
    $format = " ".$title.": ";

    if($input == "")
        $input = readline($format);

    while(true) {
        if($validationType == "EMAIL")
        {
            if(filter_var($input, FILTER_VALIDATE_EMAIL))
                break;
        }
        elseif($validationType == "PHONE")
        {
            if (preg_match("/^\+3706\d{7}$/", $input))
                break;
        }
        else
        {
            if(strlen($input) > 0)
                break;
        }
   
        echo "Validation failed. Try again".PHP_EOL;
        $input = readline($format);        
    }
    return $input;
}

// Used for customer fields editing.
// Returns unchanged $input value if pressed enter
// Returns new validated value if entered something
function editPart($title, $input, $validationType = "NONE") {
    echo "current ".$title.": ".$input.PHP_EOL;
    $in = readline("enter new value (press ENTER if you dont want to change field): ");

    // if not empty, then trying to validate input data
    if(!empty($in))
        $input = inputChecker($title, $validationType, $in);

    return $input;
}

?>