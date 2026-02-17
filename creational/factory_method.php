<?php

interface Worker1
{
  public function work();
}

class Developer implements Worker1
{
  public function work()
  {
   printf('im Developer');
  }
}

class Designer implements Worker1
{
  public function work()
  {
    printf('im Designer');
  }
}

interface Worker1Factory
 {
    public static function make();
 }

class DeveloperFactory implements Worker1Factory
 {
    public static function make()
    {
      return new Developer();
      
    }
 }
class DesignerFactory implements Worker1Factory
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
 