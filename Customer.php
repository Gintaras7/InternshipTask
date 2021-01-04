<?php

class Customer {
  private $id;
  private $name;
  private $email;
  private $phone;
  private $dateTime;

  public function __construct($id, $name, $email, $phone, $dateTime) {
	  $this->id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->phone = $phone;
    $this->dateTime = $dateTime;		
  }

  public function getId(){
    return $this->id;
  }

  public function getName(){
    return $this->name;
  }

  public function getEmail(){
    return $this->email;
  }

  public function getPhone(){
    return $this->phone;
  }

  public function getDatetime(){
    return $this->datetime;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public function setEmail($email) {
    $this->email = $email;
  }

  public function setPhone($phone) {
    $this->phone = $phone;
  }

  public function setDatetime($dateTime) {
    $this->dateTime = $dateTime;
  }
  
  public function __toString() {
	  $data = $this->id." ";
	  $data .= $this->name." ";
	  $data .= $this->email." ";	  
	  $data .= $this->phone." ";
	  $data .= $this->dateTime." ";		  	  
	  return $data;
	  
  }
}
?>