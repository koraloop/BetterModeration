<?php

namespace koralop\bettermod\listener;

use koralop\bettermod\session\SessionFactory;

use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\event\player\{PlayerJoinEvent, PlayerMoveEvent, PlayerItemUseEvent};

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
  
  public function onItem(PlayerItemUseEvent $event) : void {
    $player = $event->getPlayer();
    $item = $event->getItem();
    $targedItem = $item->getNamedTag();
    $session = SessionFactory::get($player);
    if ($player instanceof Player) {
      switch ($targedItem) {
        case 'vanish_mod_item':
          $session->enterVanish();
          break;
        case 'phase_mod_item':
          $session->phase();
          break;
        case 'teleport_mod_item':
          $session->guiteleport();
          break;
        case 'random_mod_item':
          $session->tprand();
          break;
        default:
          
          break;
      }
    }
  }
}
?>