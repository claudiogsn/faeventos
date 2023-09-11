<?php
/**
 * EventoList Listing
 * @author  <your name here>
 */
class EventoList extends TPage
{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    protected $formgrid;
    protected $deleteButton;
    
    use Adianti\base\AdiantiStandardListTrait;
    
    /**
     * Page constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->setDatabase('communication');            // defines the database
        $this->setActiveRecord('Evento');   // defines the active record
        $this->setDefaultOrder('id', 'asc');         // defines the default order
        $this->setLimit(10);
        // $this->setCriteria($criteria) // define a standard filter

        $this->addFilterField('nome', 'like', 'nome'); // filterField, operator, formField
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_search_Evento');
        $this->form->setFormTitle('Evento');
        

        // create the form fields
        $nome = new TEntry('nome');


        // add the fields
        $this->form->addFields( [ new TLabel('Nome') ], [ $nome ] );


        // set sizes
        $nome->setSize('100%');

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );
        
        // add the search form actions
        $btn = $this->form->addAction(_t('Find'), new TAction([$this, 'onSearch']), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addActionLink(_t('New'), new TAction(['EventoForm', 'onEdit']), 'fa:plus green');
        
        // creates a Datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_id = new TDataGridColumn('id', 'ID', 'right');
        $column_nome = new TDataGridColumn('nome', 'Nome', 'left');
        $column_dt_inicio = new TDataGridColumn('dt_inicio', 'Dt Inicio', 'left');
        $column_dt_fim = new TDataGridColumn('dt_fim', 'Dt Fim', 'left');
        $column_local = new TDataGridColumn('local', 'Local', 'left');
        $column_empresa_id = new TDataGridColumn('empresa_id', 'Empresa', 'center');
        $column_certificado_caminho = new TDataGridColumn('certificado_caminho', 'Certificado Caminho', 'left');
        $column_ativo = new TDataGridColumn('ativo', 'Ativo', 'center');
        $column_data_criacao = new TDataGridColumn('data_criacao', 'Data Criacao', 'center');


        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_nome);
        $this->datagrid->addColumn($column_dt_inicio);
        $this->datagrid->addColumn($column_dt_fim);
        $this->datagrid->addColumn($column_local);
        $this->datagrid->addColumn($column_empresa_id);
        $this->datagrid->addColumn($column_certificado_caminho);
        $this->datagrid->addColumn($column_ativo);
        $this->datagrid->addColumn($column_data_criacao);


        // creates the datagrid column actions
        $column_id->setAction(new TAction([$this, 'onReload']), ['order' => 'id']);

        // define the transformer method over image
        $column_dt_inicio->setTransformer( function($value, $object, $row) {
            if ($value)
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y');
                }
                catch (Exception $e)
                {
                    return $value;
                }
            }
            return $value;
        });

        // define the transformer method over image
        $column_dt_fim->setTransformer( function($value, $object, $row) {
            if ($value)
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y');
                }
                catch (Exception $e)
                {
                    return $value;
                }
            }
            return $value;
        });


        
        $action1 = new TDataGridAction(['EventoFeed', 'onFeed'], ['id'=>'{id}']);
        $action2 = new TDataGridAction([$this, 'onDelete'], ['id'=>'{id}']);
        
        $this->datagrid->addAction($action1, _t('Event'),   'far:user blue');
        $this->datagrid->addAction($action2 ,_t('Delete'), 'far:trash-alt red');
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));
        
        $panel = new TPanelGroup('', 'white');
        $panel->add($this->datagrid);
        $panel->addFooter($this->pageNavigation);
        
        // header actions
        $dropdown = new TDropDown(_t('Export'), 'fa:list');
        $dropdown->setPullSide('right');
        $dropdown->setButtonClass('btn btn-default waves-effect dropdown-toggle');
        $dropdown->addAction( _t('Save as CSV'), new TAction([$this, 'onExportCSV'], ['register_state' => 'false', 'static'=>'1']), 'fa:table blue' );
        $dropdown->addAction( _t('Save as PDF'), new TAction([$this, 'onExportPDF'], ['register_state' => 'false', 'static'=>'1']), 'far:file-pdf red' );
        $panel->addHeaderWidget( $dropdown );
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add($panel);
        
        parent::add($container);
    }
}
