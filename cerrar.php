<?php
session_start();
session_destroy();
unset($_SESSION["usuario"]);

?>
<script type="text/javascript">
window.location.href = "../index.php";
</script>