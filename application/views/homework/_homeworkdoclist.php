<?php
function displayTextWithLinks($s)
{
   return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a target=_blank href="$1">$1</a>', $s);
}

foreach ($docs as $value) { ?>
   <tr>
      <td><?php echo $value["firstname"] . " " . $value['lastname'] . " (" . $value["admission_no"] . ")"; ?></td>
      <td><?php echo displayTextWithLinks(strip_tags($value["message"])); ?></td>
      <td><?php echo displayTextWithLinks(strip_tags($value["url_link"])); ?></td>
      <td class="mailbox-date pull-right">
         <?php if ($value['docs'] != '') { ?>
            <a class="btn btn-default btn-xs" href="<?php echo base_url(); ?>homework/assigmnetDownload/<?php ?>/<?php echo $value['docs']; ?>" title="" data-original-title="Evaluation"><i class="fa fa-download"></i></a>
         <?php } ?>
      </td>
   </tr>
<?php }
?>