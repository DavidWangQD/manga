<div class="well">
    <h2>Find Your Manga</h2>
    <!--
    <hr class="top-hr">
    <a style="text-decoration:none; color:#000;" href="http://www.mangasee.com/search_result.php?Action=Yes" data-original-title="" title="">Action</a>
    <hr class="top-hr">
    <a style="text-decoration:none; color:#000;" href="http://www.mangasee.com/search_result.php?Action=NA&Adult=NA&Adventure=NA&Comedy=NA&Doujinshi=NA&Drama=NA&Ecchi=NA&Fantasy=NA&Gender+Bender=NA&Harem=NA&Hentai=NA&Historical=NA&Horror=NA&Josei=NA&Lolicon=NA&Martial+Arts=NA&Mature=NA&Mecha=NA&Mystery=NA&Psychological=NA&Romance=Yes&School+Life=NA&Sci-fi=NA&Seinen=NA&Shotacon=NA&Shoujo=NA&Shoujo+Ai=NA&Shounen=NA&Shounen+Ai=NA&Slice+of+Life=NA&Smut=NA&Sports=NA&Supernatural=NA&Tragedy=NA&Yaoi=NA&Yuri=NA&series_name=&author_name=&published_status=all&scanlated_status=all&type=all&oneshot=yes" data-original-title="" title="">Romance</a>
    <hr class="top-hr">
    <a style="text-decoration:none; color:#000;" href="http://www.mangasee.com/search_result.php?Action=NA&Adult=NA&Adventure=NA&Comedy=NA&Doujinshi=NA&Drama=NA&Ecchi=NA&Fantasy=NA&Gender+Bender=NA&Harem=NA&Hentai=NA&Historical=NA&Horror=NA&Josei=NA&Lolicon=NA&Martial+Arts=NA&Mature=NA&Mecha=NA&Mystery=NA&Psychological=NA&Romance=NA&School+Life=NA&Sci-fi=NA&Seinen=NA&Shotacon=NA&Shoujo=NA&Shoujo+Ai=NA&Shounen=NA&Shounen+Ai=NA&Slice+of+Life=NA&Smut=NA&Sports=Yes&Supernatural=NA&Tragedy=NA&Yaoi=NA&Yuri=NA&series_name=&author_name=&published_status=all&scanlated_status=all&type=all&oneshot=yes" data-original-title="" title="">Sports</a>
    <hr class="top-hr">
    <a style="text-decoration:none; color:#000;" href="http://www.mangasee.com/search_result.php?Action=NA&Adult=NA&Adventure=NA&Comedy=NA&Doujinshi=NA&Drama=NA&Ecchi=NA&Fantasy=NA&Gender+Bender=NA&Harem=NA&Hentai=NA&Historical=NA&Horror=NA&Josei=NA&Lolicon=NA&Martial+Arts=NA&Mature=NA&Mecha=NA&Mystery=NA&Psychological=NA&Romance=NA&School+Life=NA&Sci-fi=NA&Seinen=NA&Shotacon=NA&Shoujo=NA&Shoujo+Ai=NA&Shounen=Yes&Shounen+Ai=NA&Slice+of+Life=NA&Smut=NA&Sports=NA&Supernatural=NA&Tragedy=NA&Yaoi=NA&Yuri=NA&series_name=&author_name=&published_status=all&scanlated_status=all&type=all&oneshot=yes" data-original-title="" title="">Shounen</a>
    <hr class="top-hr">
    <a style="text-decoration:none; color:#000;" href="http://www.mangasee.com/search_result.php?Action=NA&Adult=NA&Adventure=NA&Comedy=NA&Doujinshi=NA&Drama=NA&Ecchi=NA&Fantasy=NA&Gender+Bender=NA&Harem=NA&Hentai=NA&Historical=NA&Horror=NA&Josei=NA&Lolicon=NA&Martial+Arts=NA&Mature=NA&Mecha=NA&Mystery=NA&Psychological=NA&Romance=NA&School+Life=NA&Sci-fi=NA&Seinen=NA&Shotacon=NA&Shoujo=Yes&Shoujo+Ai=NA&Shounen=NA&Shounen+Ai=NA&Slice+of+Life=NA&Smut=NA&Sports=NA&Supernatural=NA&Tragedy=NA&Yaoi=NA&Yuri=NA&series_name=&author_name=&published_status=all&scanlated_status=all&type=all&oneshot=yes" data-original-title="" title="">Shoujo</a>
    <hr class="top-hr">
    <a href="http://www.mangasee.com/advanced_search.php" data-original-title="" title="">Advanced Search</a>
    -->

    <?php if( !empty($myComics) ){ ?>
    <?php foreach($myComics as $comic){ ?>
    <hr class="top-hr">
    <a style="text-decoration:none; color:#000;"
       href="#"
       data-original-title="<?php echo $comic['title']?>"
       title="<?php echo $comic['title']?>"><?php echo $comic['title']?></a>
    <?php } ?>
    <?php } ?>
</div>