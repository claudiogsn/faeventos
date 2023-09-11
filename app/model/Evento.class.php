<?php
/**
 * Evento Active Record
 * @author  <your-name-here>
 */
class Evento extends TRecord
{
    const TABLENAME = 'evento';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    private $empresa;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('dt_inicio');
        parent::addAttribute('dt_fim');
        parent::addAttribute('local');
        parent::addAttribute('empresa_id');
        parent::addAttribute('certificado_caminho');
        parent::addAttribute('ativo');
        parent::addAttribute('data_criacao');
    }

    
    /**
     * Method set_empresa
     * Sample of usage: $evento->empresa = $object;
     * @param $object Instance of Empresa
     */
    public function set_empresa(Empresa $object)
    {
        $this->empresa = $object;
        $this->empresa_id = $object->id;
    }
    
    /**
     * Method get_empresa
     * Sample of usage: $evento->empresa->attribute;
     * @returns Empresa instance
     */
    public function get_empresa()
    {
        // loads the associated object
        if (empty($this->empresa))
            $this->empresa = new Empresa($this->empresa_id);
    
        // returns the associated object
        return $this->empresa;
    }
    


}
