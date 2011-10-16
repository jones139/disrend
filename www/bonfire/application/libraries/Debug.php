<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
	Copyright (c) 2011 Graham Jones

	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:
	
	The above copyright notice and this permission notice shall be included in
	all copies or substantial portions of the Software.
	
	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.
*/

/*
	Class: Debug
	
	Provides some debugging utiltities to display arrays, module contents etc.
	
	License:
		MIT 
*/
class Debug {
  
  /*
    Method: __construct()
    
    This constructor is here purely for CI's benefit, as this is a
    static class.
    
    Return:
    void
  */
  public function __construct() 
  {			
    //self::init();
    
    log_message('debug', 'Debug tools library loaded');
  }
  
  //--------------------------------------------------------------------
	
  	
  /*
    Method: showArr()
    
    Display the contents of an array
    
    Parameters:
    $arr	- The variable to log.
  */
  public static function showArr($arr=null) 
  {
    $keys = array_keys($arr);
    echo "<ol>";
    for($i=0;$i<count($keys);$i++)
      {
	echo "<li>".$keys[$i]." - ".$arr[$keys[$i]]."</li>";
      } 
    echo "</ol>";

  }

  public static function showClassMethods($class=null)
  {
    $class_methods = get_class_methods($class);
    
    echo "<ol>";
    foreach ($class_methods as $method_name) {
      echo "<li>$method_name</li>";
    }
    echo "</ol>";
  }


  public static function showClassVars($class=null)
  {
    $class_vars = get_class_vars($class);
    
    echo "<ol>";
    foreach ($class_vars as $var_name) {
      echo "<li>$var_name</li>";
    }
    echo "</ol>";
  }

}

// End Console class