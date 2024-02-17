<?php

namespace Core\Classes\System;

class Utils extends \Core\Classes\dbWrapper\db 
{


    /**
     * 
     * @param int $price
     * @return int
     * old function name decorate_num
     */
    public static function prettyPrintNumber($price) 
    {
        return number_format($price, 0, '', ' ');
    }
    

    /**
     * выводит месяц и год
     * @return date|year month and year
     * 
     * old function name get_my_dateyear
     */
    public function getDateMY() 
    {
        return date("m.Y");
    }

    /**
     * выводит день месяц и год
     * @return day|month|year
     * 
     * old function get_my_datetoday()
     */
    public function getDateDMY() 
    {
        return  date("d.m.Y");
    }
    

    //дебаг функция
    public static function vardump($var) 
    {
        echo "<pre>";
            print_r($var) ;
        echo "</pre>";
    }



    /**
     * Выводить json
     * @param array $arr 
     * @return json|null
     */
    public static function abort(array $arr)
    {
        echo json_encode($arr);
    }

    public static function errorAbort(string $errText) 
    {
        return self::abort([
            'type' => 'error',
            'text' => $errText
        ]);
    }


   /**
     * Получить список способов оплаты
     * @return array|null
     * old function name get_payment_method_list()
     */
    public function getPaymentMethodList() 
    {
        return $this->select([
            'table_name' => 'payment_method_list',
            'col_list' => 'id AS custom_data_id, title AS custom_value, visible, tags_id ',
            'query' => [
                'base_query' => ' WHERE visible = 0 ',
                'sort_by' => '  ORDER BY freeze DESC, id '
            ]
        ])->get();
    }

    /**
     * 
     * 
     * 
     */
    public function getTagsList($user_payment_list, $default_tags = null) 
    {
        $default_data = [
            [
                'tags_id' => 'success',
                'class_list' => 'mark mark-tags mark-success-fill width-100 height-100',
            ],
            [
                'tags_id' => 'success-light',
                'class_list' => 'mark mark-tags mark-success width-100 height-100',
            ],
            [
                'tags_id' => 'danger',
                'class_list' => 'mark mark-tags mark-danger-fill width-100 height-100'
            ],
            [
                'tags_id' => 'danger-light',
                'class_list' => 'mark mark-tags mark-danger width-100 height-100'
            ],		
            [
                'tags_id' => 'rose',
                'class_list' => 'mark mark mark-tags mark-rose width-100 height-100'
            ],		
            [
                'tags_id' => 'warning', 
                'class_list' => 'mark mark-tags mark-warning width-100 height-100'
            ],
            [
                'tags_id' => 'primary',                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
                'class_list' => 'mark mark-tags mark-primary width-100 height-100'
            ],
            [
                'tags_id' => 'black',
                'class_list' => 'mark mark-tags mark-black-fill width-100 height-100'
            ],
            [
                'tags_id' => 'blue',
                'class_list' => 'mark mark-tags mark-blue-fill width-100 height-100'
            ],
            [
                'tags_id' => 'gray',
                'class_list' => 'mark mark-tags mark-gray width-100 height-100'
            ]
        ];
        
        $data_arr = $this->getPaymentMethodList();
        
        // если нужно вывести только добавленные в базу теги способы оплаты 
        if(!empty($user_payment_list) && empty($default_tags)) {
    
            $result = array_reduce($data_arr, function($carry, $item) use ($default_data) {
                foreach($default_data as $default_key => $default_val) {
                    if($item['tags_id'] == $default_val['tags_id']) {
                        $carry[] = array_merge($item, $default_data[$default_key]);
                    } 	
                }
                
                return $carry;
            }, []);
    
            return $result;
        }
    
    
        // если нужно вывести определенны тег (способ оплаты)
        if(!empty($default_tags)) {
            $default_tags_data = [];
    
            if($user_payment_list) {
                $default_tags_data = $data_arr;
            } else {
                $default_tags_data = $default_data;
            }
    
            return array_reduce($default_tags_data, function($carry, $item) use ($default_tags) { 
                    if($item['tags_id'] == $default_tags) {
                        $carry = $item;
                    }
    
    
                    if(!empty($carry)) {
                        return $carry;
                    }
    
                    // если такого тега не найдено
                    return [
                        'tags_id' => 'gray',
                        'class_list' => ' mark-tags mark-default width-100 height-100'
                    ];
            }, []);
            
    
        }
    
        // если нужно вывести только теги 
        return $default_data;
    }    


    /**
     * 
     * old function name table_footer_result
     */
    public function compareTableFooterData($type_list, $data) 
    {
        $res = [];
        $stock_total_count = [];
        $search_result = count($data);
        $sum_stock_first_price = [];
        $sum_profit = 0;
        $sum_order_count = 0;
        $sum_rasxod = 0;
        $sum_sales = 0;
        $sum_margin = 0;
        $sum_card_money = 0;

        foreach($data as $stock) {
            if(array_key_exists('stock_count', $stock)) {
    
                if($stock['stock_count'] > 0) {
                    $stock_total_count[] = $stock['stock_count'];
                }
    
                if(array_key_exists('stock_first_price', $stock)) {
                    if($stock['stock_count'] > 0) {
                        $sum_stock_first_price[] = $stock['stock_first_price'] * $stock['stock_count'];
                    }
                }
            }
    
            if(array_key_exists('order_total_profit', $stock)) {
                $sum_profit += $stock['order_total_profit'];
            }
    
            if(array_key_exists('order_stock_count', $stock)) {
                if($stock['order_stock_count'] > 0 ) {
                    $sum_order_count += $stock['order_stock_count'];
                } 
            }
    
            if(array_key_exists('rasxod_money', $stock)) {
                $sum_rasxod += $stock['rasxod_money'];
            }
    
            if(array_key_exists('order_stock_total_price', $stock)) {
                $sum_sales += $stock['order_stock_total_price'];
            }
    
            if(array_key_exists('payment_method', $stock)) {
                if($stock['payment_method'] == 2) {
                    $sum_card_money += $stock['order_stock_total_price'];
                }
            }
        }
    
        foreach($type_list as $type) {
            //количество товара
            switch ($type) {
                case 'stock_count':
                     array_push($res, [
                        'title' => 'Ümumi say',
                        'value' => $this->prettyPrintNumber(array_sum($stock_total_count)),
                        'mark' 	=> [
                            'mark_text' => 'ədəd',
                            'mark_modify_class' => ''
                        ]
                    ]);
                    break;
                    case 'card_cash':
                        array_push($res, [
                           'title' => 'Kart',
                           'value' => $this->prettyPrintNumber($sum_card_money),
                           'mark' 	=> [
                                'mark_modify_class' => 'mark-icon-manat button-icon-right manat-icon--black'	
                           ]
                       ]);
                       break;				
                case 'sum_total_sales':
                    array_push($res, [
                       'title' => 'Satış',
                       'value' => $this->prettyPrintNumber($sum_sales),
                       'mark' 	=> [
                            'mark_modify_class' => 'mark-icon-manat button-icon-right manat-icon--black'			
                        ]
                   ]);
                   break;				
                case 'search_count': 
                    array_push($res, [
                        'title' => 'Tapıldı',
                        'value' => $this->prettyPrintNumber($search_result),
                        'mark' 	=> [
                            'mark_text' => 'ədəd',
                            'mark_modify_class' => ''
                        ]
                    ]);
                    break;
                case 'sum_first_price': 
                    array_push($res, [
                        'title' => 'Malların ümumi dəyəri',
                        'value' => $this->prettyPrintNumber(array_sum($sum_stock_first_price)),
                        'mark' 	=> [
                            'mark_modify_class' => 'mark-icon-manat button-icon-right manat-icon--black'			
                        ]
                    ]);
                    break;
                case 'sum_profit':
                    array_push($res, [
                        'title' => 'ümumi Mənfəət',
                        'value' => $this->prettyPrintNumber($sum_profit),
                        'mark' 	=> [
                            'mark_modify_class' => 'mark-icon-manat button-icon-right manat-icon--black'			
                        ]
                    ]);
                    break;
                case 'stock_order_count':
                    array_push($res, [
                       'title' => 'Qaimə',
                       'value' => $this->prettyPrintNumber($sum_order_count),
                       'mark' 	=> [
                           'mark_text' => 'ədəd',
                           'mark_modify_class' => ''
                       ]
                   ]);
                   break;
                   
                case 'sum_total_rasxod': 
                    array_push($res, [
                        'title' => 'ümumi xərc',
                        'value' => $this->prettyPrintNumber($sum_rasxod),
                        'mark' => [
                            'mark_modify_class' => 'mark-icon-manat button-icon-right manat-icon--black'
                        ]
                    ]); 
                    break;
                case 'sum_margin': 
                    array_push($res, [
                        'title' => 'Xalis mənfəət',
                        'value' => $this->prettyPrintNumber( $sum_profit - $sum_rasxod),
                        'mark' => [
                            'mark_modify_class' => 'mark-icon-manat button-icon-right manat-icon--black'
                        ]
                    ]); 
                    break;
                    case 'sum_total_sales_margin': 
                        array_push($res, [
                            'title' => 'Qaliq (kassa)',
                            'value' => $this->prettyPrintNumber( ($sum_sales - $sum_rasxod) - $sum_card_money ),
                            'mark' => [
                                'mark_modify_class' => 'mark-icon-manat button-icon-right manat-icon--black'
                            ]
                        ]); 
                        break;				 
                    
            }
        }
    
        return $res;
    }   

}