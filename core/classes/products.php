<?php
namespace Core\Classes;
use core\classes\dbWrapper\db;
use Core\Classes\Privates\User;
use Core\Classes\Utils\Utils;
use Core\Classes\Traits\Barcode;

class Products
{
    use Barcode;

    private $db;
    private $user;
    
    public function __construct()
    {
        $this->user = new User;
        $this->db = new db;
    }


    /**
     * Удалить товар
     * 
     * @param int $product_id
     */
    public function deleteProduct(int $product_id)
    {
        $update_data = [
            'before' => 'UPDATE stock_list SET ',
            'after' => ' WHERE stock_id = :prod_id ',
            'post_list' => [
                'id' => [
                    'query' => ' stock_list.stock_visible = 1 ',
                    'bind' => 'prod_id'
                ]
            ]
        ];
    
        $this->db->update($update_data, [
            'id' => $product_id
        ]);
    }


    /**
     * Добавить товар
     */
    public function addProduct($prepareData)
    {
        $data = [];

        $col_post_list = [
            'add_stock_name' => [	
                'col_name' => 'stock_name',
                'required' => true
            ],
            'add_stock_description' => [ 
                'col_name' => 'stock_phone_imei' 
            ],
            // 'add_stock_provider_id' => [
            // 	'col_name' => 'product_provider'
            // ],
            // 'add_stock_category_id' => [
            // 	'col_name' => 'product_category'
            // ],
            'add_stock_count' => [
                'col_name' => 'stock_count'
            ],	
            'add_stock_min_quantity' => [
                'col_name' => 'min_quantity_stock'
            ],
            'add_stock_first_price' => [
                'col_name' => 'stock_first_price',
                'required' => true 
            ],
            'add_stock_second_price' => [
                'col_name' => 'stock_second_price' 
            ],
            // 'add_stock_barcode' => [
            // 	'col_name' => 'barcode_article'
            // ]	
        ];

        foreach ($col_post_list as $key => $value) {
            if(array_key_exists($key, $prepareData)) {
                $data = array_merge($data, [
                    $value['col_name'] => $prepareData[$key]
                ]);
            }
        }
                

        $default_data = [
            'stock_visible' 	=> 0,
            'stock_get_fdate' 	=> date("d.m.Y"),
            'stock_get_year' 	=> date("m.Y"),
            'product_added' 	=> $this->user->getUser('get_id')
        ];
    
        $data = array_merge($data, $default_data);      
    
		// создаем новый товар
		$this->db->insert('stock_list', [$data]);
    }


    /**
     * редактировать товар
     * @param array $data
    */
    public function editProduct($data)
    {
        // в первом массиве мы должны описать и связвать данные $postData с таблицей
        $option = [
            'before' => " UPDATE stock_list, user_control SET ",
            'after' => " WHERE stock_id =:stock_id ",
            'post_list' => [
                //id
                'upd_product_id' => [ 
                    'query' => false,
                    'bind' => 'stock_id',
                    'require' => true
                ],	
                //изменить название товра
                'product_name' => [
                    'query' => "stock_list.stock_name = :prod_name",
                    'bind' => 'prod_name',
                ],
                //изменить описание товара (старое imei)
                'product_description' => [
                    'query' => "stock_list.stock_phone_imei = :prod_imei",
                    'bind' => 'prod_imei'
                ],
                //изменить количество товара
                'plus_minus_product_count' => [
                    'query' => "stock_list.stock_count = :add_count",
                    'bind' => 'add_count',
                ],		
                //прибавить n-количсестов товара 
                'append_stock_count' => [
                    'query' => "stock_list.stock_count = stock_list.stock_count + :append_count",
                    'bind' => 'append_count',
                ],		
                //изменить себе стоимость товара
                'product_first_price' => [
                    'query' => "stock_list.stock_first_price = :f_price",
                    'bind' => 'f_price',
                ],
                //изменить стоимость
                'product_second_price' => [
                    'query' => "stock_list.stock_second_price = :s_price",
                    'bind' => 's_price'
                ],
                //изменить минимальное количество товара
                'change_min_quantity' => [
                    'query' => "stock_list.min_quantity_stock = :min_count",
                    'bind' => 'min_count',	
                ],

                //изменить количество товара
                'change_product_count' => [
                    'query' => "stock_list.stock_count = :change_count",
                    'bind' => 'change_count',
                ],		
                
                //последнее изминение товара
                'last_edited_date' => [
                    'query' => "stock_list.last_edited_date = :last_date",
                    'bind' => 'last_date'
                ]
            ]
        ];


        $default_data = [
            'last_edited_date' => date('Y-m-d h:i:s')
        ];

        $data = array_merge($data, $default_data);

	    $this->db->update($option, $data);
    }


    /**
     * Изменить название твоара
     * @param int $productId - id товара
     * @param string $newName - название товара
     */
    public function editProductName($productId, $newName)
    {
        $this->editProduct([
            'upd_product_id' => $productId,
            'product_name' => $newName
        ]);
    }

    /**
     * Изменить описание твоара
     * @param int $productId - id товара
     * @param string $description - описание товара
     */
    public function editProductDescription($productId, $description)
    {
        $this->editProduct([
            'upd_product_id' => $productId,
            'product_description' => $description
        ]);
    }    


    /**
     * изменить кличнство товара после продажи
     * @param array $data|stock_id|order_stock_id
     */
    public function updateStockAfterSale($data) 
    {
        // полсе добавления товра в базу, обновляем данные товара, уменьшаем количестов товара
        foreach($data as $index => $data) {
            $this->decreaseProductCount($data);
        }
    }


    /**
     * Уменьшить количество товара 
     * @param array stock_id|product_count
     */
    public function decreaseProductCount($data) 
    {
        $option = [
            'before' => " UPDATE stock_list SET ",
            'after' => " WHERE stock_id = :stock_id",
            'post_list' => [
                'stock_id' => [
                    'query' => false,
                    'bind' => 'stock_id'
                ],
                'product_count' => [
                    'query' => "stock_list.stock_count = stock_list.stock_count - :product_count",
                    'bind' => 'product_count'
                ]
            ]
        ];

        $this->db->update($option, $data);
    }


    /**
     * Увеличить количсество товара
     * @param array stock_id|product_count
     */
    public function increaseProductCount($data) 
    {
        $option = [
            'before' => " UPDATE stock_list SET ",
            'after' => " WHERE stock_id = :stock_id",
            'post_list' => [
                'stock_id' => [
                    'query' => false,
                    'bind' => 'stock_id'
                ],
                'product_count' => [
                    'query' => "stock_list.stock_count = stock_list.stock_count + :product_count",
                    'bind' => 'product_count'
                ]
            ]
        ];

        $this->db->update($option, $data);
    }



    /**
     * получаем список категории id товара
     * @param int $id
     * 
     * old function get_products_categorty_list
     */
    public function getProductCategory($id) 
    {
        $cat = $this->db->select([
            'table_name' => ' user_control ',
            'col_list' => ' * ',
            'query' => [                
                'base_query' => ' INNER JOIN products_category_list ON products_category_list.id_from_stock = :id 
                                LEFT JOIN stock_category ON stock_category.category_id = products_category_list.id_from_category
                ',
                'sort_by' => ' GROUP BY products_category_list.id ASC ORDER BY products_category_list.id ASC '
            ],
            'bindList' => array(
                ":id" => $id
            ),
        
        ])->get();

        return $cat;
    }

    
    /**
     * Изменяем категорию товара
     * @param array $data
     * @param array product_id|old_category_id|edited_category_id
     *
     * function old name edit_product_category
     */
    public function editProductCategory($data) 
    {
        $option = [
            'before' => " UPDATE products_category_list SET ",
            'after' => " WHERE id_from_stock =:stock_id AND id_from_category = :old_id",
            'post_list' => [
                //id
                'product_id' => [ 
                    'query' => false,
                    'bind' => 'stock_id',
                    'require' => true
                ],			
                'old_category_id' => [ 
                    'query' => false,
                    'bind' => 'old_id',
                    'require' => true
                ],
                'edited_category_id' => [
                    'query' => ' id_from_category = :new_id ',
                    'bind' => 'new_id',
                    'require' => true
                ]
            ]
        ];

        foreach ($data as $key => $collect_data) {
            $this->db->update($option, $collect_data);
        }
    }


    /**
     * Добавляем категорию для товара
     * @param int $product_id
     * @param array $data
     * 
     * old function name add_product_category 
     */
    public function setProductCategory($product_id, $data) 
    {
        $collect_data = [];
        
        foreach ($data as $key => $val) {
            if(!empty($val['get_new_id'])) {
                $collect_data[] = [
                    'id_from_category' => $val['get_new_id'],
                    'id_from_stock' => $product_id
                ];
            }
        }

        if(!empty($collect_data)) {
            $this->db->insert('products_category_list', $collect_data);
        }
    }

    /**
     * Удаляем категори для товара
     * @param array $data  
     * 
     * old function name delete_product_category
     */
    public function deleteProductCategory($data) 
    {
        foreach ($data as $key => $val) {
            $this->db->delete([
                [
                    'table_name' => 'products_category_list',
                    'joins'	=> '',
                    'where' => ' id_from_stock = :stock_id AND id_from_category = :cat_id ',
                    'bindList' => [
                        ':stock_id' => $val['product_id'],
                        ':cat_id' => $val['del_id']
                    ],
                ]
            ]);
        }
    }    


    /**
     * Добавляем поставщика для товара
     * @param int $product_id
     * @param array $data 
     * 
     * old function name add_product_provider
     */
    public function setProductProvider($product_id, $data) 
    {
        $collect_data = [];
        
        foreach ($data as $key => $val) {
            if(!empty($val['get_new_id'])) {
                $collect_data[] = [
                    'id_from_provider' => $val['get_new_id'],
                    'id_from_stock' => $product_id
                ];
            }
        }
        
        if(!empty($collect_data)) {
            $this->db->insert('products_provider_list', $collect_data);
        }
    }


    /**
     * Изменяем поставщика товара
     * @param array $data
     * @param array product_id|old_provider_id|edited_provider_id
     * 
     * old function name edit_product_provider
     */
    public function editProductProvider($data) 
    {
        $option = [
            'before' => " UPDATE products_provider_list SET ",
            'after' => " WHERE id_from_stock =:stock_id AND id_from_provider = :old_id",
            'post_list' => [
                //id
                'product_id' => [ 
                    'query' => false,
                    'bind' => 'stock_id',
                    'require' => true
                ],			
                'old_provider_id' => [ 
                    'query' => false,
                    'bind' => 'old_id',
                    'require' => true
                ],
                'edited_provider_id' => [
                    'query' => ' id_from_provider = :new_id ',
                    'bind' => 'new_id',
                    'require' => true
                ]
            ]
        ];

        foreach ($data as $key => $collect_data) {
            $this->db->update($option, $collect_data);
        }
    }



    /**
     * получаем список поставщика id товара
     * @param int $id
     * old function name get_products_provider_list
     */
    public function getProductProvider($id) 
    {
        $provider = $this->db->select([
            'table_name' => ' user_control ',
            'col_list' => ' * ',
            'query' => [
                'base_query' => ' INNER JOIN products_provider_list ON products_provider_list.id_from_stock = :id 
                                LEFT JOIN stock_provider ON stock_provider.provider_id = products_provider_list.id_from_provider
                ',
                'sort_by' => ' GROUP BY products_provider_list.id ASC ORDER BY products_provider_list.id ASC '
            ],
            'bindList' => array(
                ":id" => $id
            )            
        
        ])->get();

        return $provider;
    }

    
    /**
     * Удаляем поставщика для товара
     * @param array $data  
     * 
     * old function name delete_product_provider
     */
    public function deleteProductProvider($data) 
    {
        foreach ($data as $key => $val) {
            $this->db->delete([
                [
                    'table_name' => 'products_provider_list',
                    'joins'	=> '',
                    'where' => ' id_from_stock = :stock_id AND id_from_provider = :cat_id ',
                    'bindList' => [
                        ':stock_id' => $val['product_id'],
                        ':cat_id' => $val['del_id']
                    ],
                ]
            ]);
        }
    }

    

    
    /**
     * Получить товар по id 
     */
    public function getProductById(int $id) 
    {
        return $this->db->select([
            'table_name' => 'stock_list',
            'col_list' => '*',
            'query' => [
                'base_query' => ' WHERE stock_id = :id ',
            ],
            'bindList' => [
                ':id' => $id
            ]        
        ])->first()->get();
    }


    /**
     * Получить последний добавленный товар
     * 
     * @param string $column какой столбец вывести
     * @return array|string|false
     */
    public function getLastAddedProduct($column = false)
    {
        $data = $this->db->select([
            'table_name' => 'stock_list',
            'col_list' => '*',
            'query' => [
                'base_query' => ' WHERE stock_visible = 0 ',
                'sort_by' => 'ORDER BY stock_id DESC LIMIT 1'
            ]
        ])->first()->get();
        
        return !empty($column) ? $data[$column] : $data;
     }    
}