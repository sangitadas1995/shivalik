<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Menu_permissions;
use App\Models\Sub_menu_permissions;
use DB;

trait Permissionhelper
{
   public function getSubMenuList($menu_id,$user_id)
   {
        if (!empty($menu_id)) 
        {
            $subMenuList = Sub_menu_permissions::select('sub_menu_permissions.id AS sub_menu_id','sub_menu_permissions.display_name','sub_menu_permissions.reserve_keyword',DB::raw("(CASE WHEN uwmp.user_id != '' THEN 'exist'
                    ELSE 'not_exist' END) AS user_menu_status"))
            ->leftJoin('user_wise_menu_permissions as uwmp', function($join) use ($user_id)
            {
                $join->on('sub_menu_permissions.id', '=', 'uwmp.sub_menu_id');
                $join->where('uwmp.user_id',$user_id);
            })
            ->where('sub_menu_permissions.menu_id', '=', $menu_id)
            ->orderBy('sub_menu_permissions.sort_order', 'ASC')
            ->get();
            //->toSql();
            //echo $subMenuList;exit;
        }
      return $subMenuList;
   }


   public function getMenuId($sub_menu_id)
   {
        $menu_id = Sub_menu_permissions::select('menu_id')->where('id',$sub_menu_id)->first();
        return $menu_id;
   }


    public function userWisePermission($user_id)
    {
        if (!empty($user_id)) 
        {
            $userWisePermissionList = Sub_menu_permissions::select('sub_menu_permissions.reserve_keyword')
            ->join('user_wise_menu_permissions as uwmp', function($join) use ($user_id)
            {
                $join->on('sub_menu_permissions.id', '=', 'uwmp.sub_menu_id');
                $join->where('uwmp.user_id',$user_id);
            })
            ->where('sub_menu_permissions.status', '=', 'A')
            ->orderBy('sub_menu_permissions.sort_order', 'ASC')
            ->get();
            //->toArray();
            //->toSql();
            //echo $subMenuList;exit;

            $userPermissionListArr = array();
            foreach($userWisePermissionList as $val)
            {
                $userPermissionListArr[] = $val->reserve_keyword;
            }
        }
        return $userPermissionListArr;
    }




    public function getReserveKeywordByMenuId($menu_id)
    {
        if (!empty($menu_id)) 
        {
            $userWisePermissionList = Sub_menu_permissions::select('sub_menu_permissions.reserve_keyword')
            ->join('menu_permissions as mp', function($join) use ($menu_id)
            {
                $join->on('sub_menu_permissions.menu_id', '=', 'mp.id');
                $join->where('mp.id',$user_id);
            })
            ->where('sub_menu_permissions.status', '=', 'A')
            ->orderBy('sub_menu_permissions.sort_order', 'ASC')
            ->get();
            //->toArray();
            //->toSql();
            //echo $subMenuList;exit;

            $userPermissionListArr = array();
            foreach($userWisePermissionList as $val)
            {
                $userPermissionListArr[] = $val->reserve_keyword;
            }
        }
        return $userPermissionListArr;
    }
}