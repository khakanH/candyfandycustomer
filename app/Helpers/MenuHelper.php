<?php
namespace App\Helpers;

use App\Models\UserRole;
use App\Models\Modules;

use DB;
class MenuHelper{

	

  	function getMenu()
  	{	
 		$get_module_id = UserRole::where('user_type',session('admin_login.user_type'))->pluck('module_id');

 		$get_module = Modules::whereIn('id',$get_module_id)->where('parent_id',0)->get();


 		foreach ($get_module as $key) 
 		{
      if ($key['route'] == 'order') 
      {
        $key['route'] = route("order",['1']);
        
      }
      else
      {
        $key['route'] = route($key['route']);
      }
 			?>
 			  
       <li class="sidebar-item ">
                            <a class="sidebar-link waves-effect waves-dark" href="<?php echo $key['route'] ?>" aria-expanded="false">
                                <i class="<?php echo $key['icon'] ?>"></i>
                                <span class="hide-menu"><?php echo $key['name']; ?></span> 
                            </a>
      </li>


 			
 			<?php
 		}

	}

	
}
