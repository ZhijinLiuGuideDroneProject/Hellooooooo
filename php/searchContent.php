<?php
if(!isset($_SESSION)){
    session_start();
}
?>
<script type="text/javascript">
	function searchResult(){
		window.location.href = "../pages/searchResultPage.php";
	}
</script>

<?php
	$_SESSION["searchBar"]=$_POST["searchBar"];

	echo "<script>searchResult();</script>";
?>