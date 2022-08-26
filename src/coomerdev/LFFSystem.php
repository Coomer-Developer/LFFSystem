<?php

namespace coomerdev;

use coomerdev\command\LFFCommand;
use coomerdev\cooldown\CooldownManager;
use muqsit\invmenu\InvMenuHandler;
use pocketmine\plugin\PluginBase;

class LFFSystem extends PluginBase {

    public static LFFSystem $instance;
    public static CooldownManager $cooldown;

    protected function onLoad(): void {
        self::$instance = $this;
        self::$cooldown = new CooldownManager();
    }

    protected function onEnable(): void {
        if(!InvMenuHandler::isRegistered()) InvMenuHandler::register($this);
        $this->getServer()->getCommandMap()->register("lff", new LFFCommand("lff"));
    }

    public static function getInstance(): LFFSystem {
        return self::$instance;
    }

    public static function getCooldown(): CooldownManager {
        return self::$cooldown;
    }

}