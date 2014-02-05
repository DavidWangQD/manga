<div class="well">
    <h2>Recently Added</h2>
    <!--
    <hr class="top-hr">
    <a style="text-decoration:none; color:#000;" href="http://www.mangasee.com/manga/?series=Wallman" data-original-title="" title="">Wallman</a>
    <hr class="top-hr">
    <a style="text-decoration:none; color:#000;" href="http://www.mangasee.com/manga/?series=TheGamer" data-original-title="" title="">The Gamer</a>
    <hr class="top-hr">
    <a style="text-decoration:none; color:#000;" href="http://www.mangasee.com/manga/?series=DestroyAndRevolution" data-original-title="" title="">Destroy and Revolution</a>
    <hr class="top-hr">
    <a style="text-decoration:none; color:#000;" href="http://www.mangasee.com/manga/?series=Upotte" data-original-title="" title="">Upotte</a>
    <hr>
    <p>? 2012 MangaSee.com <a style="color:gray;" href="http://www.mangasee.com/privacy.php" data-original-title="" title="">Privacy Policy</a></p>
    -->
    <?php if( !empty($recentAdd) ){ ?>
    <?php foreach($recentAdd as $comic){ ?>
    <hr class="top-hr">
    <a style="text-decoration:none; color:#000;"
       href="#"
       data-original-title="<?php echo $comic['title']?>"
       title="<?php echo $comic['title']?>"><?php echo $comic['title']?></a>
    <?php } ?>
    <?php } ?>



</div>