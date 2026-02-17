<?php

final class Connection
{
  private static ?self $instance = null;
  private static string $name;
  /**
   * Get the value of name
   */ 
  public static function getName(): string
  {
    return self::$name;
  }
  
  /**
   * Set the value of name
   *
   * @return  self
   */ 
  public static function setName(string $name): void
  {
    self::$name = $name;
  }

  public static function getInstance() : self
  {
    if (self::$instance === null) {
      self::$instance = new self();
      
    }
    return self::$instance;
  } 


}


$connection = Connection::getInstance();
$connection::setName('Laravel');

var_dump($connection::getName());
