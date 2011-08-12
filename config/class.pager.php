<?php 
class Pager 
  {
   
  /*********************************************************************************** 
   * int findStart (int limit) 
   * Returns the start offset based on $_GET['page'] and $limit 
   ***********************************************************************************/ 
   function findStart($limit) 
    { 
	 if ((!isset($_GET['page'])) || ($_GET['page'] == "1")) 
      { 
       $start = 0; 
       $_GET['page'] = 1; 
      } 
     else 
      { 
       $start = ($_GET['page']-1) * $limit; 
      } 

     return $start; 
    } 
  /*********************************************************************************** 
   * int findPages (int count, int limit) 
   * Returns the number of pages needed based on a count and a limit 
   ***********************************************************************************/ 
   function findPages($count, $limit) 
    { 
     $pages = (($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1; 

     return $pages; 
    } 
  /*********************************************************************************** 
   * string pageList (int curpage, int pages) 
   * Returns a list of pages in the format of "« < [pages] > »" 
   ***********************************************************************************/ 
   function pageList($curpage, $pages) 
    { 
    $page_list  = "";
	 $str = "";
	 foreach( $_GET as $key=>$value)
	  {
	    if ($key=="message" || $key=="page" || $key=="pagegroup")
		{}
		else
		 $str = $str."&".$key."=".$value;
	   }	  
	 foreach( $_POST as $key=>$value)
	  {
	    if ($key=="message" || $key=="page" || $key=="pagegroup")
		{}
		else
		 $str = $str."&".$key."=".$value;
	   }	  
    
$pagegroup = $_REQUEST['pagegroup'];
$limitset = 50;
if ($pagegroup== ""){
	    $pagegroup = 1;
		}
     /* Print the first and previous page links if necessary */ 
   /* if (($curpage != 1) && ($curpage)) 
      { 
	    $str1 = $str . "&pagegroup=1";
       $page_list .= "  <a href=\"".$_SERVER['PHP_SELF']."?page=1".$str1."\" title=\"First Page\"><font color=#ff0000>«</font></a> "; 
      } */
  
	$prevgrouppage = ($pagegroup - 1) * ($limitset);
	if (($prevgrouppage) > 0) 
      { 
	   $str1 = $str . "&pagegroup=" . ($pagegroup-1);
	   $spage = ($limitset*($pagegroup-1)) + 1 - $limitset;
       $page_list .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".($spage).$str1."\" title=\"Previous Page\" class=\"blue_txt\"><b>Previous $limitset Pages  &nbsp;&nbsp;&nbsp;|</b></a> "; 
      } 

  
	
	
	$startpage = (($pagegroup - 1) * $limitset);
	
	
     /* Print the numeric page list; make the current page unlinked and bold */ 
     for ($i=$startpage+1; $i<=$pages; $i++) 
      { 
	    $str1 = $str . "&pagegroup=" . $pagegroup;
	  if ($i > ($startpage + $limitset))
		      break;
       if ($i == $curpage) 
        { 
         $page_list .= "<b>"."<span class=\"links_blue\"><font color=#000000>".$i."</font> | </span>"."</b>"; 
        } 
       else 
        { 
		
         $page_list .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".$i.$str1."\" title=\"Page ".$i."\">"."<span class=\"white_bold\">".$i." | </span>"."</a>"; 
        } 
       $page_list .= " "; 
      } 

    $nextgrouppage = $pagegroup * $limitset;
     /* Print the Next and Last page links if necessary */ 
     if (($nextgrouppage+1) <= $pages) 
      { 
	   $str1 = $str . "&pagegroup=" . ($pagegroup+1);
	   $spage = ($limitset*$pagegroup) + 1;
	   $page_list .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".($spage).$str1."\" title=\"Next PageSet\"><span class=\"white_bold\"><b>&nbsp;&nbsp;&nbsp;Next $limitset Pages</b></span></a> "; 
      } 

     if (($curpage != $pages) && ($pages != 0)) 
      { 
      if (($pages%$limitset) == 0) 
	    $str1 = $str . "&pagegroup=" . ($pages/$limitset);
	  else
	   $str1 = $str . "&pagegroup=" . (($pages/$limitset) + 1);
	   
	   $page_list .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".$pages.$str1."\" title=\"Last Page\"><font color=#ff0000>/font></a> "; 
      }  
     $page_list .= "\n"; 

     return $page_list; 
    } 
  /*********************************************************************************** 
   * string nextPrev (int curpage, int pages) 
   * Returns "Previous | Next" string for individual pagination (it's a word!) 
   ***********************************************************************************/ 
   function nextPrev($curpage, $pages) 
    { 
     $next_prev  = ""; 
     $page_list  = "";
	 $str = "";
	 foreach( $_GET as $key=>$value)
	  {
	    if ($key=="message" || $key=="page")
		{}
		else
		 $str = $str."&".$key."=".$value;
	   }
	
	 foreach( $_POST as $key=>$value)
	  {
	    if ($key=="message" || $key=="page")
		{}
		else
		 $str = $str."&".$key."=".$value;
	   }	  	  
     if (($curpage-1) <= 0) 
      { 
       $next_prev .= "Previous"; 
      } 
     else 
      { 
       $next_prev .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".($curpage-1).$str."\"><font color=#005895>Previous</font></a>"; 
      } 

     $next_prev .= "<font color=#000000> &nbsp;|&nbsp; </font> "; 

     if (($curpage+1) > $pages) 
      { 
       $next_prev .= "Next"; 
      } 
     else 
      { 
       $next_prev .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".($curpage+1).$str."\"><font color=#005895>Next</font></a>"; 
      } 
     $next_prev .= "\n";
     return $next_prev; 
    } 
  } 
?> 