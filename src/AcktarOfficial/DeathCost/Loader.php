<?php
namespace AcktarOfficial\DeathCost;

use onebone\economyapi\EconomyAPI;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\Player;
use pocketmine\utils\Config;
use function str_replace;

class Loader extends PluginBase implements Listener {

public function onEnable() {
$this->saveResource("config.yml");
$this->config = new Config($this->getDataFolder() . "config.yml");
$this->getServer()->getPluginManager()->registerEvents($this, $this);
$this->getLogger()->info("DeathCost Has Been Enabled! ->> https://sub2acktar.xyz");
}

public function onPlayerDeath(PlayerDeathEvent $ev) {
    $player = $ev->getPlayer();
    $msg = $this->config->get("message");
    $msgne = $this->config->get("bal-notenough-msg");
    $cost = $this->config->get("death-cost");
    $bal = EconomyAPI::getInstance()->myMoney($player);
   
    if ($bal < $cost){
    EconomyAPI::getInstance()->reduceMoney($player, $bal);
    $reasonn = str_replace("{money}", $cost, $msgne);
    $player->sendMessage($reasonn);
    }
    
    EconomyAPI::getInstance()->reduceMoney($player, $cost);
    $reason = str_replace("{money}", $cost, $msg);
    $player->sendMessage($reason);
      }
 }
