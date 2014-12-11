<?php

namespace app\models;
require include_once '../extensions/helper/Git.php/Git.php';

class UserGit {

    private $user;
    private $root;
    private $userDirectory;
    private $directoryContents;
    private $remote;
    private $git;
    private $userRepo;

    public function __construct($user,$remote){
        $this->user = $user;
        $this->userDirectory = $this->root . "/". $user;
        $this->remote = $remote;
        $this->git =new \Git();
    }

    public function initializeGit(){
        $userRepo=$this->git->clone_remote($this->userDirectory,$this->remote);
        $this->directoryContents = scandir($this->userDirectory);
    }

    public function commitChanges(){

    }

    public function reset(){
    }

}