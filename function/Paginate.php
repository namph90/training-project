<?php

if (!function_exists('search')) {
    function search()
    {
        $search = "";
        $searchName = isset($_GET["searchName"]) ? $_GET["searchName"] : "";
        $searchEmail = isset($_GET["searchEmail"]) ? $_GET["searchEmail"] : "";
        $sqlSearch = !empty($_GET["searchName"]) ? (!empty($_GET["searchEmail"]) ?
            "and email like '%$searchEmail%' and name like '%$searchName%'" : "and name like '%$searchName%'") :
            (!empty($_GET["searchEmail"]) ? "and email like '%$searchEmail%'" : " ");
        $name = isset($_GET['searchName']) ? "?searchName=" . $_GET['searchName'] : "?";
        $email = isset($_GET['searchEmail']) ? "&searchEmail=" . $_GET['searchEmail']."&" : "";
        $search = $name . $email;
        return ['sqlSearch'=>$sqlSearch, 'search'=>$search];
    }
}
if (!function_exists('order')) {
    function order($columns)
    {
        $column = isset($_GET['column']) && in_array($_GET['column'], $columns, true) ? $_GET['column'] : $columns[0];
        $sort_order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'desc' : 'asc';
        $asc_or_desc = $sort_order == 'asc' ? 'desc' : 'asc';
        $sqlOrder = "order by $column $sort_order";
        return ['asc_or_desc'=>$asc_or_desc, 'sqlOrder'=>$sqlOrder, 'sort_order'=>$sort_order,'column'=>$column];
    }
}
