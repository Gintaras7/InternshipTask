<?php

class CustomerContainer {

    private $customers;

    public function __construct() {
        $customers = array();
    }

    public function insert($customer) {
        $id = $this->getSuitableID($customer->getId());
        $this->customers[$id] = $customer;
    }

    public function delete($id) {
        if(array_key_exists($id, $this->customers)) {
            unset($this->customers[$id]);
            return true;
        }
        return false;
    }

    public function getCustomer($id) {
        if(array_key_exists($id, $this->customers)) {
            return $this->customers[$id];
        }
        return null;
    }

    public function getCustomers() {
        return $this->customers;
    }

    public function importFromCSV($filename) {

        if(file_exists($filename))
        {
            $data = file($filename);
            unset($data[0]); // remove header
            foreach($data as $line) {
                list($id,$name,$email,$phone,$datetime) = str_getcsv($line);
                $id = $this->getSuitableID($id);                
                $cust = new Customer($id,$name,$email,$phone,$datetime);
                $this->customers[$id] = $cust;
            }
        }
        else
        {
            echo "Error. File does not exists".PHP_EOL;
        }
    }

    public function getSuitableID($id) {

        // padaryti geresnius raktus
        while(@array_key_exists($id, $this->customers)) {
            $id++;
        }
        return $id;
    }




    

}

?>