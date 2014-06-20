<html>
<head>
<title>Pagination</title>

<!-- Just a little style formatting. Has no bearing on example -->
<style type="text/css">
	
</style>
<!-- End style formatting -->
</head>

<body>
<?php
include 'pagination.class.php';
$pagination = new pagination;
				

				$libros = file('libros.txt');				for ($i = 0; $i < count($libros); $i++) {				$tmp = explode('|', $libros[$i]);				$products[] = array("Product"=>$tmp[0],"autor"=>$tmp[1],"editorial"=>$tmp[2],"isbn"=>$tmp[3],"Price"=>$tmp[4]);								}

        // If we have an array with items
        if (count($products)) {
          // Parse through the pagination class
          $productPages = $pagination->generate($products, 10);
          // If we have items 
          if (count($productPages) != 0) {
            // Create the page numbers

            // Loop through all the items in the array
	$num=1;            
	foreach ($productPages as $productArray) {
              // Show the information about the item
              echo '<p><b>'.$num.'.-</b> &nbsp;<b>'.$productArray['Product'].'</b> &nbsp; Bsf. '.$productArray['Price'].'</p>';
	    $num++;            
		}
            // print out the page numbers beneath the results
            echo $pageNumbers = '<div class="numbers">'.$pagination->links().'</div>';
          }
        }


?>
</body>
</html>
