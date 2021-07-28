<?php
function displayTextWithLinks($s)
{
   return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a target=_blank href="$1">$1</a>', $s);
}

foreach ($docs as $value) {
   print_r($value['docs']);
?>
   <tr>
      <!-- <td><?php //echo $value["lastname"] . ", " . $value['firstname'] . " (" . $value["admission_no"] . ")"; 
               ?></td> -->
      <td><?php echo $value["lastname"] . ", " . $value['firstname']; ?></td>
      <td><?php echo displayTextWithLinks(strip_tags($value["message"])); ?></td>
      <td><?php echo displayTextWithLinks(strip_tags($value["url_link"])); ?></td>

      <td><?php echo $value["created_at"]; ?></td>
      <td>
         <?php if ($value['docs'] != '') { ?>
            <!-- <a class="btn btn-default btn-xs" href="<?php echo base_url(); ?>homework/assigmnetDownload/<?php ?>/<?php echo $value['docs']; ?>" title="" data-original-title="Evaluation"><i class="fa fa-eye"></i></a> -->
            <?php if (
               strpos(strtoupper($value['docs']), ".DOC") !== false || strpos(strtoupper($value['docs']), ".XLS") !== false ||
               strpos(strtoupper($value['docs']), ".PPT") !== false || strpos(strtoupper($value['docs']), ".DOCX") !== false ||
               strpos(strtoupper($value['docs']), ".XLSX") !== false || strpos(strtoupper($value['docs']), ".PPTX") !== false
            ) { ?>

               <a data-placement="left" class="btn btn-default btn-xs document_view_btn" file_location="<?php echo base_url(); ?>uploads/homework/assignment/<?php echo $value['docs']; ?>&embedded=true" data-toggle="tooltip" title="<?php echo $this->lang->line('view'); ?>"><i class="fa fa-eye"></i></a>
            <?php } else { ?>
               <a data-placement="left" class="btn btn-default btn-xs document_view_btn" file_location="<?php echo base_url(); ?>homework/assigmnetDownload/<?php echo $value['docs']; ?>" data-toggle="tooltip" title="<?php echo $this->lang->line('view'); ?>"><i class="fa fa-eye"></i></a>
            <?php } ?>
            <a data-placement="left" class="btn btn-default btn-xs" href="<?php echo base_url(); ?>homework/assigmnetDownload/<?php echo $value['docs']; ?>" data-toggle="tooltip" title="Download"><i class="fa fa-download"></i></a>
         <?php } ?>


      </td>
   </tr>
<?php }
?>

<!-- <div class="modal fade" id="document_view_modal" role="dialog">
   <div class="modal-dialog" style="width: 100%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title title text-center transport_fees_title"></h4>
         </div>

         <input type="hidden" class="form-control" id="transport_student_session_id" value="0" readonly="readonly" />
         <iframe class="document_iframe" src="" style="height: 600px;width: 100%;"></iframe>

      </div>
   </div>
</div> -->

<script type="text/javascript">
   // $(".document_view_btn").click(function() {
   //    var pdfjs = "<?php echo site_url('backend/lms/pdfjs/web/viewer.html?file='); ?>";
   //    var file_location = $(this).attr("file_location");
   //    $(".document_iframe").attr("src", pdfjs + file_location);

   //    $('#document_view_modal').modal({
   //       backdrop: 'static',
   //       keyboard: false,
   //       show: true
   //    });
   // });

   $(".document_view_btn").click(function() {
      var file_location = $(this).attr("file_location");

      //'JPG', 'JPEG', 'PNG', 'GIF', 'BMP', 'SVG'
      //'DOC', 'XLS', 'PPT', 'DOCX', 'XLSX', 'PPTX'

      if (file_location.toLocaleUpperCase().includes(".PDF")) {
         var pdfjs = "<?php echo site_url('backend/lms/pdfjs/web/viewer.html?file='); ?>";
         var file_location = $(this).attr("file_location");
         $(".document_iframe").attr("src", pdfjs + file_location);
         $('#document_view_modal').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
         });
      } else if (file_location.toLocaleUpperCase().includes(".JPG") || file_location.toLocaleUpperCase().includes(".JPEG") ||
         file_location.toLocaleUpperCase().includes(".PNG") || file_location.toLocaleUpperCase().includes(".GIF") ||
         file_location.toLocaleUpperCase().includes(".SVG")) {
         $(".document_img").attr("src", file_location);

         $('#document_view_modal_img').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
         });
      } else if (file_location.toLocaleUpperCase().includes(".MP4") || file_location.toLocaleUpperCase().includes(".AVI") ||
         file_location.toLocaleUpperCase().includes(".MOV") || file_location.toLocaleUpperCase().includes(".WMV")) {
         var type = file_location.toLocaleLowerCase().slice(3);

         $(".document_vid").attr("src", file_location);
         $(".document_vid").attr("type", "video/" + type);

         $('#document_view_modal_vid').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
         });
      } else if (file_location.toLocaleUpperCase().includes(".DOC") || file_location.toLocaleUpperCase().includes(".XLS") ||
         file_location.toLocaleUpperCase().includes(".PPT") || file_location.toLocaleUpperCase().includes(".DOCX") ||
         file_location.toLocaleUpperCase().includes(".XLSX") || file_location.toLocaleUpperCase().includes(".PPTX")) {
         var officedoc = "https://view.officeapps.live.com/op/view.aspx?src=";
         var file_location = $(this).attr("file_location");

         $(".document_iframe").attr("src", officedoc + file_location);
         $('#document_view_modal').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
         });
      } else {
         alert("No preview available. You may download the document to view.");
      }

      $("#document_view_modal_vid").on('hidden.bs.modal', function() {
         var media = $(".document_vid").get(0);
         media.pause();
         media.currentTime = 0;
      });

      // $("#full-image").attr("src", file_location);
      // $('#image-viewer').show();
   });
</script>