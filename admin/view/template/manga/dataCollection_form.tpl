<?php echo $header; ?>
<style>
    .ui-progressbar {
        position: relative;
    }
    .progress-label {
        position: absolute;
        left: 50%;
        top: 4px;
        font-weight: bold;
        text-shadow: 1px 1px 0 #fff;
    }
</style>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="warning" style="display: none;"></div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="initialCollect()" class="button"><?php echo $button_start; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          <table class="form">
              <tr>
                  <td><span class="required">*</span> <?php echo $entry_url; ?></td>
                  <td>
                      <input type="text" name="urlSample" size="100" value="http://manhua.fzdm.com/2/{chapter}/index_{page}.html" />
                      <span class="error"></span>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_manga; ?></td>
                  <td>
                      <select name="manga_id">
                          <option value='none'> --- SELECT --- </option>
                          <?php foreach($mangas as $manga) { ?>
                            <option value="<?php echo $manga['manga_id']; ?>"><?php echo $manga['title']; ?></option>
                          <?php } ?>
                      </select>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_matching_type; ?></td>
                  <td>
                      <input type="radio" id="stuck" name="matching_type" value="stuck" />
                      <label for="stuck">Stuck</label>
                      &nbsp;&nbsp;
                      <input type="radio" id="regExp" name="matching_type" value="regExp" checked="checked" />
                      <label for="regExp">RegExp</label>
                  </td>
              </tr>
              <tr class="stuck" style='display:none;'>
                  <td><?php echo $entry_matching_stuck; ?></td>
                  <td>
                      <div style="float: left;height:70px;line-height: 70px;"><b>Start:</b>&nbsp;&nbsp;</div>
                      <textarea style="float:left;" name="matching_stuck_start" value="" rows='4' cols='30' >
                      </textarea>
                      <div style="float: left;height:70px;line-height: 70px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>End:</b>&nbsp;&nbsp;</div><textarea style="float:left;" name="matching_stuck_end" value="" rows='4' cols='30' ></textarea>
                  </td>
              </tr>
              <tr class="regExp">
                  <td><?php echo $entry_matching_regExp; ?></td>
                  <td><input type="text" name="matching_regExp" value="/http:\/\/www1111.fzdm.com\/\d{4}\/\d{2}\/\d{9,10}.jpg/" size="53" /></td>
              </tr>
              <tr>
                  <td><?php echo $entry_chapter_variable; ?></td>
                  <td><input type="text" name="chapter_variable" value="{chapter}" /></td>
              </tr>
              <tr>
                  <td><?php echo $entry_chapter_range; ?></td>
                  <td>
                      <input type="text" name="chapter_start" value="1" />&nbsp;&nbsp;<b>to</b>&nbsp;&nbsp;
                      <input type="text" name="chapter_end" value="733" />
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_page_variable; ?></td>
                  <td><input type="text" name="page_variable" value="{page}" /></td>
              </tr>
              <tr>
                  <td><?php echo $entry_page_range; ?></td>
                  <td>
                      <input type="text" name="page_start" value="0" />&nbsp;&nbsp;<b>to</b>&nbsp;&nbsp;
                      <input type="text" name="page_end" value="25" />
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_replace; ?></td>
                  <td>
                    <input type='radio' id='replace_yes' name='replace' value='1' />
                    <label for="replace_yes">Yes</label>
                    <input type='radio' id='replace_no' name='replace' value='0' checked='checked' />
                    <label for="replace_no">No</label>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_progress; ?></td>
                  <td>
                      <div id="progressbar"><div class="progress-label">Ready...</div></div>
                  </td>
              </tr>
          </table>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
    var urlSample = '';
    var currentChapter = '';
    var firstChapter = '';
    var lastChapter = '';
    var totalChapters = '';
    var completedChapters = '';

    function validate() {
        var promptMsg = '';
        var flag = true;

        if($("input[name='urlSample']").val() == '' || $("input[name='urlSample']").val() == null) {
            promptMsg = 'RUL';
            flag = false;
        }

        if($("select[name='manga_id']").val() == 'none') {
            promptMsg = 'Manga';
            flag = false;
        }

        if($("input[name='matching_type']:checked").val() == 'regExp' && $("input[name='matching_regExp']").val() == '') {
            promptMsg = 'RegExp';
            flag = false;
        }

        if($("input[name='chapter_variable']").val() == '' || $("input[name='chapter_variable']").val() == null) {
            promptMsg = 'Chapter Variable';
            flag = false;
        }

        if($("input[name='chapter_start']").val() == '' || $("input[name='chapter_start']").val() == null) {
            promptMsg = 'Chapter Start';
            flag = false;
        }

        if($("input[name='chapter_end']").val() == '' || $("input[name='chapter_end']").val() == null) {
            promptMsg = 'Chapter End';
            flag = false;
        }

        if($("input[name='page_variable']").val() == '' || $("input[name='page_variable']").val() == null) {
            promptMsg = 'Page Variable';
            flag = false;
        }

        if($("input[name='page_start']").val() == '' || $("input[name='page_start']").val() == null) {
            promptMsg = 'Page Start';
            flag = false;
        }

        if($("input[name='page_end']").val() == '' || $("input[name='page_end']").val() == null) {
            promptMsg = 'Page End';
            flag = false;
        }

        if(!flag) {
            $(".warning").text("The " + promptMsg + " field is required!");
            $(".warning").show('slow');
        }

        return flag;

    }

    function initialCollect() {

        $(".warning").hide('slow');
        $( ".progress-label" ).text( "0%" );

        if(!validate()) {
            return;
        }
        urlSample = $("input[name='urlSample']").val();
        currentChapter = $("input[name='chapter_start']").val();
        firstChapter = $("input[name='chapter_start']").val();
        lastChapter = $("input[name='chapter_end']").val();
        totalChapters = lastChapter - firstChapter + 1;
        completedChapters = 1;
        collect();
    }

    function collect() {

        var url = urlSample.replace("{chapter}",currentChapter);

        var params = {
            urlSample:$("input[name='urlSample']").val(),
            url:url,
            manga_id:$("select[name='manga_id']").val(),
            manga:$("select[name='manga_id']").find("option:selected").text(),
            matching_type:$("input[name='matching_type']:checked").val(),
            matching_regExp:$("input[name='matching_regExp']").val(),
            currentChapter:currentChapter,
            page_variable:$("input[name='page_variable']").val(),
            page_start:$("input[name='page_start']").val(),
            page_end:$("input[name='page_end']").val(),
            replace:$("input[name='replace']:checked").val()
        }

        $.ajax({
            url: 'index.php?route=manga/dataCollection/dataCollect&token=<?php echo $token; ?>',
            type: 'post',
            dataType: 'json',
            data: params,
            success: function(data) {
                if(data == 'succeed') {

                    $( "#progressbar" ).progressbar( "value", parseFloat(parseFloat(completedChapters/totalChapters*100).toFixed(2)) );

                    if(currentChapter == lastChapter) {
                        return;
                    }else{
                        currentChapter++;
                        completedChapters++;
                        collect();
                    }

                }else{
                    $(".warning").text("Collect Fail! --- Chapter:" + currentChapter);
                    $(".warning").show('slow');
                }
            }
        })

    }

    $(function(){
        //two type of matching method
        $("input[name='matching_type']").click(function(){

            var type = $(this).val();

            if(type=='regExp') {
                $(".stuck").css({display:"none"});
                $(".regExp").css({display:""});
            }else{
                $(".stuck").css({display:""});
                $(".regExp").css({display:"none"});
            }

        });

        //the progress bar function
        var progressbar = $( "#progressbar" ),
        progressLabel = $( ".progress-label" );

        progressbar.progressbar({
            value: false,
            change: function() {
                progressLabel.text( progressbar.progressbar( "value" ) + "%" );
            },
            complete: function() {
                progressLabel.text( "Complete!" );
            }
        });
    })
//--></script>
<?php echo $footer; ?>