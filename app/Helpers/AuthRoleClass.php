<?php
namespace App\Helpers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;


class AuthRoleClass {

    public static function getAuthRole()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            $role = Str::slug('Admin', '-');
        }
  
        elseif ($user->hasRole(Str::slug('User', '-'))) {
            $role = Str::slug('user', '-');
        }
  
        elseif ($user->hasRole(Str::slug('Moderator', '-'))) {
            $role = Str::slug('moderator', '-');
        }
        elseif ($user->hasRole(Str::slug('Supplier', '-'))) {
            $role = Str::slug('supplier', '-');
        }
        elseif ($user->hasRole(Str::slug('Buyer', '-'))) {
            $role = Str::slug('buyer', '-');
        }
        return $role;

    }

}

?>
