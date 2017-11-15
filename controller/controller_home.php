<?php
//namespace Controller;

use Lib\model_base;

use Lib\Controller_base;

class controller_home extends Controller_base
{
    public $model;
    public function __construct()
    {
        //$this->model = new Login_Model();
    }

    public function action_browse()
    {
        // echo "asdf";


        include VIEW_PATH . 'header.php';
        include VIEW_PATH . 'select.php';
        include VIEW_PATH . 'narrative.php';
        include VIEW_PATH . 'modaldialog.php';
    }
    public function action_gettumor()
    {
        $this->model = new Tumor_Model();
        $result=$this->model->getTumor();
        $this->send_plaintext($result);
    }
    public function action_getgenes()
    {
        $this->model = new Tumor_Model();
        $result=$this->model->getGenes();
        $this->send_plaintext($result);
    }
    public function action_getgenemutations()
    {
        $this->model = new Tumor_Model();
        $result=$this->model->getGeneMutations();
        $this->send_plaintext($result);
    }
    public function action_getnarrative()
    {
        $this->model = new Tumor_Model();
        $result=$this->model->getNarrative();
        $this->send_plaintext($result);
    }
    public function action_savecomment()
    {
        $this->model = new Tumor_Model();
        $result=$this->model->saveComment();
        $this->send_plaintext($result);
    }
    public function action_getcomment()
    {
        $this->model = new Tumor_Model();
        $result=$this->model->getComment();
        $this->send_json($result);
    }
    public function action_getnarrativeList()
    {
        $this->model = new Tumor_Model();
        $this->model->getNarrativeList();
        //$this->send_json($result);
    }
    public function action_saveNarrative()
    {
        $this->model = new Tumor_Model();
        $this->model->saveNarrative();
        //$this->send_json($result);
    }
}
