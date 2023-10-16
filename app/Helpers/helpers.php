<?php 
    function custom_date_format($value) {
        return date("F j, Y, g:i a", strtotime($value)); 
    }

?>