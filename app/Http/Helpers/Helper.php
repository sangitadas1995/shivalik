<?php
namespace App\Http\Helpers;
use App\Models\User;

class Helper {
   public static function userDetails($user_auto_id) {
      if (!empty($user_auto_id)) {
         $userDetails = User::where('id', $user_auto_id)->first();
         $username = $userDetails->name;
      }
      else
      {
         $username = "";
      }

      return $username;
   }
}