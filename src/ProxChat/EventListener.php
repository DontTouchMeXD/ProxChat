<?php

namespace ProxChat;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\Player;

class EventListener implements Listener {
    
    /** @var Main $main */
    private $main;
    
    public function __construct(Main $main){
        $this->main = $main;
    }
    
    public function onChat(PlayerChatEvent $event){
        if($event->isCancelled()) return;
        $message = $event->getMessage();
        $player = $event->getPlayer(); 
        if(!$this->main->isPureChatEnable()){ 
            $chatFormat = str_replace(["{username}", "{display_name}", "{message}"], [$player->getName(), $player->getDisplayName(), $message], $this->main->config->get("chat_format"));
            $event->setFormat($chatFormat);
        }
        $recipients = $this->getNearbyPlayer($player);
		$event->setRecipients($recipients);  
    }
    
    public function getNearbyPlayer(Player $player): array {
        $nearby = [];
        foreach($player->getLevel()->getPlayers() as $p){
            if($p->distance($player) <= $this->main->config->get("radius")){
                $nearby[] = $p;
            }
        }
        return $nearby;
    }
}
