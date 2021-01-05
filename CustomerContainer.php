<?php

class CustomerContainer {
    private $customers;

    public function __construct() {
        $customers = array();
    }

    // inserts customer into array.
    public function insert($customer) {
        // checks ID to avoid objects with same ID
        $id = $this->getSuitableID($customer->getId());
        $this->customers[$id] = $customer;
    }

    // deletes user with specified ID from array
    // returns true, if deleted. Otherwise returs false
    public function delete($id) {
         if(count($this->customers) > 0 && array_key_exists($id, $this->customers)) {
            unset($this->customers[$id]);
            return true;            
        }
        return false;
    }

    // get specified customer by id
    // returns null if there is such customer
    public function getCustomer($id) {

        if(count($this->customers) > 0 && array_key_exists($id, $this->customers)) {
            return $this->customers[$id];
        }
        return null;
    }

    // returns customers list
    public function getCustomers() {
        return $this->customers;
    }

    // updates customer info.
    // $data - array contained with updated data
    public function updateCustomer($id, $data) {
        $customer = $this->getCustomer($id);
        if($customer != null)
        {        
            if(!empty($data["name"]))
                $customer->setName($data["name"]);
            if(!empty($data["email"]))
                $customer->setEmail($data["email"]);
            if(!empty($data["phone"]))
                $customer->setPhone($data["phone"]);
            if(!empty($data["datetime"]))
                $customer->setDateTime($data["datetime"]);                        
        }
    }

    // Adds customers to array from CSV file.
    public function importFromCSV($filename) {
        if(file_exists($filename))
        {
            $data = file($filename);
            unset($data[0]); // remove header
            foreach($data as $line) {
                list($id,$name,$email,$phone,$datetime) = str_getcsv($line);

                // validating part
                $err = "";
                if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                    $err = "Customer with id (".$id.") has invalid email.".PHP_EOL;

                // check if valid phone number
                if (!preg_match("/^\+3706\d{7}$/", $phone))
                    $err .= "Customer with id (".$id.") has invalid phone number.".PHP_EOL;
                
                // inserts customer if data is valid
                if(empty($err))
                {                    
                    $id = $this->getSuitableID($id);                
                    $cust = new Customer($id,$name,$email,$phone,$datetime);
                    $this->customers[$id] = $cust;
                }
                else
                {
                    echo $err;
                }
            }
            return true;
        }
        return false;
    }

    // increases if needed to avoid having more objects with same id
    public function getSuitableID($id) {
        while(@array_key_exists($id, $this->customers)) {
            $id++;
        }
        return $id;
    }    
}

?>