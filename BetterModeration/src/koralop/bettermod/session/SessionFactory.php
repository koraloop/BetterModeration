<?php

namespace koralop\bettermod\session;

use pocketmine\plugin\PluginBase;

/**
 * @class SessionFactory
 * @package koralop\bettermod\session
 * @author koralop
 */
class SessionFactory
{
  /** @var array[] */
  private static array $sessions = [];
  
  /**
   * @param array
   */
  public static function getSessions() : array {
     return self::$sessions;
   }
  
  /**
   * @param void
   * @class Player $player
   */
  public static function get(Player $player) : void {
    return self::$sessions[$player->getName()] ?? null;
  }
  
  /**
   * @param void
   * @class Player $player
   */
  public static function set(Player $player) : void {
    self::$sessions[$player->getName()] = new Session($player);
  }
  
  /**
   * @param void
   * @class Player $player
   */
  public static function destroy(Player $player) : void {
    unset(self::$sessions[$player->getName()]);
  }
}

?>