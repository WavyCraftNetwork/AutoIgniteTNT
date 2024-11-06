<?php

declare(strict_types=1);

namespace wavycraft\tnt;

use pocketmine\block\VanillaBlocks;

use pocketmine\item\Item;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\StringToEnchantmentParser;

use pocketmine\player\Player;

use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat as TextColor;

use pocketmine\nbt\tag\StringTag;

use function array_map;

final class TNT {
    use SingletonTrait;

    public function giveTNT(Player $player, int $amount) : Item{
        $tnt = VanillaBlocks::TNT()->asItem();
        $tnt->setCount($amount);

        $tntName = Loader::getInstance()->getConfig()->get("tnt.name");
        $tntLore = Loader::getInstance()->getConfig()->get("tnt.lore");

        $tnt->setCustomName(TextColor::colorize($tntName));

        $colorizedLore = array_map(static fn($line) => TextColor::colorize($line), (array) $tntLore);
        $tnt->setLore($colorizedLore);

        $enchantString = Loader::getInstance()->getConfig()->get("tnt.enchantment");
        $enchantLevel = Loader::getInstance()->getConfig()->get("tnt.enchantment.level");

        $enchantment = StringToEnchantmentParser::getInstance()->parse($enchantString);
        if ($enchantment !== null) {
            $tnt->addEnchantment(new EnchantmentInstance($enchantment, $enchantLevel));
        }

        $nbt = $tnt->getNamedTag();
        $nbt->setTag("TNT", new StringTag("instant_tnt"));
        $tnt->setNamedTag($nbt);

        return $tnt;
    }
}
