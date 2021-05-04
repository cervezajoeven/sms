<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  overflow:hidden;padding:10px 5px;word-break:normal;}
.tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
.tg .tg-pb0m{border-color:inherit;text-align:center;vertical-align:bottom}
.tg .tg-c3ow{border-color:inherit;text-align:center;vertical-align:top}
.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
.tg .tg-za14{border-color:inherit;text-align:left;vertical-align:bottom}
</style>

<table class="tg" style="width: 100%" onload="window.print()">
<thead>
  <tr>
    <th class="tg-pb0m" colspan="8">San Isidro Catholic School</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td class="tg-pb0m" colspan="8">1830 Taft Avenue Pasay</td>
  </tr>
  <tr>
    <td class="tg-pb0m" colspan="8">Report Card</td>
  </tr>
  <tr>
    <td class="tg-0pky">Name</td>
    <td class="tg-za14"><?php echo $student['firstname'] . " " . $student['lastname']. " ".$student['middlename']."."; ?></td>
    <td class="tg-za14">LRN</td>
    <td class="tg-za14" colspan="3"><?php echo $student['admission_no']; ?></td>
    <td class="tg-za14">Age </td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-za14">Grade &amp; Section</td>
    <td class="tg-za14"><?php echo $student['class']; ?> - <?php echo $student['section']; ?></td>
    <td class="tg-za14" colspan="6">SY&nbsp;&nbsp;&nbsp;2020 - 2021</td>
  </tr>
  <tr>
    <td class="tg-za14" colspan="2">Learning&nbsp;&nbsp;&nbsp;Areas</td>

    <?php foreach($quarter_list as $row):?>

            <td class="tg-za14"><?php echo $row->description ?></td>
        
    <?php endforeach; ?>
    <td class="tg-za14">Final Rating</td>
    <td class="tg-za14">Action Taken</td>
  </tr>
  
  <?php foreach($resultlist as $row) : ?>
    <?php 
        $average = ($row->Q1 == 0 || $row->Q2 == 0 || $row->Q3 == 0 || $row->Q4 == 0) ? '' : $row->average;
        $final = ($row->Q1 == 0 || $row->Q2 == 0 || $row->Q3 == 0 || $row->Q4 == 0) ? '' : $row->final_grade;
    ?>
    <tr>
        <td class="tg-za14" colspan="2"><?php echo $row->Subjects ?></td>
        <td class="tg-pb0m"><?php echo ($row->Q1 == 0 ? '' : $row->Q1) ?></td>
        <td class="tg-pb0m"><?php echo ($row->Q2 == 0 ? '' : $row->Q2) ?></td>
        <td class="tg-pb0m"><?php echo ($row->Q3 == 0 ? '' : $row->Q3) ?></td>
        <td class="tg-pb0m"><?php echo ($row->Q4 == 0 ? '' : $row->Q4) ?></td>
        <td class="tg-pb0m"><?php echo ($final == 0 ? '' : $final) ?></td>
        <td class="tg-pb0m"><?php echo ($final == 0 ? "No Remarks" : ($final >= 75 ? "Passed":"" )) ?></td>
    </tr>                                                                  
 <?php endforeach; ?>
  <tr>
    <td class="tg-za14" colspan="2">Extra&nbsp;&nbsp;&nbsp;Curricular</td>
    <td class="tg-0pky" colspan="4"></td>
    <td class="tg-c3ow"></td>
    <td class="tg-0pky"></td>
  </tr>
</tbody>
</table>
<script type="text/javascript">
    window.onload = function() { window.print(); }
</script>