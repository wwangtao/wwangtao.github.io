<?php 
/**
 * 表情
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
extract(_g());

?>
<?php if ($smile == "yes"): ?>
<div id="smilelink">
<a onclick="javascript:grin('{smile:1}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/1.gif" alt="囧" title="囧" /></a>
<a onclick="javascript:grin('{smile:2}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/2.gif" alt="亲" title="亲" /></a>
<a onclick="javascript:grin('{smile:3}')"><img class="lazy "  src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/3.gif" alt="晕" title="晕" /></a>
<a onclick="javascript:grin('{smile:4}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/4.gif" alt="酷" title="酷" /></a>
<a onclick="javascript:grin('{smile:5}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/5.gif" alt="哭" title="哭" /></a>
<a onclick="javascript:grin('{smile:6}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/6.gif" alt="馋" title="馋" /></a>
<a onclick="javascript:grin('{smile:7}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/7.gif" alt="闭嘴" title="闭嘴" /></a>
<a onclick="javascript:grin('{smile:8}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/8.gif" alt="调皮" title="调皮" /></a>
<a onclick="javascript:grin('{smile:9}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/9.gif" alt="贪" title="贪" /></a>
<a onclick="javascript:grin('{smile:10}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/10.gif" alt="奸" title="奸" /></a>
<a onclick="javascript:grin('{smile:11}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/10.gif" alt="怒" title="怒" /></a>
<a onclick="javascript:grin('{smile:12}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/12.gif" alt="嘿" title="嘿" /></a>
<a onclick="javascript:grin('{smile:13}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/13.gif" alt="羞" title="羞" /></a>
<a onclick="javascript:grin('{smile:14}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/14.gif" alt="汗" title="汗" /></a>
<a onclick="javascript:grin('{smile:15}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/15.gif" alt="色" title="色" /></a>
<a onclick="javascript:grin('{smile:16}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/16.gif" alt="惊" title="惊" /></a>
<a onclick="javascript:grin('{smile:17}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/17.gif" alt="萌" title="萌" /></a>
<a onclick="javascript:grin('{smile:18}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/18.gif" alt="悲" title="悲" /></a>
<a onclick="javascript:grin('{smile:19}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/19.gif" alt="笑" title="笑" /></a>
<a onclick="javascript:grin('{smile:20}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/20.gif" alt="惊" title="惊" /></a>
<a onclick="javascript:grin('{smile:21}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/21.gif" alt="狂" title="狂" /></a>
<a onclick="javascript:grin('{smile:22}')"><img class="lazy " src="<?php echo TEMPLATE_URL; ?>ui/images/smilies/22.gif" alt="吃" title="吃" /></a>
<script type="text/javascript" language="javascript">
/* <![CDATA[ */
  var 
      clone   = smiley.clone();
      comment = jQuery( "#comment" );

  smiley.remove();
  comment.before( smiley );

  function grin(tag) {
    var myField;
    tag = ' ' + tag + ' ';
      if ( document.getElementById( 'comment' ) && document.getElementById( 'comment' ).type == 'textarea' ) {
      myField = document.getElementById( 'comment' );
    } else {
      return false;
    }
    if (document.selection) {
      myField.focus();
      sel = document.selection.createRange();
      sel.text = tag;
      myField.focus();
    }
    else if ( myField.selectionStart || myField.selectionStart == '0' ) {
      var startPos = myField.selectionStart;
      var endPos = myField.selectionEnd;
      var cursorPos = endPos;
      myField.value = myField.value.substring(0, startPos)
              + tag
              + myField.value.substring( endPos, myField.value.length );
      cursorPos += tag.length;
      myField.focus();
      myField.selectionStart = cursorPos;
      myField.selectionEnd = cursorPos;
    }
    else {
      myField.value += tag;
      myField.focus();
    }
  }
/* ]]> */
</script> 
</div>
<?php else:?>
<?php endif; ?>