<?php echo $header;?>

<div class="container">
<div class="row-fluid">
<div class="span8">
<div class="well">
<style>
    .carousel .carousel-control { visibility: hidden; }
    .carousel:hover .carousel-control { visibility: visible; }
</style>
<div id="myCarousel" class="carousel slide">
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
        <li data-target="#myCarousel" data-slide-to="4"></li>
        <li data-target="#myCarousel" data-slide-to="5"></li>
        <li data-target="#myCarousel" data-slide-to="6"></li>
        <li data-target="#myCarousel" data-slide-to="7"></li>
    </ol>
    <!-- Carousel items -->
    <div class="carousel-inner">
        <?php if(!empty($banner)){ ?>
        <?php foreach( $banner as $key=>$ban ){  ?>
            <div class="item <?php if($key == 0){ echo 'active'; } ?>">
                <a href="<?php echo $ban['link'];?>"
                   data-original-title="<?php echo $ban['name'];?>"
                   title="<?php echo $ban['name'];?>">
                    <img src="<?php echo $ban['image']?>" alt="<?php echo $ban['name'];?>" />
                </a>
            </div>
        <?php } ?>
        <?php } ?>
        <!--
        <div class=" item"><a href="http://www.mangasee.com/manga/?series=BlackJoke" data-original-title="" title=""><img src="image/category/BlackJoke.jpg" alt="Black Joke"></a></div>
        <div class=" item"><a href="http://www.mangasee.com/manga/?series=TokyoESP" data-original-title="" title=""><img src="image/category/TokyoESP.jpg" alt="Tokyo ESP"></a></div>
        <div class=" item"><a href="http://www.mangasee.com/manga/?series=TenjouTenge" data-original-title="" title=""><img src="image/category/TenjouTenge.jpg" alt="Tenjou Tenge"></a></div>
        <div class=" item"><a href="http://www.mangasee.com/manga/?series=Teppuu" data-original-title="" title=""><img src="image/category/Teppuu.jpg" alt="Teppuu"></a></div>
        <div class=" item"><a href="http://www.mangasee.com/manga/?series=CityOfDarkness" data-original-title="" title=""><img src="image/category/CityOfDarkness.jpg" alt="City of Darkness"></a></div>
        <div class="active item"><a href="http://www.mangasee.com/manga/?series=FengShenJi" data-original-title="" title=""><img src="image/category/FengShenJi.jpg" alt="Feng Shen Ji"></a></div>
        <div class=" item"><a href="http://www.mangasee.com/manga/?series=TerraForMars" data-original-title="" title=""><img src="image/category/TerraForMars.jpg" alt="Terra ForMars"></a></div>
        <div class=" item"><a target="_blank" href="https://www.facebook.com/MangaSeeOfficial" data-original-title="" title=""><img src="image/category/Facebook.jpg" alt="Like us on Facebook"></a></div>
        -->
    </div>
    <!-- Carousel nav -->
    <a class="carousel-control left" href="http://www.mangasee.com/#myCarousel" data-slide="prev" data-original-title="" title="">‹</a>
    <a class="carousel-control right" href="http://www.mangasee.com/#myCarousel" data-slide="next" data-original-title="" title="">›</a>
</div>
<h2>Hot Updates</h2>
    <div style="width:100%;">
<?php if( !empty( $hotComics ) ){ ?>

<?php foreach($hotComics as $comic ){ ?>

    <a class="thumbnail"
       style="display:inline-block; max-width:100px;-webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none; border: none; "
       title="" href="#"
       data-original-title="<?php echo $comic['title'];?>">
        <img src="<?php echo $comic['image'];?>" height="120px" width="100px">
        <?php echo $comic['title']; ?>
    </a>

<?php } ?>
<?php } ?>

        <!--
    <a class="thumbnail" style="display:inline-block; max-width:100px;-webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none; border: none; " title="" href="http://www.mangasee.com/manga/?series=FairyTail&chapter=362&index=1&page=1" data-original-title="Read Fairy Tail Chapter 362"><img src="image/category/FairyTail.jpg" height="120px" width="100px">  Fairy Tail 362</a>
    <a class="thumbnail" style="display:inline-block; max-width:100px;-webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none; border: none; " title="" href="http://www.mangasee.com/manga/?series=Toriko&chapter=259&index=1&page=1" data-original-title="Read Toriko Chapter 259"><img src="image/category/Toriko.jpg" height="120px" width="100px">  Toriko 259</a>
    <a class="thumbnail" style="display:inline-block; max-width:100px;-webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none; border: none; " title="" href="http://www.mangasee.com/manga/?series=Bleach&chapter=559&index=1&page=1" data-original-title="Read Bleach Chapter 559"><img src="image/category/Bleach.jpg" height="120px" width="100px">  Bleach 559</a>
    <a class="thumbnail" style="display:inline-block; max-width:100px;-webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none; border: none; " title="" href="http://www.mangasee.com/manga/?series=Naruto&chapter=656&index=1&page=1" data-original-title="Read Naruto Chapter 656"><img src="image/category/Naruto.jpg" height="120px" width="100px">  Naruto 656</a>
    <a class="thumbnail" style="display:inline-block; max-width:100px;-webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none; border: none; " title="" href="http://www.mangasee.com/manga/?series=OnePiece&chapter=729&index=1&page=1" data-original-title="Read One Piece Chapter 139"><img src="image/category/OnePiece.jpg" height="120px" width="100px">  One Piece 729</a>

    <a class="thumbnail" style="display:inline-block; max-width:100px;vertical-align:top;-webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none; border: none; " title="" href="http://www.mangasee.com/manga/?series=TheBreakerNewWaves&chapter=139&index=1&page=1" data-original-title="Read The Breaker New Waves Chapter 139"><img src="image/category/TheBreakerNewWaves.jpg" height="120px" width="100px">  The Breaker New Waves 139</a>
    <a class="thumbnail" style="display:inline-block; max-width:100px;vertical-align:top;-webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none; border: none; " title="" href="http://www.mangasee.com/manga/?series=KurokoNoBasket&chapter=240&index=1&page=1" data-original-title="Read Kuroko No Basket Chapter 240"><img src="image/category/KurokoNoBasket.jpg" height="120px" width="100px">  Kuroko No Basket 240</a>
    <a class="thumbnail" style="display:inline-block; max-width:100px;vertical-align:top;-webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none; border: none; " title="" href="http://www.mangasee.com/manga/?series=HajimeNoIppo&chapter=1039&index=1&page=1" data-original-title="Read Hajime No Ippo Chapter 1039"><img src="image/category/HajimeNoIppo.jpg" height="120px" width="100px">  Hajime No Ippo 1039</a>
    <a class="thumbnail" style="display:inline-block; max-width:100px;vertical-align:top;-webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none; border: none; " title="" href="http://www.mangasee.com/manga/?series=Beelzebub&chapter=230&index=1&page=1" data-original-title="Read Beelzebub Chapter 230"><img src="image/category/Beelzebub.jpg" height="120px" width="100px">  Beelzebub 230</a>
    <a class="thumbnail" style="display:inline-block; max-width:100px;vertical-align:top;-webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none; border: none; " title="" href="http://www.mangasee.com/manga/?series=Vagabond&chapter=320&index=1&page=1" data-original-title="Read Vagabond Chapter 320"><img src="image/category/Vagabond.jpg" height="120px" width="100px">  Vagabond 320</a>
        -->
</div>
<hr>
<h2>Latest Chapters</h2>
<table align="center" style="width:100%;">

<tbody>
<?php if( !empty($chapters ) ){ ?>

<?php foreach( $chapters as $chapter ){ ?>
<tr>
    <td style="padding-bottom:2px;padding-top:10px;"><i class="icon-book"></i>
        <a href="#" style="font-weight:bold;"
           class="latest"
           title=""
           data-original-title="&lt;p style=&#39;
           text-align:left;&#39;&gt;&lt;img src=&#39;<?php echo $chapter['image']; ?>&#39;&gt;
           &lt;br&gt;&lt;blue&gt;Author&lt;/blue&gt;: <?php echo $chapter['author']; ?>&lt;br&gt;&lt;blue&gt;Status&lt;/blue&gt;: <?php echo 'waiting...';?>&lt;br&gt;&lt;blue&gt;Genre&lt;/blue&gt;: <?php echo $chapter['genre_title'];?>&lt;/p&gt;">
            <?php echo $chapter['manga_title']; ?></a>
    </td>
    <td style="color:gray; text-align:right;"><?php echo $chapter['timeAgo'];?> ago &nbsp;</td>
</tr>

<tr>
    <td style="padding-bottom:2px;padding-left:20px;">
        <i class=""></i>
        <a href="#" class="latest" title=""
           data-original-title="<?php echo $chapter['manga_title']; ?> <?php echo $chapter['chapter_title']; ?>">
            <?php echo $chapter['chapter_title']; ?>
        </a>
        <!--
        <div class="tooltip fade right in" style="top: 1293.0590553283691px; left: 769.4445190429688px; ">
            <div class="tooltip-arrow"></div>
            <div class="tooltip-inner">Read <?php echo $chapter['manga_title']; ?> <?php echo $chapter['chapter_title']; ?></div>
        </div>
        -->
    </td>
</tr>
<?php } ?>
<?php } ?>

</tbody></table>
<hr class="top-hr">
</div>
</div>

<div class="span4">
    <?php echo $column_right; ?>
<!--
    <script language="Javascript">
        var cpmstar_rnd=Math.round(Math.random()*999999);
        var cpmstar_pid=48777;
        document.writeln("<SCR"+"IPT language='Javascript' src='//server.cpmstar.com/view.aspx?poolid="+cpmstar_pid+"&script=1&rnd="+cpmstar_rnd+"'></SCR"+"IPT>");
    </script>
    -->
</div>
</div>
</div>

<!-- Le javascript
<!-- Placed at the end of the document so the pages load faster -->
<script src="catalog/view/javascript/js/jquery.min.js"></script>
<script src="catalog/view/javascript/js/jquery.autosize-min.js"></script>
<script>
    $(document).ready(function(){
        $('textarea').autosize();
    });
</script>
<script src="catalog/view/javascript/js/bootstrap.min.js"></script>
<script>
    $('.dropdown-menu').click(function(event){
        event.stopPropagation();
    });​
</script>
<script>
    $(function (){
        $("#announcement").popover({placement:'bottom',html:true});
		});
</script>
<script>
    $(function (){
        $("#user").popover({placement:'bottom',html:true});
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("a").tooltip({
            'selector': '',
            'placement': 'right',
            'html': true
        });
        console.log("Image");
    });
</script>


<textarea tabindex="-1" style="position: absolute; top: -999px; left: 0px; right: auto; bottom: auto; border: 0px; box-sizing: content-box; word-wrap: break-word; overflow: hidden; height: 0px !important; min-height: 0px !important;"></textarea>
<iframe name="oauth2relay1455109190" id="oauth2relay1455109190" src="./Manga See - Read Free Manga Online!_files/postmessageRelay.htm" style="width: 1px; height: 1px; position: absolute; top: -100px;"></iframe>

<?php echo $footer;?>
