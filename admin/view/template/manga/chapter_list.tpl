<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
          <!--<a href="<?php echo $repair; ?>" class="button"><?php echo $button_repair; ?></a>-->
          <a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a>
          <a onclick="$('#form').submit();" class="button"><?php echo $button_delete; ?></a>&nbsp;<b>[ <input type='checkbox' id='delWithFiles' /> <label for='delWithFiles'>with Files</label> ]</b>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <input type='hidden' name='delWithFiles' value='0' />
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php echo $column_title; ?></td>
              <td class="right"><?php echo $column_num; ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($chapters) { ?>
            <?php foreach ($chapters as $chapter) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($chapter['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $chapter['chapter_id'].'#'.$chapter['title']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $chapter['chapter_id'].'#'.$chapter['title']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $chapter['title']; ?></td>
              <td class="right"><?php echo $chapter['num']; ?></td>
              <td class="right"><?php foreach ($chapter['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<?php echo $footer; ?>

<script>
    $(function(){
       $("#delWithFiles").click(function(){
           if($(this).attr("checked")) {
               $("input[name='delWithFiles']").val('1');
           }else{
               $("input[name='delWithFiles']").val('0');
           }
       });
    });
</script>