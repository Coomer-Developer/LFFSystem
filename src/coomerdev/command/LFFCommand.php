<?php

namespace coomerdev\command;

use coomerdev\LFFSystem;
use coomerdev\utils\Utils;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class LFFCommand extends Command {

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return;
        if(LFFSystem::getCooldown()->get($sender->getName()) === null){
            Utils::sendMenu($sender);
        }else{
            $cooldown = LFFSystem::getCooldown()->get($sender->getName());
            $sender->sendMessage("§7You have to wait to use the command again §c".gmdate("i:s", $cooldown->getTime())."m §7time left");
        }
        LFFSystem::getCooldown()->add($sender->getName(), 60*5, $sender, function ($tick, $player){}, function ($tick, $player){});
    }

}
