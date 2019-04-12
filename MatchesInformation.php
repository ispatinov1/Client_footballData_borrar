<?php

/**
 * La clase MatchesInformation obtiene la información de los encuentros 
 *
 * @author Nelson
 */

require './ApiClient.php';

class MatchesInformation {
    private $apiClient;
    private $matchId;
    private $matchDate;
    private $matchResult;
    private $teamId;
    private $teamName;
    private $opponentTeamId;
    private $opponentTeamName;
    private $localTeamAddres;
    private $localTeamVenue;
    
    function __construct() {
        $this->apiClient = new ApiClient();
    }
    
    public function getMatchesInformation($teamId){
        $this->getTeamInformation($teamId);
        $matchesByTeamId = $this->apiClient->getMatchesByTeamId($this->teamId);
        foreach ($matchesByTeamId->matches as $match) {
            $this->matchId =  $match->id;
            $this->matchDate =  $match->utcDate;
            $this->matchResult =  $match->status;            
            $this->getOpponentTeamInformation($match, $this->teamId);
            $this->getLocationInformation($match);
            
            //$matchesInformation[] = $this; 
        }
        //return $matchesInformation;
        //$matchesInformation;
    }
    
    public function getTeamInformation($teamId) {
        $this->teamId = $this->apiClient->getTeamById($teamId)->id;
        $this->teamName = $this->apiClient->getTeamById($teamId)->name;
    }
    
    public function getOpponentTeamInformation($match, $teamId) {
        if($match->homeTeam->id != $teamId && $match->awayTeam->id == $teamId){
            $this->opponentTeamId = $match->homeTeam->id;
            $this->opponentTeamName = $match->homeTeam->name;
        }
        else{
            $this->opponentTeamId = $match->awayTeam->id;
            $this->opponentTeamName = $match->awayTeam->name;
        }
    }
    
    public function getLocationInformation($match) {
        $this->localTeamAddres = $this->apiClient->getTeamById($match->homeTeam->id)->address;
        $this->localTeamVenue = $this->apiClient->getTeamById($match->homeTeam->id)->venue;
    }
}

