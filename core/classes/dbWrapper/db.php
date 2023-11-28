<?php
namespace core\classes\dbWrapper;

class db 
{
    use \core\classes\dbWrapper\traits\select,
        \core\classes\dbWrapper\traits\update,
        \core\classes\dbWrapper\traits\insert,
        \core\classes\dbWrapper\traits\delete;
}