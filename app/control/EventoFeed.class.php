<?php
class EventoFeed extends TPage
{
    private $form;
    public function __construct($param)
    {
        parent::__construct();

        $id = $param['key'];

        if($_SERVER['SERVER_NAME'] == "localhost"){
            $link = "http://".$_SERVER['SERVER_NAME']."/faeventos/feed/evento.php?id={$id}";
        }else{
            $link = "http://".$_SERVER['SERVER_NAME']."/faeventos/feed/evento.php?id={$id}";
        }

        $iframe = new TElement('iframe');
        $iframe->id = "iframe_external";
        $iframe->src = $link;
        $iframe->frameborder = "0";
        $iframe->scrolling = "yes";
        $iframe->width = "100%";
        $iframe->height = "1000px";

        parent::add($iframe);
    }
    function onFeed($param){
        $id = $param['key'];
    }
}
