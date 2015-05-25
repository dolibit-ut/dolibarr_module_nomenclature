<?php

class TNomenclature extends TObjetStd
{
    
    function __construct() 
    {
        $this->set_table(MAIN_DB_PREFIX.'nomenclature');
        $this->add_champs('title');
        $this->add_champs('fk_product',array('type'=>'integer', 'index'=>true));
        
        $this->_init_vars();
        
        $this->start();
        
        $this->setChild('TNomenclatureDet', 'fk_nomenclature');            
    }   
    
    static function get(&$PDOdb, $fk_product) {
        
        
        
        $Tab = $PDOdb->ExecuteAsArray("SELECT rowid FROM ".MAIN_DB_PREFIX."nomenclature WHERE fk_product=".$fk_product);
        
        $TNom=array();
        
        foreach($Tab as $row) {
            
            $n=new TNomenclature;
            $n->load($PDOdb, $row->rowid);
            
            $TNom[] = $n;
            
        }
        
        return $TNom;
        
    }
    
}


class TNomenclatureDet extends TObjetStd
{
    
    static $TType=array(
        1=>'Principal'
        ,2=>'Secondaire'
        ,3=>'Consommable'
    );
    
    function __construct() 
    {
        $this->set_table(MAIN_DB_PREFIX.'nomenclaturedet');
        $this->add_champs('fk_product,product_type,fk_nomenclature',array('type'=>'integer', 'index'=>true));
        $this->add_champs('qty',array('type'=>'float'));
        
        $this->_init_vars();
        
        $this->start();
        
        $this->qty=1;
        $this->product_type=1;        
    }   
}
