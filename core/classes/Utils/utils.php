<?php

namespace Core\Classes\Utils;

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
        // Проверяем, является ли число дробным
        if (strpos($price, '.') !== false) {
            // Преобразуем число в дробное с двумя знаками после запятой
            $formatted_number = number_format((float)$price, 2, '.', ' ');
        } else {
            // Преобразуем число в целое
            $formatted_number = number_format((float)$price, 0, '.', ' ');
        }

        return $formatted_number;
    }
    

    /**
     * выводит месяц и год
     * @return date|year month and year
     * 
     * old function name get_my_dateyear
     */
    public static function getDateMY() 
    {
        return date("m.Y");
    }

    /**
     * выводит день месяц и год
     * @return day|month|year
     * 
     * old function get_my_datetoday()
     */
    public static function getDateDMY() 
    {
        return  date("d.m.Y");
    }
    

    /**
     * 
     */
    public static function log($var) 
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


    /**
     * 
     */
    public static function errorAbort(string $errText) 
    {
        return self::abort([
            'type' => 'error',
            'text' => $errText
        ]);
    }


    /**
     * 
     */
    public static function getPostPage()
    {
        return $_POST['page'] ?? false;
    }


    /**
     * 
     */
    public static function getPostType()
    {
        return $_POST['type'] ?? false;
    }    



    /**
     * 
     */
    public static function generateTransactionId()
    {
        $new_sault = rand(000000,999999);
        $new_sault2 = rand(000000,555555);
    
        $transaction_id = $new_sault * $new_sault2 / 2;
    
        return (int) $transaction_id;        
    }




    /**
     * 
     * 
     * 
     */
    public static function getTagsList() 
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