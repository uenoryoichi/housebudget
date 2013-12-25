<?php 
function search_array ( $array, $key, $value )
{
    $results = array();

    if ( is_array($array) )
    {
        if ( $array[$key] == $value )
        {
            $results[] = $array;
        } else {
            foreach ($array as $subarray) 
                $results = array_merge( $results, $this->search_array($subarray, $key, $value) );
        }
    }

    return $results;
}