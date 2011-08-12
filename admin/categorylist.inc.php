<?
function createSelectCategoryList($id,$optionList,$selectedItem)
{		
	
	$selectedCat=explode(",",$selectedItem);
	$strsql="select * from category where parent_id=". $id . " and status=1";
	$c_res=mysql_query($strsql);
	if($c_rows=mysql_num_rows($c_res)==0)	
	{
	$optionList="";
	}
	else{
		
		while($c_row=mysql_fetch_assoc($c_res))
		{			
			if($id!=0)
			$optionList=$optionList." > ";
			$optionList=str_replace(" >  > "," > ",$optionList);
			//$optionList=$optionList.$c_row["category"];
			if (in_array($c_row["id"],$selectedCat))
				echo "<option value='".$c_row["id"]."' selected>".$optionList.$c_row["category"]."</option>";
			else
				echo "<option value='".$c_row["id"]."'>".$optionList.$c_row["category"]."</option>";			
				createSelectCategoryList($c_row["id"],$optionList.$c_row["category"],$selectedItem);			
		}
	}
}

?>