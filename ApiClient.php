<?php

/**
 * La clase ApiClient implementa los metodos necesarios para consumir los recursos 
 * del API http://api.football-data.org/v2/ y retornar los valores acorde a 
 *
 * @author Nelson
 */
class ApiClient {
    
    private $xAuthTokenHeader = 'X-Auth-Token: d8c436ee07e44a159a0a5b99c82cc486'; 
            
    public function get($uri){
        $reqPrefs['http']['method'] = 'GET';
        $reqPrefs['http']['header'] = $this->xAuthTokenHeader;
        $stream_context = stream_context_create($reqPrefs);
        $response = file_get_contents($uri, false, $stream_context);
        return json_decode($response);       
    }

    public function getTeamById($teamId){
        $uri = 'http://api.football-data.org/v2/teams/'.$teamId;
        return $this->get($uri);
    }
    
    public function getMatchesByTeamId($teamId){
        $uri = 'http://api.football-data.org/v2/teams/'.$teamId.'/matches/';
        return $this->get($uri);
    }
}
