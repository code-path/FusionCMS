<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Input extends CI_Input
{
    public function __construct()
    {
        $this->_POST_RAW = $_POST;

        parent::__construct();
    }

    function _sanitize_globals()
    {
        $ignore_csrf = config_item('csrf_ignore');

        if (is_array($ignore_csrf) && count($ignore_csrf))
        {
            global $URI;
            $haystack = $URI->uri_string();

            foreach($ignore_csrf as $needle)
            {
                if (strlen($haystack) >= strlen($needle) && substr($haystack, 0, strlen($needle)) == $needle)
                {
                    $this->_enable_csrf = FALSE;
                    break;
                }
            }
        }

        parent::_sanitize_globals();
    }

    public function post($index = null, $xss_clean = TRUE)
    {
        if(!$xss_clean)
        {
            return $this->_POST_RAW[$index];
        }

        return parent::post($index, $xss_clean);
    }
}
/* EOF: MY_Input */