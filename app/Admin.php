<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Route;
class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';
    protected $fillable = ['role_id','first_name','last_name','email','phone','password','address','hub_id','image'];

    protected $hidden = [
        'password', 'remember_token',
    ];


    function admin_routes(){
        $name = '/admin';
        $routeCollection = Route::getRoutes(); // RouteCollection object
        $routes = $routeCollection->getRoutes(); // array of route objects
        $grouped_routes = array_filter($routes, function($route) use ($name) {
            $action = $route->getAction();
    
            if (isset($action['prefix'])) {
                // for the first level groups, $action['group_name'] will be a string
                // for nested groups, $action['group_name'] will be an array
                if (is_array($action['prefix'])) {
                    return in_array($name, $action['prefix']);
                    
                } else {
                    return $action['prefix'] == $name;
                }
            }
            return false;
        });
     
        foreach ($grouped_routes as $key => $router) { 
            $newRouter = str_replace('admin/','',$router->uri);
            // echo $newRouter.'<br/>';
            $result = explode('/',$newRouter);


            if(isset($result[1])){
                $result = $result[0].'/'.$result[1];  
            }else $result =  $result[0];
            $commonRoutes [] = $result;
        }
        return array_unique($commonRoutes);
    }

    // relation 
    public function hub()
    {
    	return $this->belongsTo(Hub::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    function hubs(){
        return $this->belongsToMany(Hub::class);
    }


    
}
