<?php
	require_once dirname(__FILE__) . '/get_status_doc.php';

	        echo '<h2>Result: <a id="doc1"></a></h2>';

		echo '<form method = "post">';
		echo 'DOCID: <input type="text" name="docid" /><br /> <br />';
		echo 'CATID: <input type="text" name="catid" /><br /> <br />';
		echo '<input type = "submit" name = "button" value = "Проверить статус">';


echo "<br><br>CATID:<br>802  = Аллерголог<br>";
echo "805  = Гастроэнтеролог<br>";
echo "806  = Гематолог<br>";
echo "815  = Кардиолог<br>";
echo "818  = Невролог<br>";
echo "819  = Нефролог<br>";
echo "824  = Педиатр<br>";
echo "826  = Пульмонолог<br>";
echo "174  = Ревматолог<br>";
echo "844  = Эндокринолог<br><br>";

 		if ( isset ( $_POST['button'] )) {		

  		        //var_dump( get_doc($_POST["docid"],$_POST["catid"]) ) ;
			
			echo '<script>
			document.all.doc1.innerHTML = "'. json_encode(get_doc($_POST["docid"],$_POST["catid"])) .' ";
			</script>';  
		}

 
?>