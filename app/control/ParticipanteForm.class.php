<?php
/**
 * ParticipanteForm Form
 * @author  <your name here>
 */
class ParticipanteForm extends TPage
{
    protected $form; // form
    
    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_Participante');
        $this->form->setFormTitle('Participante');
        

        // create the form fields
        $id = new THidden('id');
        $nome = new TEntry('nome');
        $nome_cracha = new TEntry('nome_cracha');
        $cpf = new TEntry('cpf');
        $telefone = new TEntry('telefone');
        $email = new TEntry('email');
        $empresa_id = new TDBUniqueSearch('empresa_id', 'communication', 'Empresa', 'id', 'nome');
        $evento_id = new TDBUniqueSearch('evento_id', 'communication', 'Evento', 'id', 'nome');
        //$presenca = new THidden('presenca');
        //$impressao_cracha = new THidden('impressao_cracha');
        //$impressao_certificado = new THidden('impressao_certificado');
        //$data_criacao = new THidden('data_criacao');
        //$origem_cadastro = new THidden('origem_cadastro');


        // add the fields
        $this->form->addFields( [ new TLabel('') ], [ $id ] );
        $this->form->addFields( [ new TLabel('Nome :') ], [ $nome ] );
        $this->form->addFields( [ new TLabel('Nome Cracha :') ], [ $nome_cracha ] );
        $this->form->addFields( [ new TLabel('CPF :') ], [ $cpf ] );
        $this->form->addFields( [ new TLabel('Telefone :') ], [ $telefone ] );
        $this->form->addFields( [ new TLabel('Email :') ], [ $email ] );
        $this->form->addFields( [ new TLabel('Empresa :') ], [ $empresa_id ] );
        $this->form->addFields( [ new TLabel('Evento :') ], [ $evento_id ] );
       // $this->form->addFields( [ new TLabel('Presenca') ], [ $presenca ] );
        //$this->form->addFields( [ new TLabel('Impressao Cracha') ], [ $impressao_cracha ] );
        //$this->form->addFields( [ new TLabel('Impressao Certificado') ], [ $impressao_certificado ] );
        //$this->form->addFields( [ new TLabel('Data Criacao') ], [ $data_criacao ] );
        //$this->form->addFields( [ new TLabel('Origem Cadastro') ], [ $origem_cadastro ] );

        $nome->addValidation('Nome', new TRequiredValidator);
        $cpf->addValidation('CPF', new TRequiredValidator);
        $telefone->addValidation('Telefone', new TRequiredValidator);


        // set sizes
        $id->setSize('100%');
        $nome->setSize('50%');
        $nome_cracha->setSize('50%');
        $cpf->setSize('50%');
        $telefone->setSize('50%');
        $email->setSize('50%');
        $empresa_id->setSize('50%');
        $evento_id->setSize('50%');
        //$presenca->setSize('100%');
        //$impressao_cracha->setSize('100%');
        //$impressao_certificado->setSize('100%');
        //$data_criacao->setSize('100%');
       // $origem_cadastro->setSize('100%');



        if (!empty($id))
        {
            $id->setEditable(FALSE);
        }
        
        /** samples
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( '100%' ); // set size
         **/
         
        // create the form actions
        $btn = $this->form->addAction(_t('Save'), new TAction([$this, 'onSave']), 'fa:save');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addActionLink(_t('New'),  new TAction([$this, 'onEdit']), 'fa:eraser red');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 70%';
        $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        
        parent::add($container);
    }

    /**
     * Save form data
     * @param $param Request
     */
    public function onSave( $param )
    {
        try
        {
            TTransaction::open('communication'); // open a transaction
            
            /**
            // Enable Debug logger for SQL operations inside the transaction
            TTransaction::setLogger(new TLoggerSTD); // standard output
            TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
            **/
            
            $this->form->validate(); // validate form data
            $data = $this->form->getData(); // get form data as array
            
            $object = new Participante;  // create an empty object
            $object->fromArray( (array) $data); // load the object with data
            $object->store(); // save the object
            
            // get the generated id
            $data->id = $object->id;
            
            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction
            
            new TMessage('info', AdiantiCoreTranslator::translate('Record saved'));
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }
    
    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(TRUE);
    }
    
    /**
     * Load object to form data
     * @param $param Request
     */
    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open('communication'); // open a transaction
                $object = new Participante($key); // instantiates the Active Record
                $this->form->setData($object); // fill the form
                TTransaction::close(); // close the transaction
            }
            else
            {
                $this->form->clear(TRUE);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
}
