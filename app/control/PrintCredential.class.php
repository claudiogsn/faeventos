<?php
class PrintCredential extends TWindow
{
    private $form;
    
    function __construct($param)
    {
        

        parent::__construct();
        parent::setTitle('Realizar Impressão');
        parent::setSize(0.8, 200);

        $id = $param['key'];

        if($_SERVER['SERVER_NAME'] == "localhost"){
            $link = "http://".$_SERVER['SERVER_NAME']."/faeventos/credencial/print.php?id={$id}";
        }else{
            $link = "https://".$_SERVER['SERVER_NAME']."/credencial/print.php?id={$id}";
        }

        $iframe = new TElement('iframe');
        $iframe->id = "local";
        $iframe->src = $link;
        $iframe->frameborder = "0";
        $iframe->scrolling = "yes";
        $iframe->width = "100%";
        $iframe->height = "100%";
        parent::add($iframe);          
    }
    function onPrint($param){
        $id = $param['key'];
    }
}
