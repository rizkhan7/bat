<hr><b>(Footer Include)</b><hr>
</body>
</html>
<?
if(isset($_SESSION['show_debug']) && $_SESSION['show_debug'] == "yes")
{
  debug_info();
}
?>