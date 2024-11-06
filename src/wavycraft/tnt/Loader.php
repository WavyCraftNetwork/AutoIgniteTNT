<?php

declare(strict_types=1);

namespace wavycraft\tnt;

use pocketmine\plugin\PluginBase;

final class Loader extends PluginBase {

    private static $instance;

    protected function onLoad() : void{
        self::$instance = $this;
    }

    protected function onEnable() : void{
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $this->getServer()->getCommandMap()->register("AutoIgniteTNT", new TNTCommand());
    }

    public static function getInstance() : self{
        return self::$instance;
    }
}
