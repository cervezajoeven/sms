<?php

function gradeCode($codes, $grade, $show)
{
   $retVal = '';

   if ($show) {
      $retVal = '';

      foreach ($codes as $rows) {
         if ($grade >= $rows->min_grade && $grade <= $rows->max_grade) {
            $retVal = $rows->grade_code;
            break;
         }
      }
   } else {
      $retVal = $grade;
   }

   return $retVal;
}

$currentDate = date("d-m-Y");
$age = date_diff(date_create($student['dob']), date_create($currentDate));
// echo "Current age is ".$age->format("%y");

?>

<html>

<head>
   <meta http-equiv=Content-Type content="text/html; charset=windows-1252">
   <style id="SSA-Report-Card_28834_Styles">
      <!--table
      {
         mso-displayed-decimal-separator: "\.";
         mso-displayed-thousand-separator: "\,";
      }

      .xl1528834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 11.0pt;
         font-weight: 400;
         font-style: normal;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: general;
         vertical-align: bottom;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      .xl6328834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 10.0pt;
         font-weight: 400;
         font-style: normal;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: general;
         vertical-align: bottom;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      .xl6428834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 10.0pt;
         font-weight: 400;
         font-style: normal;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: general;
         vertical-align: bottom;
         border-top: none;
         border-right: none;
         border-bottom: .5pt solid windowtext;
         border-left: none;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      .xl6528834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 10.0pt;
         font-weight: 400;
         font-style: normal;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: general;
         vertical-align: bottom;
         border-top: .5pt solid windowtext;
         border-right: none;
         border-bottom: .5pt solid windowtext;
         border-left: none;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      .xl6628834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 11.0pt;
         font-weight: 400;
         font-style: normal;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: center;
         vertical-align: bottom;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      .xl6728834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 10.0pt;
         font-weight: 700;
         font-style: normal;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: center;
         vertical-align: bottom;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      .xl6828834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 10.0pt;
         font-weight: 400;
         font-style: italic;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: center;
         vertical-align: bottom;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      .xl6928834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 10.0pt;
         font-weight: 400;
         font-style: normal;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: center;
         vertical-align: bottom;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      .xl7028834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 10.0pt;
         font-weight: 400;
         font-style: normal;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: general;
         vertical-align: bottom;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      .xl7128834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 11.0pt;
         font-weight: 400;
         font-style: normal;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: center;
         vertical-align: bottom;
         border-top: none;
         border-right: none;
         border-bottom: .5pt solid windowtext;
         border-left: none;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      .xl7228834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 11.0pt;
         font-weight: 400;
         font-style: normal;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: center;
         vertical-align: bottom;
         border-top: .5pt solid windowtext;
         border-right: none;
         border-bottom: .5pt solid windowtext;
         border-left: none;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      .xl7328834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 10.0pt;
         font-weight: 400;
         font-style: normal;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: center;
         vertical-align: bottom;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      .xl7428834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 16.0pt;
         font-weight: 400;
         font-style: normal;
         text-decoration: none;
         font-family: "Old English Text MT", cursive;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: center;
         vertical-align: middle;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      .xl7528834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 10.0pt;
         font-weight: 700;
         font-style: normal;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: center;
         vertical-align: bottom;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      .xl7628834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 10.0pt;
         font-weight: 400;
         font-style: normal;
         text-decoration: underline;
         text-underline-style: single;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: center;
         vertical-align: bottom;
         border-top: .5pt solid windowtext;
         border-right: none;
         border-bottom: .5pt solid windowtext;
         border-left: none;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      .xl7728834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 10.0pt;
         font-weight: 400;
         font-style: normal;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: center;
         vertical-align: bottom;
         border-top: none;
         border-right: none;
         border-bottom: .5pt solid windowtext;
         border-left: none;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      .xl7828834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 10.0pt;
         font-weight: 400;
         font-style: normal;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: "\@";
         text-align: center;
         vertical-align: bottom;
         border-top: .5pt solid windowtext;
         border-right: none;
         border-bottom: .5pt solid windowtext;
         border-left: none;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      .xl7928834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 10.0pt;
         font-weight: 700;
         font-style: normal;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: center;
         vertical-align: bottom;
         border-top: none;
         border-right: none;
         border-bottom: .5pt solid windowtext;
         border-left: none;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      .xl8028834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 10.0pt;
         font-weight: 400;
         font-style: normal;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: center;
         vertical-align: middle;
         border-top: none;
         border-right: none;
         border-bottom: .5pt solid windowtext;
         border-left: none;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      .xl8128834 {
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 10.0pt;
         font-weight: 400;
         font-style: normal;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: center;
         vertical-align: bottom;
         border-top: .5pt solid windowtext;
         border-right: none;
         border-bottom: .5pt solid windowtext;
         border-left: none;
         mso-background-source: auto;
         mso-pattern: auto;
         white-space: nowrap;
      }

      tr {
         mso-height-source: auto;
      }

      col {
         mso-width-source: auto;
      }

      br {
         mso-data-placement: same-cell;
      }

      .style0 {
         mso-number-format: General;
         text-align: general;
         vertical-align: bottom;
         white-space: nowrap;
         mso-rotate: 0;
         mso-background-source: auto;
         mso-pattern: auto;
         color: black;
         font-size: 11.0pt;
         font-weight: 400;
         font-style: normal;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         border: none;
         mso-protection: locked visible;
         mso-style-name: Normal;
         mso-style-id: 0;
      }

      td {
         mso-style-parent: style0;
         padding: 0px;
         mso-ignore: padding;
         color: black;
         font-size: 11.0pt;
         font-weight: 400;
         font-style: normal;
         text-decoration: none;
         font-family: Calibri, sans-serif;
         mso-font-charset: 0;
         mso-number-format: General;
         text-align: general;
         vertical-align: bottom;
         border: none;
         mso-background-source: auto;
         mso-pattern: auto;
         mso-protection: locked visible;
         white-space: nowrap;
         mso-rotate: 0;
      }

      .xl65 {
         mso-style-parent: style0;
         font-weight: 700;
         vertical-align: middle;
         border: .5pt solid windowtext;
         white-space: normal;
      }

      .xl66 {
         mso-style-parent: style0;
         text-align: center;
         vertical-align: middle;
         border: .5pt solid windowtext;
         white-space: normal;
      }

      .xl67 {
         mso-style-parent: style0;
         font-size: 8.0pt;
         font-weight: 700;
         vertical-align: middle;
         border: .5pt solid windowtext;
         white-space: normal;
      }

      .xl68 {
         mso-style-parent: style0;
         font-size: 8.0pt;
         text-align: center;
         vertical-align: middle;
         border: .5pt solid windowtext;
         white-space: normal;
      }

      .xl69 {
         mso-style-parent: style0;
         text-align: left;
         vertical-align: middle;
         border: .5pt solid windowtext;
         white-space: normal;
         padding-left: 2px;
      }

      .xl70 {
         mso-style-parent: style0;
         text-align: center;
         border: .5pt solid windowtext;
      }

      .xl71 {
         mso-style-parent: style0;
         text-align: center;
      }

      .xl72 {
         mso-style-parent: style0;
         border-top: none;
         border-right: none;
         border-bottom: 1.0pt solid windowtext;
         border-left: none;
      }

      .xl73 {
         mso-style-parent: style0;
         border-top: 1.0pt solid windowtext;
         border-right: none;
         border-bottom: none;
         border-left: none;
      }

      .xl74 {
         mso-style-parent: style0;
         font-weight: 700;
         text-align: center;
         border-top: none;
         border-right: none;
         border-bottom: .5pt solid windowtext;
         border-left: none;
      }

      .xl75 {
         mso-style-parent: style0;
         text-align: left;
      }

      .xl76 {
         mso-style-parent: style0;
         font-weight: 700;
         text-align: left;
      }

      .xl77 {
         mso-style-parent: style0;
         font-weight: 700;
         mso-number-format: "\@";
         text-align: left;
      }

      .xl78 {
         mso-style-parent: style0;
         font-weight: 700;
         text-align: center;
      }

      .xl79 {
         mso-style-parent: style0;
         font-size: 20.0pt;
         font-family: "Old English Text MT", cursive;
         mso-font-charset: 0;
         text-align: center;
         vertical-align: middle;
      }

      .xl80 {
         mso-style-parent: style0;
         text-align: center;
         vertical-align: middle;
         border: .5pt solid windowtext;
      }
   </style>
</head>

<body onload="window.print()">

<div id="SSA-Report-Card_28833" align="center">
      <table border=0 cellpadding=0 cellspacing=0 width=705 style='border-collapse: collapse;table-layout:fixed;width:525pt'>
         <col width=20 style='mso-width-source:userset;mso-width-alt:711;width:15pt'>
         <col width=78 style='mso-width-source:userset;mso-width-alt:2787;width:59pt'>
         <col width=46 span=8 style='mso-width-source:userset;mso-width-alt:1621; width:34pt'>
         <col width=46 style='mso-width-source:userset;mso-width-alt:1649;width:35pt'>
         <col width=46 span=2 style='mso-width-source:userset;mso-width-alt:1621; width:34pt'>
         <col width=81 style='mso-width-source:userset;mso-width-alt:2872;width:61pt'>
         <col width=20 style='mso-width-source:userset;mso-width-alt:711;width:15pt'>
         <tr colspan="15" style="height: 15px;"><td>Form 138</td></tr>
         <tr>
            <td colspan=15 align=left valign=top>
               
               <span style='mso-ignore:vglayout; position:absolute;z-index:1;margin-left:36px;margin-top:8px;width:650px; height:508px'>
                  <table cellpadding=0 cellspacing=0>
                     <tr>
                        <td width=0 height=0></td>
                        <td width=520></td>
                        <td width=14></td>
                        <td width=116></td>
                     </tr>
                     <tr>
                        <td height=5></td>
                        <td rowspan=3 align=left valign=top><img width=520 height=508 src="https://media.campuscloudph.com/ssapamp/uploads/gallery/media/image004.png" v:shapes="Picture_x0020_9 Picture_x0020_1"></td>
                     </tr>
                     <tr>
                        <td height=116></td>
                        <td></td>
                        <td align=left valign=top><img width=116 height=116 src="https://media.campuscloudph.com/ssapamp/uploads/gallery/media/image005.png" v:shapes="Picture_x0020_2"></td>
                     </tr>
                     <tr>
                        <td height=387></td>
                     </tr>
                  </table>
               </span>
            </td>
         </tr>
         <tr>
            <td colspan=15 class=xl79 style="padding-top:25px">St. Scholastica’ s Academy</td>
         </tr>
         <tr>
            <td colspan=15 height=19 class=xl71>CITY OF SAN FERNANDO, PAMPANGA</td>
         </tr>
         <tr style='mso-height-source:userset;height:18pt'>
            <td colspan=15 class=xl78 style='height:18pt'>Grade School Department</td>
         </tr>
         <tr height=39 style='mso-height-source:userset;height:29.4pt'>
         </tr>
         <tr height=19 style='height:14.4pt'>
            <td></td>
            <td colspan=3>LRN</td>
            <td colspan=4 class=xl77><?php echo $student['lrn_no']; ?></td>
            <td colspan=3 class=xl75>School Year: &nbsp;&nbsp;&nbsp;<span class=xl78><?php echo $school_year; ?></span></td>
            <td class=xl78><?php //echo $school_year; 
                           ?></td>
         </tr>
         <tr height=19 style='height:14.4pt'>
            <td height=19 style='height:14.4pt'></td>
            <td colspan=3>Name</td>
            <td colspan=11 class=xl76><?php echo ucfirst(ucfirst($student['lastname']) . ", " . $student['firstname']) . " " . ucfirst($student['middlename']); ?></td>
         </tr>
         <tr height=19 style='height:14.4pt'>
            <td height=19 style='height:14.4pt'></td>
            <td colspan=3>Grade and Section</td>
            <td colspan=11 class=xl76><?php echo $student['class'] . " - " . $student['section']; ?></td>
         </tr>
         <tr height=19 style='height:14.4pt'>
            <td height=19 style='height:14.4pt'></td>
            <td colspan=3>Age</td>
            <td colspan=11 class=xl76><?php echo $age->format("%y"); ?></td>
         </tr>
         <tr height=19 style='height:14.4pt'>
            <td height=19 style='height:14.4pt'></td>
            <td colspan=3>Grading System</td>
            <td colspan=11 class=xl76>Averaging</td>
         </tr>
         <tr height=20 style='height:15.0pt'>
            <td colspan=15 height=20 class=xl72 style='height:15.0pt'>&nbsp;</td>
         </tr>
         <tr height=19 style='height:14.4pt'>
            <td colspan=15 height=19 class=xl73 style='height:14.4pt'>&nbsp;</td>
         </tr>
         <tr height=19 style='height:14.4pt'>
            <td height=19 style='height:14.4pt'></td>
            <td colspan=4 rowspan=2 class=xl66 width=216 style='width:161pt'>Subjects</td>
            <td colspan=6 class=xl70 style='border-left:none'>Semesters</td>
            <td colspan=3 rowspan=2 class=xl80>Final Rating</td>
            <td></td>
         </tr>
         <tr height=19 style='height:14.4pt'>
            <td height=19 style='height:14.4pt'></td>
            <td colspan=3 class=xl70 style='border-left:none'>1st</td>
            <td colspan=3 class=xl70 style='border-left:none'>2nd</td>
            <td></td>
         </tr>

         <?php foreach ($resultlist as $row) :
            $final = ($row->Q1 == 0 || $row->Q2 == 0) ? '--' : $row->final_grade; ?>
            <tr height=21 style='mso-height-source:userset;height:15.6pt'>
               <td height=21 style='height:15.6pt'></td>
               <td colspan=4 class=xl69 width=216 style='width:161pt; padding-left:5px'><?php echo $row->Subjects ?></td>
               <td colspan=3 class=xl70 style='border-left:none'><?php echo ($row->Q1 == 0 ? '--' : gradeCode($codes_table, $row->Q1, 1)); ?></td>
               <td colspan=3 class=xl70 style='border-left:none'><?php echo ($row->Q2 == 0 ? '--' : gradeCode($codes_table, $row->Q2, 1)); ?></td>
               <td colspan=3 class=xl70 style='border-left:none'><?php echo $final; ?></td>        
               <td height=21 style='height:15.6pt'></td>    
            </tr>
         <?php endforeach ?>
         <tr height=21 style='mso-height-source:userset;height:15.6pt'>
            <td height=21 style='height:15.6pt'></td>
            <td colspan=4 class=xl69 width=216 style='width:161pt; padding-left:5px'>CONDUCT</td>
            <td colspan=3 class=xl70 style='border-left:none'><?php echo $ssap_conduct->a1; ?></td>
            <td colspan=3 class=xl70 style='border-left:none'><?php echo $ssap_conduct->a2; ?></td>
            <td colspan=3 class=xl70 style='border-left:none'><?php echo $ssap_conduct->finalgrade; ?></td>        
            <td height=21 style='height:15.6pt'></td> 
         </tr>
      
         <tr height=19 style='height:14.4pt'>
         </tr>
         <tr height=19 style='height:14.4pt'>
            <td height=19 style='height:14.4pt'></td>
            <td colspan="2" class=xl65 width=78 style='width:59pt'>&nbsp;&nbsp;Months</td>
            <?php foreach ($month_days_list as $row) : ?>
               <td class=xl66 width=46 style='border-left:none;width:34pt'><?php echo substr($row->month, 0, 3); ?></td>
            <?php endforeach ?>
            <td class=xl66 width=81 style='border-left:none;width:61pt'>Total</td>
            <td></td>
         </tr>
         <tr height=19 style='height:14.4pt'>
            <td height=19 style='height:14.4pt'></td>
            <td colspan="2" class=xl67 width=78 style='border-top:none;width:59pt'>&nbsp;&nbsp;Days of School</td>
            <?php foreach ($month_days_list as $row) :
               $total += $row->no_of_days; ?>
               <td class=xl68 width=46 style='border-left:none;width:34pt'><?php echo $row->no_of_days; ?></td>
            <?php endforeach ?>
            <td class=xl68 width=81 style='border-top:none;border-left:none;width:61pt'><?php echo $total; ?></td>
            <td></td>
         </tr>
         <tr height=19 style='height:14.4pt'>
            <td height=19 style='height:14.4pt'></td>
            <td colspan="2" class=xl67 width=78 style='border-top:none;width:59pt'>&nbsp;&nbsp;Days Present</td>
            <?php
            $total = 0;
            foreach ($month_days_list as $row) :
               $month = $row->month;
               $total += json_decode($student_attendance['attendance'])->$month; ?>
               <td class=xl68 width=46 style='border-top:none;border-left:none;width:34pt'><?php echo json_decode($student_attendance['attendance'])->$month; ?></td>
            <?php endforeach ?>
            <td class=xl68 width=81 style='border-top:none;border-left:none;width:61pt'><?php echo $total; ?></td>
            <td></td>
         </tr>
         <tr height=19 style='height:14.4pt'>
            <td height=19 style='height:14.4pt'></td>
            <td colspan="2" class=xl67 width=78 style='border-top:none;width:59pt'>&nbsp;&nbsp;Times Tardy</td>
            <?php
            $total = 0;
            foreach ($month_days_list as $row) :
               $month = $row->month;
               $total += json_decode($student_attendance['tardy'])->$month; ?>
               <td class=xl68 width=46 style='border-top:none;border-left:none;width:34pt'><?php echo json_decode($student_attendance['tardy'])->$month; ?></td>
            <?php endforeach ?>
            <td class=xl68 width=81 style='border-top:none;border-left:none;width:61pt'><?php echo $total; ?></td>
            <td></td>
         </tr>
         <tr height=19 style='height:14.4pt'>
            <td colspan=15 rowspan=2 height=38 class=xl71 style='height:28.8pt'></td>
         </tr>
         <tr height=19 style='height:14.4pt'>
         </tr>
         <tr height=19 style='height:14.4pt'>
            <td colspan=2 height=19 class=xl78 style='height:14.4pt'></td>
            <td colspan=11 class=xl74><?php echo $class_adviser ?></td>
            <td colspan=2 class=xl78></td>
         </tr>
         <tr height=19 style='height:14.4pt'>
            <td colspan=15 height=19 class=xl71 style='height:14.4pt'>Class Adviser</td>
         </tr>
      </table>
   </div>

   <div style="height: '40px';">&nbsp;</div>

   <div id="SSA-Report-Card_28834" align="center" style="break-before:page">
      <table border=0 cellpadding=0 cellspacing=0 width=807 class=xl6328834
         style='border-collapse:collapse;table-layout:fixed;width:605pt'>
         <col width=46 style='mso-width-source:userset;mso-width-alt:1621;width:34pt'>
         <col width=159 span=2 style='mso-width-source:userset;mso-width-alt:5660; width:119pt'>
         <col width=46 style='mso-width-source:userset;mso-width-alt:1621;width:34pt'>
         <col class=xl6328834 width=18 style='mso-width-source:userset;mso-width-alt: 654;width:14pt'>
         <col class=xl6328834 width=113 style='mso-width-source:userset;mso-width-alt: 4010;width:85pt'>
         <col class=xl6328834 width=266 style='mso-width-source:userset;mso-width-alt: 9472;width:200pt'>
         <tr height=19 style='height:14.4pt'>
         <td height=19 class=xl1528834 width=46 style='height:14.4pt;width:34pt'></td>
         <td class=xl1528834 width=159 style='width:119pt'></td>
         <td class=xl1528834 width=159 style='width:119pt'></td>
         <td class=xl1528834 width=46 style='width:34pt'></td>
         <td class=xl6328834 width=18 style='width:14pt'></td>
         <td colspan=2 rowspan=6 height=114 width=379 style='height:86.4pt;width:285pt' align=left valign=top>
         <span style='z-index:1;margin-left:140px;margin-top:2px;width:108px; height:113px'>
               <img width=116 height=116 src="https://media.campuscloudph.com/ssapamp/uploads/gallery/media/image002.png" v:shapes="Picture_x0020_1">
            </span>
            
         </span></td>
         </tr>
         <tr height=19 style='mso-height-source:userset;height:14.4pt'>
         <td colspan=2 height=19 class=xl6328834 style='height:14.4pt'>Promoted to Grade</td>
         <td colspan=2 class=xl8028834><?php echo ($student['class'] == 'Pre-Kinder' ? 'Kindergarten' : 'One') ?></td>
         <td class=xl1528834></td>
         </tr>
         <tr height=19 style='mso-height-source:userset;height:14.4pt'>
         <td colspan=2 height=19 class=xl6328834 style='height:14.4pt'>Promoted on Probation to Grade</td>
         <td colspan=2 class=xl8128834>&nbsp;</td>
         <td class=xl1528834></td>
         </tr>
         <tr height=19 style='mso-height-source:userset;height:14.4pt'>
         <td colspan=2 height=19 class=xl6328834 style='height:14.4pt'>Retained in Grade</td>
         <td colspan=2 class=xl7628834><u style='visibility:hidden;mso-ignore:visibility'>&nbsp;</u></td>
         <td class=xl1528834></td>
         </tr>
         <tr height=19 style='mso-height-source:userset;height:14.4pt'>
         <td colspan=2 height=19 class=xl6328834 style='height:14.4pt'>Eligible for Transfer and Admission</td>
         <td colspan=2 class=xl7328834></td>
         <td class=xl1528834></td>
         </tr>
         <tr height=19 style='mso-height-source:userset;height:14.4pt'>
         <td colspan=2 height=19 class=xl6328834 style='height:14.4pt'>to Grade</td>
         <td colspan=2 class=xl7728834>&nbsp;</td>
         <td class=xl1528834></td>
         </tr>
         <tr height=19 style='mso-height-source:userset;height:14.4pt'>
         <td colspan=2 height=19 class=xl6328834 style='height:14.4pt'>Date</td>
         <td colspan=2 class=xl7828834><?php echo ($student['class'] == 'Pre-Kinder' ? 'May 11, 2022' : 'May 11, 2022') ?></td>
         <td class=xl1528834></td>
         <td colspan=2 rowspan=2 class=xl7428834>St. Scholastica’s Academy</td>
         </tr>
         <tr height=19 style='mso-height-source:userset;height:14.4pt'>
         <td colspan=4 rowspan=4 height=76 class=xl6628834 style='height:57.6pt'></td>
         <td class=xl6328834></td>
         </tr>
         <tr height=19 style='mso-height-source:userset;height:14.4pt'>
         <td height=19 class=xl6328834 style='height:14.4pt'></td>
         <td colspan=2 class=xl6928834>CITY OF SAN FERNANDO, PAMPANGA</td>
         </tr>
         <tr height=19 style='mso-height-source:userset;height:14.4pt'>
         <td height=19 class=xl6328834 style='height:14.4pt'></td>
         <td colspan=2 class=xl6928834></td>
         </tr>
         <tr height=19 style='mso-height-source:userset;height:14.4pt'>
         <td height=19 class=xl6328834 style='height:14.4pt'></td>
         <td colspan=2 class=xl7528834>(PAASCU ACCREDITED)</td>
         </tr>
         <tr height=19 style='height:14.4pt'>
         <td height=19 class=xl1528834 style='height:14.4pt'></td>
         <td colspan=2 class=xl7928834>Sister Alexis Lamarroza, OSB</td>
         <td class=xl1528834></td>
         <td class=xl1528834></td>
         <td colspan=2 class=xl6628834></td>
         </tr>
         <tr height=19 style='height:14.4pt'>
         <td height=19 class=xl1528834 style='height:14.4pt'></td>
         <td colspan=2 class=xl7328834>Principal</td>
         <td class=xl1528834></td>
         <td class=xl1528834></td>
         <td colspan=2 class=xl6728834>REPORT CARD</td>
         </tr>
         <tr height=19 style='mso-height-source:userset;height:14.4pt'>
         <td colspan=4 rowspan=3 height=57 class=xl6628834 style='height:43.2pt'></td>
         <td class=xl6328834></td>
         <td colspan=2 class=xl6828834>Grade School</td>
         </tr>
         <tr height=19 style='mso-height-source:userset;height:14.4pt'>
         <td height=19 class=xl6328834 style='height:14.4pt'></td>
         <td colspan=2 rowspan=6 class=xl6928834></td>
         </tr>
         <tr height=19 style='mso-height-source:userset;height:14.4pt'>
         <td height=19 class=xl6328834 style='height:14.4pt'></td>
         </tr>
         <tr height=19 style='height:14.4pt'>
         <td height=19 class=xl1528834 style='height:14.4pt'></td>
         <td colspan=2 class=xl6728834>CANCELLATION OF TRANSFER ELIGIBILITY</td>
         <td class=xl1528834></td>
         <td class=xl6328834></td>
         </tr>
         <tr height=19 style='height:14.4pt'>
         <td height=19 class=xl1528834 style='height:14.4pt'></td>
         <td class=xl1528834></td>
         <td class=xl1528834></td>
         <td class=xl1528834></td>
         <td class=xl6328834></td>
         </tr>
         <tr height=19 style='height:14.4pt'>
         <td colspan=2 height=19 class=xl7028834 style='height:14.4pt'>Has been admitted to</td>
         <td colspan=2 class=xl7128834>&nbsp;</td>
         <td class=xl6328834></td>
         </tr>
         <tr height=19 style='height:14.4pt'>
         <td colspan=2 height=19 class=xl7028834 style='height:14.4pt'>Date</td>
         <td colspan=2 class=xl7228834>&nbsp;</td>
         <td class=xl6328834></td>
         </tr>
         <tr height=19 style='mso-height-source:userset;height:14.4pt'>
         <td colspan=4 rowspan=2 height=38 class=xl6628834 style='height:28.8pt'></td>
         <td class=xl6328834></td>
         <td class=xl6328834>Name</td>
         <td class=xl6428834><?php echo ucfirst($student['firstname']) . " " . ucfirst($student['middlename'] . " " . ucfirst($student['lastname'])); ?></td>
         </tr>
         <tr height=19 style='mso-height-source:userset;height:14.4pt'>
         <td height=19 class=xl6328834 style='height:14.4pt'></td>
         <td class=xl6328834>Grade and Section</td>
         <td class=xl6528834 style='border-top:none'><?php echo $student['class'] . " - " . $student['section']; ?></td>
         </tr>
         <tr height=19 style='height:14.4pt'>
         <td height=19 class=xl1528834 style='height:14.4pt'></td>
         <td colspan=2 class=xl7128834>&nbsp;</td>
         <td class=xl1528834></td>
         <td class=xl6328834></td>
         <td class=xl6328834>School Year</td>
         <td class=xl6528834 style='border-top:none'><?php echo $school_year; ?></td>
         </tr>
         <tr height=19 style='height:14.4pt'>
         <td height=19 class=xl1528834 style='height:14.4pt'></td>
         <td colspan=2 class=xl7328834>Principal</td>
         <td class=xl1528834></td>
         <td class=xl6328834></td>
         <td class=xl6328834>Class Adviser</td>
         <td class=xl6528834 style='border-top:none'><?php echo $class_adviser ?></td>
         </tr>      
      </table>
   </div>

   
</body>

</html>