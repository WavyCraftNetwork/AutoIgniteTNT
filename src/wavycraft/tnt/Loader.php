<?php

declare(strict_types=1);

namespace wavycraft\tnt;

use pocketmine\plugin\PluginBase;

final class Loader extends PluginBase {

    protected function onEnable() : void{
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
    }
}