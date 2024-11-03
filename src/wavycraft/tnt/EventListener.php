<?php

declare(strict_types=1);

namespace wavycraft\tnt;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;

use pocketmine\entity\Location;
use pocketmine\entity\object\PrimedTNT;

use pocketmine\item\StringToItemParser;

class EventListener implements Listener {

    public function onPlace(BlockPlaceEvent $event) {
        $item = $event->getItem();
        $player = $event->getPlayer();

        $tntItem = StringToItemParser::getInstance()->parse("tnt");
        if ($tntItem !== null && $item->getTypeId() === $tntItem->getTypeId()) {
            $event->cancel();
            $position = $event->getBlockAgainst()->getPosition();
            $world = $position->getWorld();

            $tntPosition = $position->add(0.5, 1.5, 0.5);
            $location = new Location($tntPosition->x, $tntPosition->y, $tntPosition->z, $world, 0, 0);
            
            $tnt = new PrimedTNT($location);
            $tnt->setFuse(80);
            $tnt->spawnToAll();

            $player->getInventory()->removeItem($tntItem->setCount(1));
        }
    }
}