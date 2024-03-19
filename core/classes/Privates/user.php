<?php 

namespace Core\Classes\Privates;

use core\classes\dbWrapper\db;

use function PHPSTORM_META\map;

class User
{
    public $db;

    public function __construct()
    {
        $this->db = new db;
    }


    /**
     * получить данные пользователя сесии
     * @param string $get_info
     */
    public function getCurrentUser($get_info = null) 
    {
        if(isset($_SESSION['user'])) {
            $user_id = $_SESSION['user'];
    
            // $ustmp = $this->dbpdo->prepare('SELECT * FROM user_control WHERE user_id = :id');
            // $ustmp->bindParam(':id', $user_id, \PDO::PARAM_INT);
            // $ustmp->execute();
            // $row = $ustmp->fetch(\PDO::FETCH_ASSOC);

            $row = $this->db->select([
                'table_name' => 'user_control',
                'col_list' => '*',
                'query' => [
                    'base_query' => '   WHERE user_id = :id '
                ],
                'bindList' => [
                    ':id' => $user_id
                ]
            ])->first()->get();
        

            switch ($get_info) {
                case 'get_id':
                    return $user_id = $row['user_id'];
                    break;
                case 'get_name':
                    return $user_name = $row['user_name'];
                    break;
                case 'get_role':
                    return $user_role = $row['user_role'];
                    break;
                default:
                    return $row;
                    break;	
            }
        } 

        return null;
    }



    /**
     * old function name get_all_user_list
     * 
     * получить список пользователей
     * 
     * @return array|null
     */
    public function getAllUser()
    {
        return $this->db->select([
            'table_name' => 'user_control',
            'col_list' => '*',
            'query' => [
                'base_query' => ' WHERE user_visible = 0',
                'body' => '',
                'joins' => '',
                'sort_by' => ' ORDER BY user_id',
                'limits'
            ],
            'bindList' => [],
        ])->get();
    }    


    /**
     * Добавляем нового пользователя
     * 
     * old function name add_new_user
     */
    public function addUser($arr) 
    {
        return $this->db->insert('user_control', [
            [
                'user_name' => $arr['seller_name'],
                'user_password' => $arr['seller_password'],
                'user_role'	=> $arr['seller_role']
            ]
        ]);
    }
    


        /**
     * Проверить уникальность логина пользователя
     * @param string $user_name
     * @return boolean  true/false (true - пользователя нет, false - пользователь есть в базе данных) 
     * 
     * old function name is_unique_user
     */
    public function isUsernameAvailable($user_name) 
    {
        $data = $this->db->select([
            'table_name' => 'user_control',
            'col_list'	=> '*',
            'query' => [
                'base_query' => ' WHERE user_name = :user_name ',
            ],
            'bindList' => [
                ':user_name' => $user_name
            ]            
        ])->get();
    

        return empty($data) ? true : false;
    }


    /**
     * 
     * old function name get_last_added_user 
     */
    public function getLastAddedUser() 
    {
        return  $this->db->select([
            'table_name' => 'user_control',
            'col_list' => '*',
            'base_query' => ' WHERE user_visible = 0 ',
            'query' => [
                'sort_by' => ' GROUP BY user_id  DESC ORDER BY user_id DESC ',
                'limit' => 'LIMIT 1'
            ]
        ])->get();
    }    


    /**
     * Удаляем пользователя
     * 
     * old function name delete_user
     */
    public function deleteUser($user_id) 
    {
        $options = [
            'before' => ' UPDATE user_control SET ',
            'after' => ' WHERE user_id = :id ',
            'post_list' => [
                'user_id' => [
                    'query' => ' user_visible = 1  ',
                    'bind' => 'id'  
                ],
            ]
    
        ];
    
        return $this->db->update($options, [
            'user_id' => $user_id
        ]);
    }
        

    /**
     * Редактируем данные пользователя
     * 
     * @param array $arr
     */
    public function editUser($arr) 
    {
        $options = [
            'before' => ' UPDATE user_control SET ',
            'after' => ' WHERE user_id = :id ',
            'post_list' => [
                'seller_id' => [
                    'query' => false,
                    'bind' => 'id'  
                ],
    
                'edit_seller_name' => [
                    'query' => ' user_name = :usr_name  ',
                    'bind' => 'usr_name'
                ],
                'edit_seller_password' => [
                    'query' => ' user_password = :usr_password ',
                    'bind' => 'usr_password'
                ]
            ]
    
        ];
    
        return $this->db->update($options, $arr);
    }
        



    // =====================

    
    /** 
     * открываем сессию и авторизуем пользователя
     * @param string $login
     * @param string $pass
    */
    function user_login($login, $pass) {
        $u_data = ls_db_request([
            'table_name' => 'user_control',
            'col_list' => '*',
            'base_query' => '',
            'param' => [
                'query' => [
                    'param' => ' WHERE `user_name` = :login ',
                    'joins' => '',
                    'bindList' => array(
                        'login' => $login
                    )
                ],
                'sort_by' => ' LIMIT 1'
            ]
        ]);
    
        if(!empty($u_data)) {
            $this_user = $u_data[0];
        
            if($this_user['user_password'] == $pass) {
                $_SESSION['user'] = $this_user['user_id'];
                $_SESSION['time_start_login'] = time();
            
                echo json_encode([
                    'success' => 'ok'
                ]);
                return true;
            } 	
        } 
        echo json_encode([
            'error' => 'Логин или пароль не правильный'
        ]);
    }
    
        
    /**
     * получить данные пользователя по id
     * @param Array $param
     * exaple how to use:
     *  $param = array(
     *  	'action' => 'get_name' or 'get_id', @param string action
     *  	'user_id' => $user_id // id 		@param int user_id
     *  );
     **/
    function get_user_by_id($param) {
        global $dbpdo;
    
    
        $param = (object) $param;
        $action = $param->action;
        $user_id = $param->user_id;
    
        $ustmp = $dbpdo->prepare('SELECT * FROM user_control WHERE user_id = :id');
        $ustmp->bindParam(':id', $user_id, \PDO::PARAM_INT);
        $ustmp->execute();
        $row = $ustmp->fetch();
    
        switch ($action) {
            case 'get_id': 
                return $user_id = $row['user_id'];
                break;
            case 'get_name':
                return $user_name = $row['user_name'];
                break;
            case 'get_role':
                return $user_role = $row['user_role'];
                break;
            case 'get_reg_date':
                return $reg_date = $row['alert_date'];
                break;	
            case 'get_password':
                return $reg_date = $row['user_password'];
                break;						
        }
    }
    
    

    
    
    
    
    
    // Вверху есть функции которые устарели и их нужно обновить
    // все что ниже легасии код, который нужно удалить. 
    
    
    /**
     * обновить данне пользователя
        * example
        * $arr = array(
        * 	'u_id' => $user_id,
        * 	'action' => 'upd_name',
        *	'param' => $param 
        * );
        */
    function update_user_info($arr) {
    
        global $dbpdo;
    
        $user_id 	= $arr['u_id'];
        $action 	= $arr['action'];
        $param 		= $arr['param'];
    
        switch ($action) {
            case 'upd_name':
                $upd = $dbpdo->prepare('UPDATE user_control SET user_name =:param WHERE user_id =:u_id');
                break;
            case 'upd_pass':
                $upd = $dbpdo->prepare('UPDATE user_control SET user_password =:param WHERE user_id =:u_id');
                break;	
            case 'upd_role':
                $upd = $dbpdo->prepare('UPDATE user_control SET user_role =:param WHERE user_id =:u_id');
                break;	
            case 'upd_vsbl':
                $upd = $dbpdo->prepare('UPDATE user_control SET user_visible =:param WHERE user_id =:u_id');
                break;									
        }
        if(!empty($action)) {
            $upd->bindParam('param', $param);
            $upd->bindParam('u_id', $user_id);
            $upd->execute();
        }
    
    }
    
    
    /**
     * добавляем пользователя в базу
     */
     function reg_new_user($dbpdo, $u_name, $u_pass, $u_role, $ordertoday) {
        global $dbpdo;
        $reg_user = $dbpdo->prepare('INSERT INTO user_control (user_id, user_name, user_password, user_role, alert_date) 
            VALUES (NULL, :uname, :upass, :u_role, :cur_date)
        ');
        $reg_user->bindValue('uname', $u_name);
        $reg_user->bindValue('upass', $u_pass);
        $reg_user->bindValue('u_role', $u_role);
        $reg_user->bindValue('cur_date', $ordertoday);
        $reg_user->execute();
    }
    
    
    /**
     * валидация данных пользователя
     */
    function valid_user_info($arr) {
        /** example
         * $valid_arr = array(
         * 	'action' => 'valid_name',
         * 	'param' => ,
         *	'user_id' => $user_id
         * );
         **/
        global $dbpdo;
    
        $res = false;
    
        $action = $arr['action'];
        $param = $arr['param'];
        $user_id = $arr['user_id'];
    
        switch($action) {
            case 'valid_upd_name' : 
                /**
                *проверяем имя пользователя на уникальность по id, если такое имя есть выводим false и сообщение об ошибке
                *если такого имени нет, то выводщим true и обновляем имя пользователя
                */
                $check_name = $dbpdo->prepare('SELECT * FROM user_control WHERE user_name =:u_name AND user_id !=:u_id');
                $check_name->bindParam('u_name', $param);
                $check_name->bindParam('u_id', $user_id);
                $check_name->execute();
                if($check_name->rowCount()>0) {
                    return false;
                } else {
                    return true;
                }
            break;
            case 'valid_reg_name' : 
                /**
                *проверяем имя пользователя на уникальность, если такое имя есть выводим false и сообщение об ошибке
                *если такого имени нет, то выводщим true и обновляем имя пользователя
                */			
                $check_name = $dbpdo->prepare('SELECT * FROM user_control WHERE user_name =:u_name');
                $check_name->bindParam('u_name', $param);
                $check_name->execute();
                if($check_name->rowCount()>0) {
                    return false;
                } else {
                    return true;
                }
            break;	
    
            case 'valid_pass': 
                /**
                *очищаем пароль от мусора и проверяем на количество символов, если кол-во смиволов меньше 3х - выводим false и сообщение об ошибке
                *иначе выводим true
                */			
                $pass = ls_trim($param);
                if(mb_strlen($pass) < 3) {
                    return false;
                } else {
                    return true;
                }
        }
    
    }
    /**
     * меняем статус пользовталея на активный и не активный
     */
    function update_user_status($args) {
      /**   example
        *	0 - active 
        *	1 - deactive
        *
        *	$args = array(
        *		'status' => '1',
        *		'user_id' => $user_id 
        *	);
        **/  
    
        global $dbpdo;
    
        $user_id = $args['user_id'];
        $status  = $args['status'];
    
        $upd_usr_status = $dbpdo->prepare('UPDATE user_control SET user_visible = :status WHERE user_id = :user_id');
        $upd_usr_status->bindParam('status', $status); 
        $upd_usr_status->bindParam('user_id', $user_id);
        $upd_usr_status->execute();	
    }
    
    

}