<?php

namespace koralop\bettermod\listener;

use koralop\bettermod\session\SessionFactory;

use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\event\player\PlayerJoinEvent;

/**
 * @class SessionListener
 * @package koralop\bettermod\listener
 * @author koralop
 */
class SessionListener implements Listener{
  
  public function onJoin(PlayerJoinEvent $event) : void {
    $player = $event->getPlayer();
    if ($player instanceof Player) {
      SessionFactory::set($player);
    }
  }
}
?>