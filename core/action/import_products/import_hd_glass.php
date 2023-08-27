<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/core/action/category/category.controller.php';

$f_date = date("d.m.Y");
$y_date = date("m.Y");
$query = "INSERT INTO stock_list (stock_get_fdate, stock_get_year, stock_name, barcode_article, stock_first_price, stock_second_price, min_quantity_stock) VALUES 
('$f_date', '$y_date', 'GLASS HD SAM A01','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A01CORE','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A02','6281020249684','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A02S','6281020245907','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A03','6281020283930','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A03S','6281020273948','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A03 CORE','6281020283923','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A04','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A04S','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A04E','6281020128975','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A10','6281020234420','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A10S','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A11','6281020225022','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A12','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A13','6281020012233','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A14','6281020128477','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A20/30/50','6281020242401','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A20S','6281020248199','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A20E','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A21S','6281020226364','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A21','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A22 5G','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A22 4G','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A23','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A24','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A31','6281020227408','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A32','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A33','6281020012240','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A34','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A40','6281020279230','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A41','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A42','6281020247963','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A51','6281020249776','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A52','6281020253544','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A53','6281020012271','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A54','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A60','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A70','6281020239760','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A71','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A72','6281020253537','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A73','6281020012288','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A74','6281020128488','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A260/A02CORE','6281020246003','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A310','6281020231351','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A310 GOLD','6281020252660','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A320','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A320 GOLD','6281020252677','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A330','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A510','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A510 GOLD','6281020251519','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A520','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A520 GOLD','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A530','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A530 GOLD','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A60','6281020252387','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A80','6281020231405','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A710','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A720 GOLD','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A720','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A730 GOLD','6281020257122','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A730','6281020239746','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A6','6281020239401','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A6 GOLD','6281020257061','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A8','6281020252691','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A6++','6281020252684','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J2','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J2 PRİME','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J4','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J4 GOLD','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J250','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J260','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J310','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J320','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J330','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J510','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J520','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J530','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J6','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J7','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J710','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J720','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J730','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J7 PRM','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J7 PRM GOLD','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J4++/J6++','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM S20FE','6281020259980','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM S21','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM S21++','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM S22','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM S23','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM S23 PLUS','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM S22+','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM S23+','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 4A','6281020251410','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 4X','6281020242463','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI A1','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI A1+','6281050130608','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 5A','6281020012301','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 5','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 5++','6281020249837','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 6/6A','6281020249820','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 7','6281020231641','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 7A','6281020242487','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 8A','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 9','6281020227453','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 9A','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 9T','6281020245884','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 9C','6281020234246','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 10','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 10A','6281020019722','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 10C','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 12','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 12C','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI A1','6281020244795','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI A2','6281020252394','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI A2LITE','6281020242470','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI A3','6281020208810','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 8','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 8 LITE','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 9SE/MI PLAY','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 9/9 LITE','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 9T','6281020252776','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 10','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 10T','6281020242302','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 11T','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 11','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 11 LITE','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 12','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 12 LITE','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 13','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 5','6281020252318','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 5A','6281020257597','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 5 PRO','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 6','6281020252752','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 6 PRO','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 7','6281020231436','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 7 PRO','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 8','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 8T','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 8 PRO','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 9','6281020227446','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 9S/9 PRO','6281020226340','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 10 LITE','6281020283251','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 10/10S','6281020268296','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 11/11S','6281020282582','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 10 PRO','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 11 PRO','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 12','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 12 PRO','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD POCO M3','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD POCO M3 PRO','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD POCO X3','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD POCO C40','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD POCO X5','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD POCO X5 PRO','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P20','6281020231344','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P20 PRO','6281020246065','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P20 LITE','6281020246058','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P30','6281020246072','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P30 LITE','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P40','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P40 LITE','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P SMART 2019','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P SMART 2020','6281020246096','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P SMART 2021','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P SMART Z','6281020234505','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI MATE 20','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI MATE 20 LITE','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI Y5','6281020234482','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI Y5 PRO','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI Y6 ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI Y6 PRO','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI Y7','6281020242494','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI Y7 PRO','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI Y8','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI Y8 PRO','6281020240605','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR 8','6281020249783','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR 8X','6281020246027','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR 9X','6281020234499','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR X5','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR X6','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR X7','6281020456964','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR X7A','6281020128470','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR X8','6281030456987','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR X8A','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR X9','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR X9A','6281020028951','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR 8A','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR 8S','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR 9A','6281020249790','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR 9C','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR 10 LITE','6281020231443','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR 20/20PRO','6281020252707','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR 7C','6281020246010','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REALME C2','6281020233263','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REALME C33','6281020046412','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REALME C3','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REALME C11','6281050410210','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REALME C21Y /C25Y','6281040631136','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REALME C30S','6281020046405','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REALME C33','6281020046412','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REALME 5 PRO','6281020233300','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REALME 9I','6281040789654','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REALME 6','6281020233287','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 5 WHITE','6281030561487','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 5','6281020239623','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 6 WHITE','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 6','6281020268975','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 7/8 WHITE','6281020239630','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 7/8','6281020234468','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 6+/7+/8+ WHITE','6281020249851','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 6+/7+/8+','6281020245990','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 11/XR','6281020211308','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH X/XS/11PRO','6281020252356','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH XS MAX/11 PRO MAX','6281020242432','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 12 MINI','6281020251465','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 12/12PRO','6281020231474','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 12 PROMAX','6281020214125','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 13 MINI','6281020280823','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 13/13 PRO','6281020280847','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 13 PROMAX','6281020280830','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 14','6281020426854','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 14 PLUS','6281020931124','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 14 PRO','6281020637896','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 14 PRO MAX','','0.8',3,0); ";

$stmt = $dbpdo->prepare($query);
$stmt->execute();


function get_glass_category() {
   return ls_db_request([
        'table_name' => 'stock_category',
        'col_list' => '*',
        'base_query' => ' WHERE category_name LIKE :category_name  ',
        'param' => [
            'query' => [
                'bindList' => [
                    ':category_name' => 'GLASS'
                ]
            ]
        ]
    ]);
}

function insert_imported_products_category($id) {
    ls_db_upadte([
        'before' => " UPDATE stock_list SET ",
        'after' => " WHERE stock_name LIKE :glass ",
        'post_list' => [
            'glass' => [ 
                'query' => false,
                'bind' => 'glass',
                'require' => true
            ],            
            'id' => [
                'query' => ' product_category = :id ',
                'bind' => 'id'
            ]
        ]
    ], 
    [
        'glass' => "%GLASS%",
        'id' => $id,
    ]);
}



$d = ls_db_request([
	'table_name' => 'stock_list',
	'col_list' => '*',
	'base_query' => ' WHERE stock_name LIKE :name ',
	'param' => [
		'query' => [
			'bindList' => [
				'name' => "%GLASS HD%"
			]
		],
	]
]);


foreach($d as $row => $value) {
  if($value['barcode_article']) {

    ls_db_insert('stock_barcode_list', [
      [
        'barcode_value' => $value['barcode_article'],
        'br_stock_id' => $value['stock_id']
      ]
      ]);
  }
}


$tt = get_glass_category();

if(empty($tt)) {
    add_new_category([
        'add_category_name' => 'GLASS'
    ]);

    $new = get_glass_category();

    return insert_imported_products_category($new[0]['category_id']);

} else {

    return insert_imported_products_category($tt[0]['category_id']);
}



