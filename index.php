<?php require 'config.php'; ?>
 <!DOCTYPE html>
<html lang="en" dir="ltr">
	<head> 
	<link rel="shortcut icon" href="2.jpeg">
		<meta charset="utf-8">
		<title>Import Excel To SQL Diubah Barcode</title>
	</head>
	<body>
		<center>
			<b>Silahkan import excel disini</b>
			<br>
			&#8595;
		<form class="" action="" method="post" enctype="multipart/form-data">
			<input type="file" name="excel" required value="">
			<button type="submit" name="import">Import</button>
		</form>
</center>
		<hr>
		<br>
		<center>
		<table border = 1>
			<tr>
				<td>NO</td>
				<td>BARCODE</td>
				<td>BARCODE</td>
				<td>BARCODE</td>
			</tr>
			</center>
			<?php
			$i = 1;
			$rows = mysqli_query($conn, "SELECT * FROM tb_data");
			foreach($rows as $row) :
			?>
			<tr>
				<td> <?php echo $i++; ?> </td>
				<td><img src="barcode.php?text=<?= $row['name']  ?> &codetype=code39&print=true&size=55" /></td>
				<td><img src="barcode.php?text=<?= $row['age']  ?> &codetype=code39&print=true&size=55" /></td>
				<td><img src="barcode.php?text=<?= $row['country']  ?> &codetype=code128&print=true&size=55" /></td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php
		if(isset($_POST["import"])){
			$fileName = $_FILES["excel"]["name"];
			$fileExtension = explode('.', $fileName);
      $fileExtension = strtolower(end($fileExtension));
			$newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

			$targetDirectory = "uploads/" . $newFileName;
			move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

			error_reporting(0);
			ini_set('display_errors', 0);

			require 'excelReader/excel_reader2.php';
			require 'excelReader/SpreadsheetReader.php';

			$reader = new SpreadsheetReader($targetDirectory);
			foreach($reader as $key => $row){
				$name = $row[0];
				$age = $row[1];
				$country = $row[2];
				mysqli_query($conn, "INSERT INTO tb_data VALUES('', '$name', '$age', '$country')");
			}

			echo
			"
			<script>
			alert('Import Exel Berhasil bree :D');
			document.location.href = '';
			</script>
			";
		}
		?>
		<script>
		window.print();
	</script>

	</body>
</html>
