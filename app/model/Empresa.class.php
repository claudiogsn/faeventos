<?php
/**
 * Empresa Active Record
 * @author  <your-name-here>
 */
class Empresa extends TRecord
{
    const TABLENAME = 'empresa';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('cnpj');
        parent::addAttribute('data_criacao');
    }


}
