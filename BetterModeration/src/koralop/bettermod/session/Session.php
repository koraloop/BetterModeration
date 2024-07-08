<?php

namespace koralop\bettermod\session;

use pocketmine\player\Player;

/**
 * @class SessionFactory
 * @package koralop\bettermod\session
 * @author koralop
 */
class Session {
  
  public bool $enabled = false;
  public bool $vanish = false;
  public bool $freeze = false;
  
  public function __construct(Player $player) {
    $this->player = $player;
  }
  
  public function isStaff() : bool {
    return $this->enabled;
  }
  
  public function setStaff(bool $enabled = false) : void {
    $this->enabled = $enabled;
  }
  
  public function isVanish() : bool {
    return $this->vanish;
  }
  
  public function setVanish(bool $vanish = false) : void {
    $this->vanish = $vanish;
  }
  
  public function isFreeze() : bool {
    return $this->freeze;
  }
  
  public function setFreeze(bool $freeze = false) : void {
    $this->freeze = $freeze;
  }
}

?>