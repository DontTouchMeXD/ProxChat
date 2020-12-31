<?php

namespace ProxChat;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;

class EventListener implements Listener {
    
    /** @var Main $main */
    private $main;
    
    public function __construct(Main $main){
        $this->main = $main;
    }
    
    public function onChat(PlayerChatEvent $event){
        if(!$event->isCancelled()){
            return;
        }
        $message = $event->getMessage();
        $player = $event->getPlayer(); 
        $p = $this->main->getPlayerNearby($player);
        if($this->main->isPureChatEnable()){
            $pureChat = $this->main->getServer()->getPluginManager()->getPlugin("PureChat");
            $levelName = $pureChat->getConfig()->get("enable-multiworld-chat") ? $player->getLevel()->getName() : null;
            $originalChatFormat = $pureChat->getOriginalChatFormat($player, $levelName);
            $chatFormat = $pureChat->applyColors($originalChatFormat);
            $chatFormat = $pureChat->applyPCTags($chatFormat, $player, $message, $levelName);
            $this->main->getServer()->broadcastMessage($chatFormat, $p); 
            $event->setCancelled();
        } else {
            $chatFormat = str_replace(["{username}", "{display_name}", "{message}"], [$player->getName(), $player->getDisplayName(), $message], $this->main->config->get("chat_format"));
            $this->main->getServer()->broadcastMessage($chatFormat, $p);
            $event->setCancelled();
        }
    }
}
