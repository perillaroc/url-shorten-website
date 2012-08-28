<?php // footer.php
/**
 *	footer.php
 *	生成页面的footer部分
 */
 
?>

    <div id="footer">
    	<div class="content copyright">
        	<p>
            <?php 
				echo '&copy;2012 windroc.';
            	$lastmod = date("F d, Y h:i:sa",getlastmod());
				echo "Page last modified on $lastmod .";
			?>
            </p>
        </div>
    </div> <!-- footer -->

</div>	<!-- wrapped -->

</body>
</html>