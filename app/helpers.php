<?php
    function trace($data, $exit = true)
    {
        print_r($data);
        if($exit)
            exit;
    }
?>