<?php

namespace koralop\bettermod;

use koralop\bettermod\listener\SessionListener;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use muqsit\invmenu\InvMenuHandler;
/**
 * @Class Loader
 * @package koralop\bettermod
 * @author koralop
 */
class Loader extends PluginBase
{
  use SingletonTrait;
  protected function onLoad() : void {
    self::setInstance($this);
    if(!InvMenuHandler::isRegistered()){
    	InvMenuHandler::register($this);
    }
  }
  
  protected function onEnable() : void {
    $this->getServer()->getPluginManager()->registerEvents(new SessionListener(), $this);
  }
}
?>