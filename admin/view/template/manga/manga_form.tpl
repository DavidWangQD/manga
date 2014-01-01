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
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          <table class="form">
              <tr>
                  <td><span class="required">*</span> <?php echo $entry_name; ?></td>
                  <td><input type="text" name="title" size="100" value="<?php echo $title; ?>" />
                      <?php if(isset($error_name)) { ?>
                      <span class="error"><?php echo $error_name; ?></span>
                      <?php } ?>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_author; ?></td>
                  <td><input type="text" name="author" value="<?php echo $author; ?>" /></td>
              </tr>
              <tr>
                  <td><?php echo $entry_keyword; ?></td>
                  <td><input type="text" name="keyword" value="<?php echo $keyword; ?>" /></td>
              </tr>
              <tr>
                  <td><?php echo $entry_image; ?></td>
                  <td valign="top">
                      <div class="image">
                          <img src="<?php echo $thumb; ?>" alt="" id="thumb" />
                          <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
                          <br />
                          <a onclick="image_upload('image', 'thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                          <a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');"><?php echo $text_clear; ?></a>
                      </div>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_banner; ?></td>
                  <td valign="top">
                      <div class="image">
                          <img src="<?php echo $bannerThumb; ?>" alt="" id="bannerThumb" />
                          <input type="hidden" name="banner" value="<?php echo $banner; ?>" id="banner" />
                          <br />
                          <a onclick="image_upload('banner', 'bannerThumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                          <a onclick="$('#bannerThumb').attr('src', '<?php echo $no_image; ?>'); $('#banner').attr('value', '');"><?php echo $text_clear; ?></a>
                      </div>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_genre; ?></td>
                  <td><input type="text" name="genre" value="" /></td>
              </tr>
              <tr>
                  <td>&nbsp;</td>
                  <td><div id="manga-genre" class="scrollbox">
                          <?php $class = 'odd'; ?>
                          <?php foreach ($manga_genre as $item) { ?>
                          <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                          <div id="manga-genre<?php echo $item['genre_id']; ?>" class="<?php echo $class; ?>"><?php echo $item['title']; ?><img src="view/image/delete.png" alt="" />
                              <input type="hidden" name="manga_genre[]" value="<?php echo $item['genre_id']; ?>" />
                              <input type="hidden" name="manga_genre_title[]" value="<?php echo $item['title']; ?>" />
                          </div>
                          <?php } ?>
                      </div></td>
              </tr>
              <tr>
                  <td><?php echo $entry_status; ?></td>
                  <td>
                      <select name="status">
                          <option value='none'> --- SELECT --- </option>
                          <?php foreach($allStatus as $item) { ?>
                          <?php if($item['manga_status_id'] == $status) { ?>
                          <option value="<?php echo $item['manga_status_id']; ?>" selected="selected"><?php echo $item['value']; ?></option>
                          <?php }else{ ?>
                          <option value="<?php echo $item['manga_status_id']; ?>"><?php echo $item['value']; ?></option>
                          <?php } ?>
                          <?php } ?>
                      </select>
                      <?php if(isset($error_status)) { ?>
                      <span class="error"><?php echo $error_status; ?></span>
                      <?php } ?>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_show; ?></td>
                  <td>
                      <select name="show">
                          <?php if ($status) { ?>
                          <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                          <option value="0"><?php echo $text_no; ?></option>
                          <?php } else { ?>
                          <option value="1"><?php echo $text_yes; ?></option>
                          <option value="0" selected="selected"><?php echo $text_no; ?></option>
                          <?php } ?>
                      </select>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_sort_order; ?></td>
                  <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
              </tr>
              <tr>
                  <td><?php echo $entry_viewed; ?></td>
                  <td>
                      <?php echo $viewed; ?>
                      <input type="hidden" name="viewed" value="<?php echo $viewed; ?>" />
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_meta_description; ?></td>
                  <td><textarea name="meta_description" cols="40" rows="5"><?php echo $meta_description; ?></textarea></td>
              </tr>
              <tr>
                  <td><?php echo $entry_meta_keyword; ?></td>
                  <td><textarea name="meta_keyword" cols="40" rows="5"><?php echo $meta_keyword; ?></textarea></td>
              </tr>
              <tr>
                  <td><?php echo $entry_description; ?></td>
                  <td><textarea name="description" id="description"><?php echo $description; ?></textarea></td>
              </tr>
          </table>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
CKEDITOR.replace('description', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
//--></script> 
<script type="text/javascript"><!--
    $('input[name=\'genre\']').autocomplete({
        delay: 500,
        source: function(request, response) {
            $.ajax({
                url: 'index.php?route=manga/genre/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
                dataType: 'json',
                success: function(json) {

                    response($.map(json, function(item) {
                        return {
                            label: item.title,
                            value: item.genre_id
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
            $('#manga-genre' + ui.item.value).remove();

            $('#manga-genre').append('<div id="manga-genre' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="manga_genre[]" value="' + ui.item.value + '" /><input type="hidden" name="manga_genre_title[]" value="' + ui.item.label + '" /></div>');

            $('#manga-genre div:odd').attr('class', 'odd');
            $('#manga-genre div:even').attr('class', 'even');

            $('input[name=\'genre\']').val("");

            return false;
        },
        focus: function(event, ui) {
            return false;
        }
    });

    $('#manga-genre div img').live('click', function() {
        $(this).parent().remove();

        $('#manga-genre div:odd').attr('class', 'odd');
        $('#manga-genre div:even').attr('class', 'even');
    });
//--></script>
<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script>
<?php echo $footer; ?>