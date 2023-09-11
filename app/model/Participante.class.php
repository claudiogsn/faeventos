<?php
/**
 * Participante Active Record
 * @author  <your-name-here>
 */
class Participante extends TRecord
{
    const TABLENAME = 'participante';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    private $empresa;
    private $evento;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('nome_cracha');
        parent::addAttribute('cpf');
        parent::addAttribute('telefone');
        parent::addAttribute('email');
        parent::addAttribute('empresa_id');
        parent::addAttribute('evento_id');
        parent::addAttribute('presenca');
        parent::addAttribute('impressao_cracha');
        parent::addAttribute('impressao_certificado');
        parent::addAttribute('data_criacao');
        parent::addAttribute('origem_cadastro');
    }

    
    /**
     * Method set_empresa
     * Sample of usage: $participante->empresa = $object;
     * @param $object Instance of Empresa
     */
    public function set_empresa(Empresa $object)
    {
        $this->empresa = $object;
        $this->empresa_id = $object->id;
    }
    
    /**
     * Method get_empresa
     * Sample of usage: $participante->empresa->attribute;
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
    
    
    /**
     * Method set_evento
     * Sample of usage: $participante->evento = $object;
     * @param $object Instance of Evento
     */
    public function set_evento(Evento $object)
    {
        $this->evento = $object;
        $this->evento_id = $object->id;
    }
    
    /**
     * Method get_evento
     * Sample of usage: $participante->evento->attribute;
     * @returns Evento instance
     */
    public function get_evento()
    {
        // loads the associated object
        if (empty($this->evento))
            $this->evento = new Evento($this->evento_id);
    
        // returns the associated object
        return $this->evento;
    }
    


}
