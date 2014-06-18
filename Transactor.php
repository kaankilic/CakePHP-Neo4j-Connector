<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Transactor
 *
 * @author kaan
 */
App::uses("Node", "Lib");
App::uses("Relationships", "Lib");
App::uses("Path", "Lib");

class Transactor {

    var $HOSTNAME = "brain.kaankilic.com";
    var $PORT = "7474";
    var $Response = null;

    public function ExecuteChyper($Query) {
        $Data = array(
            "query" => $Query,
            "params" => array("test" => "test")
        );
        $Data = json_encode($Data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://' . $this->HOSTNAME . ':' . $this->PORT . '/db/data/cypher/');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json; charset=UTF-8', 'Content-Type: application/json', 'Content-Length: ' . strlen($Data), 'X-Stream: true'));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $Data);
        $ReturnedResponse = curl_exec($curl);
        curl_close($curl);
        $this->Response = json_decode($ReturnedResponse);
        return json_decode($ReturnedResponse);
    }

    public function DjikstraSinglePath($ToNode) {
        $Data = array(
            "to" => 'http://' . $this->HOSTNAME . ':' . $this->PORT . '/db/data/node/' . $ToNode,
            "cost_property" => "Distance",
            "relationships" => array(
                "type" => "ROUTE"
            ),
            "algorithm" => "dijkstra"
        );
        $Data = json_encode($Data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://' . $this->HOSTNAME . ':' . $this->PORT . '/db/data/node/' . $ToNode . '/path');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json; charset=UTF-8', 'Content-Type: application/json', 'Content-Length: ' . strlen($Data), 'X-Stream: true'));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $Data);
        $ReturnedResponse = curl_exec($curl);
        curl_close($curl);
        //$this->Response = json_decode($ReturnedResponse);
        return json_decode($ReturnedResponse);
    }

    public function GetDetail($URL) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $URL);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json; charset=UTF-8', 'Content-Type: application/json'));
        $result1 = curl_exec($curl);
        curl_close($curl);
        return json_decode($result1);
    }

    public function GetResponse() {
        $data = array();
        $Response = $this->Response;
        $ReturnedResponse = array();
        if (empty($Response->data)) {
            $Response = array();
        } else {
            $path = new Path();
            for ($i = 0; $i < count($Response->data[0][0]->nodes); $i++) {
                $Node = $Response->data[0][0]->nodes[$i];
                $NodeLabel = $this->GetDetail($Node . "/labels");
                $NodeProperty = $this->GetDetail($Node . "/properties");
                $node = new Node();
                $NodeURL = array_reverse(preg_split("#/#i",$Node));
                foreach ($NodeLabel as $Label) {
                    $node->SetLabel($Label);                    
                }
                $node->SetID($NodeURL[0]);
                foreach ($NodeProperty as $Key => $Property) {
                    $node->SetProperty($Key, $Property);
                }
                $path->SetNodes($node);
            }
            for ($i = 0; $i < count($Response->data[0][0]->relationships); $i++) {
                $Relationship = $Response->data[0][0]->relationships[$i];
                $RelationshipProperty = $this->GetDetail($Relationship . "/properties");
                $relationship = new Relationships();
                $SelfRelationship = $this->GetDetail($Relationship);
                $StartURL = array_reverse(preg_split("#/#i",$SelfRelationship->start));
                $EndURL = array_reverse(preg_split("#/#i",$SelfRelationship->end));
                $TypeURL = array_reverse(preg_split("#/#i",$SelfRelationship->type));
                $relationship->SetStart($StartURL[0]);
                $relationship->SetEnd($EndURL[0]);
                $relationship->SetType($TypeURL[0]);
                foreach ($RelationshipProperty as $Key => $Property) {
                    $relationship->SetProperty($Key, $Property);
                }
                $path->SetRelationship($relationship);
            }
            $Response = $path->GetFullPath();
        }
        return $Response;
    }

}
