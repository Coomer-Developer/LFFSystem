<?php

namespace coomerdev\utils;

use coomerdev\LFFSystem;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\player\Player;

class Utils {

    public static array $players = [];

    public static function sendMenu(Player $player): void {
        self::$players[$player->getName()]["Diamond"] = false;
        self::$players[$player->getName()]["Archer"] = false;
        self::$players[$player->getName()]["Rogue"] = false;
        self::$players[$player->getName()]["Bard"] = false;
        $menu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
        $menu->setName("§6Looking For Faction");
        foreach(self::getItemsMenu() as $slot => $item){
            $menu->getInventory()->setItem($slot, $item);
        }
        $menu->setListener(function(InvMenuTransaction $transaction) use($menu): InvMenuTransactionResult {
            $item = $transaction->getItemClicked();
            if($item->getCustomName() === "§r§cDiamond"){
                $menu->getInventory()->setItem(20, $item->setCustomName("§r§aDiamond"));
                self::$players[$transaction->getPlayer()->getName()]["Diamond"] = true;
                return $transaction->discard();
            }elseif($item->getCustomName() === "§r§aDiamond"){
                $menu->getInventory()->setItem(20, $item->setCustomName("§r§cDiamond"));
                self::$players[$transaction->getPlayer()->getName()]["Diamond"] = false;
                return $transaction->discard();
            }
            if($item->getCustomName() === "§r§cArcher"){
                $menu->getInventory()->setItem(21, $item->setCustomName("§r§aArcher"));
                self::$players[$transaction->getPlayer()->getName()]["Archer"] = true;
                return $transaction->discard();
            }elseif($item->getCustomName() === "§r§aArcher"){
                $menu->getInventory()->setItem(21, $item->setCustomName("§r§cArcher"));
                self::$players[$transaction->getPlayer()->getName()]["Diamond"] = false;
                return $transaction->discard();
            }
            if($item->getCustomName() === "§r§cRogue"){
                $menu->getInventory()->setItem(23, $item->setCustomName("§r§aRogue"));
                self::$players[$transaction->getPlayer()->getName()]["Rogue"] = true;
                return $transaction->discard();
            }elseif($item->getCustomName() === "§r§aRogue"){
                $menu->getInventory()->setItem(23, $item->setCustomName("§r§cRogue"));
                self::$players[$transaction->getPlayer()->getName()]["Diamond"] = false;
                return $transaction->discard();
            }
            if($item->getCustomName() === "§r§cBard"){
                $menu->getInventory()->setItem(24, $item->setCustomName("§r§aBard"));
                self::$players[$transaction->getPlayer()->getName()]["Bard"] = true;
                return $transaction->discard();
            }elseif($item->getCustomName() === "§r§aBard"){
                $menu->getInventory()->setItem(24, $item->setCustomName("§r§cBard"));
                self::$players[$transaction->getPlayer()->getName()]["Diamond"] = false;
                return $transaction->discard();
            }
            if($item->getCustomName() === "§r§6Send Broadcast"){
                LFFSystem::getInstance()->getServer()->broadcastMessage("§7---------------------------------------------");
                LFFSystem::getInstance()->getServer()->broadcastMessage("§e{$transaction->getPlayer()->getName()} §6is looking for faction");
                LFFSystem::getInstance()->getServer()->broadcastMessage("§eClasses: ".self::getClassesPlayer($transaction->getPlayer()));
                LFFSystem::getInstance()->getServer()->broadcastMessage("§7---------------------------------------------");
                $transaction->getPlayer()->removeCurrentWindow();
                return $transaction->discard();
            }
            return $transaction->discard();
        });
        $menu->send($player);
    }

    public static function getClassesPlayer(Player $player): string {
        $classes = [];
        if(self::$players[$player->getName()]["Diamond"] === true){
            $classes[] = "§r§dDiamond";
        }
        if(self::$players[$player->getName()]["Archer"] === true){
            $classes[] = "§r§aArcher";
        }
        if(self::$players[$player->getName()]["Rogue"] === true){
            $classes[] = "§r§fRogue";
        }
        if(self::$players[$player->getName()]["Bard"] === true){
            $classes[] = "§r§eBard";
        }
        return implode(", ", $classes);
    }

    public static function getItemsMenu(): array {
        $items = [
            13 => ItemFactory::getInstance()->get(ItemIds::END_CRYSTAL, 0, 1)->setCustomName("§r§6Looking For Faction"),
            20 => ItemFactory::getInstance()->get(ItemIds::DIAMOND_HELMET, 0, 1)->setCustomName("§r§cDiamond"),
            21 => ItemFactory::getInstance()->get(ItemIds::LEATHER_HELMET, 0, 1)->setCustomName("§r§cArcher"),
            23 => ItemFactory::getInstance()->get(ItemIds::CHAINMAIL_HELMET, 0, 1)->setCustomName("§r§cRogue"),
            24 => ItemFactory::getInstance()->get(ItemIds::GOLD_HELMET, 0, 1)->setCustomName("§r§cBard"),
            40 => ItemFactory::getInstance()->get(ItemIds::PAPER, 0, 1)->setCustomName("§r§6Send Broadcast"),
        ];
        return $items;
    }

}