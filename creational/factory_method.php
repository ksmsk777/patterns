<?php

interface Worker
{
  public function work(); 
}

class Developer implements Worker
{
  public function work()
  {
   printf('im Developer');
  }
}

class Designer implements Worker
{
  public function work()
  {
    printf('im Designer');
  }
}

interface WorkerFactory
 {
    public static function make();
 }

class DeveloperFactory implements WorkerFactory
 {
    public static function make()
    {
      return new Developer();
      
    }
 }
class DesignerFactory implements WorkerFactory
 {
    public static function make()
    {
      return new Designer();
      
    }
 }

 $developer = DeveloperFactory::make();
 $developer->work();
 echo "\n";
 
 $designer = DesignerFactory::make();
 $designer->work();
 