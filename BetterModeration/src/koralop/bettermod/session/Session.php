<?php

namespace koralop\bettermod\session;

use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\item\Item;
use pocketmine\item\LegacyStringToItemParser;
use pocketmine\utils\TextFormat;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\type\InvMenuTypeIds;
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
  
  public function guiteleport() : void {
    $menu = InvMenu::create(InvMenu::TYPE_CHEST);
		$menu->setName("Teleport GUI.");
		foreach (Server::getInstance()->getOnlinePlayers() as $players) {
		  $data = Server::getInstance()->getPlayerByPrefix($players->getName());
		  $menu->getInventory()->addItem(self::getItem(144, 0, $data->getName(), $data->getName(), ["teleport player"]));
		}
		  $menu->setListener(function (InvMenuTransaction $transaction): InvMenuTransactionResult {
        $player = $transaction->getPlayer();
        foreach (Server::getInstance()->getOnlinePlayers() as $players) {
		  $data = Server::getInstance()->getPlayerByPrefix($players->getName());
		  if (!$data->isOnline()) return $transaction->discard();
		  
		  $player->teleport($data->getPosition());
        }
        return $transaction->discard();
            });
  }
  
  public function tprand() : void {
    $player = $this->player;
    $online = $player->getServer()->getOnlinePlayers();
    $target = $online[array_rand($online)];
    
    $x = $target->getPosition()->getX();
    $y = $target->getPosition()->getY();
    $z = $target->getPosition()->getZ();
    
    $player->teleport(new Vector3($x, $y, $z));
  }
  
  public function enterVanish() : void {
    $player = $this->player;
    if ($this->isVanish() === true) {
      foreach (Server::getInstance()->getOnlinePlayers() as $players) {
          $players->showPlayer($player);
          }
      return;
    }
    foreach (Server::getInstance()->getOnlinePlayers() as $players) {
      if ($players->hasPermission('bettermod.vanish.view')) return;
        $players->hidePlayer($player);
      }
  }
  
  public function phase() : void {
    $player = $this->player;
    $pos = null;

			for($c = 2, $passedThrough = false; $c <= 5; $c++) {

				$tmp = $player->getPosition()->addVector($player->getDirectionVector()->multiply($c)->add(0, $player->getEyeHeight(), 0));
				if(!empty($player->getWorld()->getBlock($tmp)->getCollisionBoxes())) {
					if(!$passedThrough) {
						$passedThrough = true;
					} else {
						break;
					}
				}
				$pos = $tmp;
			}
			if(!$passedThrough){
				$player->setMotion($player->getDirectionVector()->multiply(2));
				return;
			}
			if($pos !== null && !empty($player->getTargetBlock(5)->getCollisionBoxes())) {
				$player->teleport($pos);
			}
  }
  
  public function giveItems() : void {
    $inv = $this->player->getInventory();
  }
  
  public function getItem(int $id = 0, int $meta = 0, string $customName = '', string $nbt = '', array $lore = []) : Item {
    $item = LegacyStringToItemParser::getInstance()->parse("{$id}:{$meta}")->setCount(1)->getCustomName(TextFormat::colorize($customName))->setLore($lore)->setNamedTag($item->getNamedTag()->setString($nbt));
    return $item;
  }
}

?>