<?php

interface Worker
{
  public function work();
}

class Designer implements Worker
{
  public function work()
  {
    return printf('im Designer');
  }
}

class Developer implements Worker
{
  public function work()
  {
    return printf('im Developer');
  }
}

interface WorkerFactory
{
  public function make();
}

class DesignerFactory implements WorkerFactory
{
  public function make()
  {
    return new Designer();
  }
}


class DeveloperFactory implements WorkerFactory
{
  public function make()
  {
    return new Developer();
  }
}



$developer = DeveloperFactory->make();
$developer->work();
echo "\n";

$designer = DesignerFactory::make();
$designer->work();
