<?php

declare(strict_types=1);

namespace wavycraft\tnt;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;

use pocketmine\entity\Location;
use pocketmine\entity\object\PrimedTNT;

class EventListener implements Listener {

    public function onPlace(BlockPlaceEvent $event) {
        $item = $event->getItem();
        $player = $event->getPlayer();
        $nbt = $item->getNamedTag();

        if ($nbt->getTag("TNT")) {
            $event->cancel();
            $position = $event->getBlockAgainst()->getPosition();
            $world = $position->getWorld();

            $tntPosition = $position->add(0.5, 1.5, 0.5);
            $location = new Location($tntPosition->x, $tntPosition->y, $tntPosition->z, $world, 0, 0);
            
            $tnt = new PrimedTNT($location);
            $tnt->setFuse(80);
            $tnt->spawnToAll();

            $player->getInventory()->removeItem($item->setCount(1));
            return;
        }
    }
}
