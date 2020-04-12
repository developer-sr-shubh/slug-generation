 /*
  # Author: developer-sr-shubh
  
 	#Php slug generation script

	#Just need to pass the table name and the colum name for where the slug is getting stored and the string for which you want to generate the slug
	
	#It will automaticaly generate the unique slug for the string which is related to the string you provided

	#At the time of edit for the same string their is function editSlug which ou can use for the editing of the slug
 */



Class slug{
	/*
		For generation of the slug pass the table name and slug colum name and the string in the third parameter
		ex: $table="tableName",$col_name="slug",$name="string";

	*/

	 public function generateSlug($table,$col_name,$name)
	    {  
	        $lower = strtolower($name);
	        $replace = str_replace(' ', '-', $lower);        
	        $main = $this->checkName($table,$col_name,$name);
	        // dd($main,$replace);
	        if($main > 0 )
	          {      
	             $slug = $this->getSlug($table,$col_name,$replace);
	             $mar = str_replace("-", " ",  $slug[0]->c );

	            if(!is_numeric($mar))
	            {
	              $name_slug =  $replace."-".$main ;
	            }
	            else
	            {
	              $var = $mar+1;
	              $name_slug = $replace."-".$var ;
	            }
	          }
	          else
	          {
	            $name_slug =  $replace ;
	          }
	          return $name_slug;
	    }

	    /*Checking the slug already present or not in the field*/

	    public function checkName($table,$col_name,$name)
	    {
	      return DB::table($table)->where($col_name,'=', $name)->count();
	    }

	    /*Getting slug with same string */

	    public function getSlug($table,$col_name,$slug)
	    {      
	      return DB::table($table)->select(DB::raw('RIGHT('.$col_name.' ,2) as c'))->where($col_name,$slug)->orwhere($col_name, 'like', '%'.$slug.'%')->orderBy($col_name, 'desc')->limit(1)->get();
	    }

	    /*
	    	Generating the slug at the time of edit slug need to pass parameters like
			ex: $table='table'
				$col_name='slug_field'
				$slug='slug'
				$col='current col field'
				$id='current field id'
	    */
	    
	    public function editSlug($table,$col_name,$slug,$col,$id)
	    {
	      $data = DB::table($table)->where($col,$id)->where($col_name,$slug)->count();
	      if($data>0)
	      {
	        return strtolower($slug);
	      }else
	      {
	        return $this->generateSlug($table,$col_name,$slug);
	      }
	    }
}
