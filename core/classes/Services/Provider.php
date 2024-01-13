<?php 
namespace Core\Classes\Services;

use \Core\classes\dbWrapper\db;

class Provider 
{
    private $db;

    public function __construct()
    {
        $this->db = new db;
    }

    /**
     * получаем список поставщиков
     * @return array|null
     * old function name get_provider_list
     **/ 
    public function getProviderList() 
    {
        return $this->db->select([
            'table_name' => ' stock_provider ',
            'col_list' => ' * ',
            'base_query' => ' WHERE visible = "visible" ',
            'param' => [
                'query' => [
                    'param' => '',
                    'joins' => '',
                    'bindList' => array(
                    )
                ],
                'sort_by' => 'ORDER BY provider_id DESC'
            ]
        ])->get();
    }
}