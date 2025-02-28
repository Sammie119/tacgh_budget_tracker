<?php

if (!function_exists("perm_arrays")) {
    function perm_arrays($type): array
    {
        switch ($type){
            case 'management':
                return [0, 1, 3, 4];

            case 'users';
                return [0, 1, 2];

            default:
                return [];
        }

    }
}

if (!function_exists("getIsAdmin")) {
    function getIsAdmin($is_admin = 0): string
    {
        $isAdmin = [
            0 => "Admin",
            1 => "Super Admin",
            2 => "Management",
            3 => "Audit Staff",
            4 => "Finance Staff",
        ][$is_admin] ?? 0;

        return $isAdmin;
    }
}

