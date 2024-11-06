<?php

declare(strict_types=1);

namespace wavycraft\tnt;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\player\Player;

use pocketmine\Server;

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;

use function count;
use function intval;

class TNTCommand extends Command implements PluginOwned {

    private $plugin;

    public function __construct() {
        parent::__construct("tnt");
        $this->setDescription("Give auto ignite TNT to a player.");
        $this->setUsage("/tnt <player> <amount>");
        $this->setPermission("autoignitetnt.cmd");

        $this->plugin = Loader::getInstance();
    }

    public function getOwningPlugin() : Plugin{
        return $this->plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (count($args) !== 2) {
            $sender->sendMessage($this->getUsage());
            return false;
        }

        $playerName = $args[0];
        $amount = intval($args[1]);

        if ($amount <= 0) {
            $sender->sendMessage("Amount must be a positive integer...");
            return false;
        }

        $targetPlayer = Server::getInstance()->getPlayerByPrefix($playerName);
        
        if (!$targetPlayer instanceof Player) {
            $sender->sendMessage("The player " . $playerName . " was not found, Make sure they're online or exist...");
            return false;
        }

        $tntItem = TNT::getInstance()->giveTNT($targetPlayer, $amount);
        $targetPlayer->getInventory()->addItem($tntItem);

        $targetPlayer->sendMessage("Recieved " . $amount . " instant TNT from " . $sender->getName() . "!");
        $sender->sendMessage("Gave " . $amount . " instant TNT to " . $targetPlayer->getName() . "!");
        return true;
    }
}
