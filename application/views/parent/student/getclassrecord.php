<div class="content-wrapper" style="min-height: 946px;">
   <section class="content-header">
      <h1><i class="fa fa-calendar-times-o"></i> <?php echo $this->lang->line('grades'); ?> </h1>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-md-3">
            <div class="box box-primary">
               <div class="box-body box-profile">
                  <img class="profile-user-img img-responsive img-circle" src="<?php echo $_SESSION['S3_BaseUrl'] . $student['image'] ?>" alt="User profile picture">
                  <h3 class="profile-username text-center"><?php echo $student['firstname'] . " " . $student['lastname']; ?></h3>
                  <ul class="list-group list-group-unbordered">
                     <li class="list-group-item">
                        <b><?php echo $this->lang->line('admission_no'); ?></b> <a class="pull-right"><?php echo $student['admission_no']; ?></a>
                     </li>
                     <li class="list-group-item">
                        <b><?php echo $this->lang->line('roll_no'); ?></b> <a class="pull-right"><?php echo $student['roll_no']; ?></a>
                     </li>
                     <li class="list-group-item">
                        <b><?php echo $this->lang->line('class'); ?></b> <a class="pull-right"><?php echo $student['class']; ?></a>
                     </li>
                     <li class="list-group-item">
                        <b><?php echo $this->lang->line('section'); ?></b> <a class="pull-right"><?php echo $student['section']; ?></a>
                     </li>
                     <li class="list-group-item">
                        <b><?php echo $this->lang->line('date_of_birth'); ?></b> <a class="pull-right text-aqua"><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($student['dob'])); ?></a>
                     </li>
                     <li class="list-group-item">
                        <b><?php echo $this->lang->line('gender'); ?></b> <a class="pull-right text-aqua"><?php echo ucfirst($student['gender']); ?></a>
                     </li>
                     <li class="list-group-item">
                        <b><?php echo $this->lang->line('lrn'); ?></b> <a class="pull-right"><?php echo $student['lrn_no']; ?></a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="col-md-9">
            <div class="box box-warning">
               <div class="box-header ptbnull">
                  <h3 class="box-title titlefix"> <?php echo $this->lang->line('grades'); ?></h3>
                  <div class="box-tools pull-right"></div>
               </div>
               <div class="box-body">
                  <div class="table-responsive">
                     <div class="download_label"><?php echo $this->lang->line('class_ticlass_recordmetable'); ?></div>
                     <?php //if (!empty($resultlist)) { 
                     ?>
                     <table id="class_record" class="table table-stripped display nowrap">
                        <thead>
                           <tr>
                              <th class="text-left">Subjects</th>
                              <?php
                              foreach ($quarter_list as $row) {
                                 echo "<th class=\"text-center\">" . $row->description . "</th>\r\n";
                              }
                              ?>
                              <th class="text-center">Average</th>
                              <th class="text-center">Final Grade</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $q1Tot = 0;
                           $q2Tot = 0;
                           $q3Tot = 0;
                           $q4Tot = 0;
                           $aveTot = 0;
                           $finTot = 0;
                           $rowCtr = 0;

                           foreach ($resultlist as $row) {
                              $average = ($row->Q1 == 0 || $row->Q2 == 0 || $row->Q3 == 0 || $row->Q4 == 0) ? '' : $row->average;
                              $final = ($row->Q1 == 0 || $row->Q2 == 0 || $row->Q3 == 0 || $row->Q4 == 0) ? '' : $row->final_grade;
                              echo "<tr>\r\n";
                              echo "<td class='text-left'>" . $row->Subjects . "</td>\r\n";
                              echo "<td class='text-center" . ($row->Q1 < 75 ? " text-danger" : ($row->Q1 >= 90 ? " text-success" : "")) . "'><b>" . ($row->Q1 == 0 ? '' : $row->Q1) . "</b></td>\r\n";
                              echo "<td class='text-center" . ($row->Q2 < 75 ? " text-danger" : ($row->Q2 >= 90 ? " text-success" : "")) . "'><b>" . ($row->Q2 == 0 ? '' : $row->Q2) . "</b></td>\r\n";
                              echo "<td class='text-center" . ($row->Q3 < 75 ? " text-danger" : ($row->Q3 >= 90 ? " text-success" : "")) . "'><b>" . ($row->Q3 == 0 ? '' : $row->Q3) . "</b></td>\r\n";
                              echo "<td class='text-center" . ($row->Q4 < 75 ? " text-danger" : ($row->Q4 >= 90 ? " text-success" : "")) . "'><b>" . ($row->Q4 == 0 ? '' : $row->Q4) . "</b></td>\r\n";
                              echo "<td class='text-center" . ($average < 75 ? " text-danger" : ($average >= 90 ? " text-success" : "")) . "'><b>" . ($average == 0 ? '' : $average) . "</b></td>\r\n";
                              echo "<td class='text-center" . ($final < 75 ? " text-danger" : ($final >= 90 ? " text-success" : "")) . "'><b>" . ($final == 0 ? '' : $final) . "</b></td>\r\n";
                              echo "</tr>\r\n";

                              $q1Tot += ($row->Q1 !== null ? $row->Q1 : 0);
                              $q2Tot += ($row->Q2 !== null ? $row->Q2 : 0);
                              $q3Tot += ($row->Q3 !== null ? $row->Q3 : 0);
                              $q4Tot += ($row->Q4 !== null ? $row->Q4 : 0);

                              $aveTot += ($row->Q1 == 0 || $row->Q2 == 0 || $row->Q3 == 0 || $row->Q4 == 0) ? 0 : $row->average;
                              $finTot += ($row->Q1 == 0 || $row->Q2 == 0 || $row->Q3 == 0 || $row->Q4 == 0) ? 0 : $row->final_grade;

                              $rowCtr++;
                           }

                           $q1Ave = $q1Tot / $rowCtr;
                           $q2Ave = $q2Tot / $rowCtr;
                           $q3Ave = $q3Tot / $rowCtr;
                           $q4Ave = $q4Tot / $rowCtr;
                           $aveAve = $aveTot / $rowCtr;
                           $finAve = $finTot / $rowCtr;
                           ?>
                        </tbody>
                        <tfoot>
                           <tr>
                              <th class="text-right">General Average</th>
                              <th class="text-center <?php echo ($q1Ave < 75 ? "text-danger" : ($q1Ave >= 90 ? "text-success" : "")); ?>"><?php echo ($q1Ave == 0 ? "" : number_format($q1Ave, 2)); ?></th>
                              <th class="text-center <?php echo ($q2Ave < 75 ? "text-danger" : ($q2Ave >= 90 ? "text-success" : ""));; ?>"><?php echo ($q2Ave == 0 ? "" : number_format($q2Ave, 2)); ?></th>
                              <th class="text-center <?php echo ($q3Ave < 75 ? "text-danger" : ($q3Ave >= 90 ? "text-success" : ""));; ?>"><?php echo ($q3Ave == 0 ? "" : number_format($q3Ave, 2)); ?></th>
                              <th class="text-center <?php echo ($q4Ave < 75 ? "text-danger" : ($q4Ave >= 90 ? "text-success" : ""));; ?>"><?php echo ($q4Ave == 0 ? "" : number_format($q4Ave, 2)); ?></th>
                              <th class="text-center <?php echo ($aveAve < 75 ? "text-danger" : ($aveAve >= 90 ? "text-success" : "")); ?>"><?php echo ($aveAve == 0 ? "" : number_format($aveAve, 2)); ?></th>
                              <th class="text-center <?php echo ($finAve < 75 ? "text-danger" : ($finAve >= 90 ? "text-success" : ""));; ?>"><?php echo ($finAve == 0 ? "" : number_format($finAve, 2)); ?></th>
                           </tr>
                        </tfoot>
                     </table>
                     <?php //} 
                     ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="table-responsive">
            <?php if (isset($student_conduct)) { ?>
               <section class="content-header">
                  <h1><i class="fa fa-calendar-times-o"></i> <?php echo $this->lang->line('grades'); ?> </h1>
               </section>
               <!-- Main content -->
               <section class="content">
                  <div class="row">
                     <div class="col-md-2">
                        <div class="box box-primary">
                           <div class="box-body box-profile">
                              <h3 class="profile-username text-center">Legend</h3>
                              <ul class="list-group list-group-unbordered">
                                 <?php foreach ($legend_list as $legendrow) { ?>
                                    <li class="list-group-item">
                                       <b><?php echo $legendrow->conduct_grade; ?></b> <span class="pull-right"><?php echo $legendrow->description; ?></span>
                                    </li>
                                 <?php } ?>
                              </ul>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-10">
                        <div class="box box-warning">
                           <div class="box-header ptbnull">
                              <h3 class="box-title titlefix"> Conduct Grades</h3>
                              <div class="box-tools pull-right"></div>
                           </div>
                           <div class="box-body">
                              <div class="table-responsive">
                                 <?php if (!empty($student_conduct)) {
                                    if ($conduct_grading_type == "letter") { ?>
                                       <table id="class_record" class="table table-striped table-bordered table-hover conductTable nowrap">
                                          <thead>
                                             <tr>
                                                <th class="text-left">Indicator ID</th>
                                                <th class="text-left">DepEd Indicator</th>
                                                <th class="text-left">Indicator</th>
                                                <th class="text-left">1st Qtr</th>
                                                <th class="text-left">2nd Qtr</th>
                                                <th class="text-left">3rd Qtr</th>
                                                <th class="text-left">4rth Qtr</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php

                                             foreach ($student_conduct as $row) {
                                                echo "<tr>\r\n";
                                                echo "<td class='text-center'>$row->id</td>\r\n";
                                                echo "<td class='text-left'>$row->deped_indicators</td>\r\n";
                                                echo "<td class='text-left'>$row->indicators</td>\r\n";
                                                echo "<td class='text-center'>$row->first_quarter</td>\r\n";
                                                echo "<td class='text-center'>$row->second_quarter</td>\r\n";
                                                echo "<td class='text-center'>$row->third_quarter</td>\r\n";
                                                echo "<td class='text-center'>$row->fourth_quarter</td>\r\n";
                                                echo "</tr>\r\n";
                                             }
                                             ?>
                                          </tbody>
                                          <tfoot>
                                          </tfoot>
                                       </table>
                                    <?php } else if ($conduct_grading_type == "number") { ?>
                                       <table id="class_record" class="table table-striped table-bordered table-hover conductTable nowrap">
                                          <thead>
                                             <tr>
                                                <th class="text-center">ID</th>
                                                <th class="text-center">1st Qtr</th>
                                                <th class="text-center">2nd Qtr</th>
                                                <th class="text-center">3rd Qtr</th>
                                                <th class="text-center">4rth Qtr</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php
                                             foreach ($student_conduct as $row) {
                                                echo "<tr>\r\n";
                                                echo "<td class='text-center'>&nbsp;</td>\r\n";
                                                echo "<td class='text-center'>$row->first_quarter</td>\r\n";
                                                echo "<td class='text-center'>$row->second_quarter</td>\r\n";
                                                echo "<td class='text-center'>$row->third_quarter</td>\r\n";
                                                echo "<td class='text-center'>$row->fourth_quarter</td>\r\n";
                                                echo "</tr>\r\n";
                                             }
                                             ?>
                                          </tbody>
                                          <tfoot>
                                          </tfoot>
                                       </table>
                                 <?php }
                                 } ?>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" name="save_conduct" class="btn btn-primary btn-sm checkbox-toggle pull-right"><i class="fa fa-save"></i> <?php echo $this->lang->line('save'); ?></button>
                                </div>
                            </div>    -->
               </section>
            <?php } ?>
         </div>
      </div>
   </section>
</div>

<script type="text/javascript">
   $(document).ready(function() {
      var table = $('.conductTable').DataTable({
         "aaSorting": [],
         rowReorder: {
            selector: 'td:nth-child(2)'
         },
         // pageLength: 100,
         //responsive: 'false',
         paging: false,
         ordering: false,
         searching: false,
         dom: "Bfrtip",
         buttons: [{
               extend: 'copyHtml5',
               text: '<i class="fa fa-files-o"></i>',
               titleAttr: 'Copy',
               title: $('.download_label').html(),
               exportOptions: {
                  columns: ':visible'
               }
            },

            {
               extend: 'excelHtml5',
               text: '<i class="fa fa-file-excel-o"></i>',
               titleAttr: 'Excel',

               title: $('.download_label').html(),
               exportOptions: {
                  columns: ':visible'
               }
            },

            {
               extend: 'csvHtml5',
               text: '<i class="fa fa-file-text-o"></i>',
               titleAttr: 'CSV',
               title: $('.download_label').html(),
               exportOptions: {
                  columns: ':visible'
               }
            },

            {
               extend: 'pdfHtml5',
               text: '<i class="fa fa-file-pdf-o"></i>',
               titleAttr: 'PDF',
               title: $('.download_label').html(),
               exportOptions: {
                  columns: ':visible'

               }
            },

            {
               extend: 'print',
               text: '<i class="fa fa-print"></i>',
               titleAttr: 'Print',
               title: $('.download_label').html(),
               customize: function(win) {
                  $(win.document.body)
                     .css('font-size', '10pt');

                  $(win.document.body).find('table')
                     .addClass('compact')
                     .css('font-size', 'inherit');
               },
               exportOptions: {
                  columns: ':visible'
               }
            },

            {
               extend: 'colvis',
               text: '<i class="fa fa-columns"></i>',
               titleAttr: 'Columns',
               title: $('.download_label').html(),
               postfixButtons: ['colvisRestore']
            },
         ],
         "columnDefs": [{
            "targets": [0],
            "visible": false,
            "searchable": false
         }]
      });

      $("#class_record").DataTable({
         "paging": false,
         "scrollX": true,
         "fixedHeader": true,
         "dom": 'Bfrtip',
         buttons: [{
               extend: 'copyHtml5',
               footer: 'true',
               text: '<i class="fa fa-files-o"></i>',
               titleAttr: 'Copy',
               title: $('.download_label').html(),
               exportOptions: {
                  columns: ':visible'
               }
            },
            {
               extend: 'excelHtml5',
               footer: 'true',
               text: '<i class="fa fa-file-excel-o"></i>',
               titleAttr: 'XLS',
               customize: function(xlsx) {
                  var sheet = xlsx.xl.worksheets['sheet1.xml'];

                  $('c[r=A1] t', sheet).text('Class Record');
               },
               filename: function() {
                  var d = new Date();
                  var n = d.getTime();
                  return 'Class Record' + '-' + n;
               },
            },

            {
               extend: 'csvHtml5',
               footer: 'true',
               text: '<i class="fa fa-file-text-o"></i>',
               titleAttr: 'CSV',
               title: $('.download_label').html(),
               exportOptions: {
                  columns: ':visible'
               },
               filename: function() {
                  var d = new Date();
                  var n = d.getTime();
                  return 'Class Record' + '-' + n;
               },
            },

            {
               extend: 'pdfHtml5',
               footer: 'true',
               text: '<i class="fa fa-file-pdf-o"></i>',
               titleAttr: 'PDF',
               title: $('.download_label').html(),
               exportOptions: {
                  columns: ':visible'
               },
               filename: function() {
                  var d = new Date();
                  var n = d.getTime();
                  return 'Class Record' + '-' + n;
               },
            },

            {
               extend: 'print',
               footer: 'true',
               text: '<i class="fa fa-print"></i>',
               titleAttr: 'Print',
               title: $('.download_label').html(),
               customize: function(win) {
                  $(win.document.body)
                     .css('font-size', '10pt');

                  $(win.document.body).find('table')
                     .addClass('compact')
                     .css('font-size', 'inherit');
               },
               exportOptions: {
                  columns: ':visible'
               }
            },

            {
               extend: 'colvis',
               footer: 'true',
               text: '<i class="fa fa-columns"></i>',
               titleAttr: 'Columns',
               title: $('.download_label').html(),
               postfixButtons: ['colvisRestore']
            },
         ],
         // "footerCallback": function (settings, json) {
         //     var api = this.api(), data;

         //     // Remove the formatting to get integer data for summation
         //     var intVal = function (i) {
         //         return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
         //     };

         //     // // computing column Total the complete result 
         //     var colCount = $('#class_record').DataTable().columns().header().length;
         //     var quarters = [];

         //     for(let i=1; i<colCount; i++) {
         //         var quarter = api
         //         .column(i)
         //         .data()
         //         .reduce( function (a, b) {
         //             return intVal(a) + intVal(b);
         //         }, 0);

         //         quarters.push(quarter);
         //     }

         //     for(let ii=1; ii<colCount; ii++) {
         //         let rows = $('#class_record').DataTable().data().count()/colCount;
         //         $(api.column(ii).footer()).html((quarters[ii-1]/rows).toFixed(2));
         //     }
         // }
      });
   });
</script>