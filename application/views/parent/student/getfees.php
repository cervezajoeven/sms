<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>

<style>
    .center_qrcode {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 200px;
        border: 1px solid gray;
    }
</style>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="content-header">
                <h1>
                    <i class="fa fa-money"></i> <?php echo $this->lang->line('fees_collection'); ?><small><?php echo $this->lang->line('student_fee'); ?></small>
                </h1>
            </section>
        </div>
    </div>
    <!-- /.control-sidebar -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-4">
                                <h3 class="box-title"><?php echo $this->lang->line('student_fees'); ?></h3>
                            </div>
                            <div class="col-md-8 ">
                                <div class="btn-group pull-right">
                                    <a href="<?php echo base_url() ?>parent/parents/dashboard" type="button" class="btn btn-primary btn-xs">
                                        <i class="fa fa-arrow-left"></i> <?php echo $this->lang->line('back'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--./box-header-->
                    <div class="box-body" style="padding-top:0;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="sfborder">
                                    <div class="col-md-2">
                                        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url() . $student['image'] ?>" alt="User profile picture">
                                    </div>

                                    <div class="col-md-10">
                                        <div class="row">

                                            <table class="table table-striped mb0 font13">
                                                <tbody>
                                                    <tr>
                                                        <th class="bozero"><?php echo $this->lang->line('name'); ?></th>
                                                        <td class="bozero"><?php echo $student['firstname'] . " " . $student['lastname'] ?></td>

                                                        <th class="bozero"><?php echo $this->lang->line('class_section'); ?></th>
                                                        <td class="bozero"><?php echo $student['class'] . " (" . $student['section'] . ")" ?> </td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('father_name'); ?></th>
                                                        <td><?php echo $student['father_name']; ?></td>
                                                        <th><?php echo $this->lang->line('admission_no'); ?></th>
                                                        <td><?php echo $student['admission_no']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('mobile_no'); ?></th>
                                                        <td><?php echo $student['mobileno']; ?></td>
                                                        <th><?php echo $this->lang->line('roll_no'); ?></th>
                                                        <td> <?php echo $student['roll_no']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('category'); ?></th>
                                                        <td>
                                                            <?php
                                                            foreach ($categorylist as $value) {
                                                                if ($student['category_id'] == $value['id']) {
                                                                    echo $value['category'];
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <!-- <th><?php echo $this->lang->line('rte'); ?></th>
                                                        <td><b class="text-danger"> <?php echo $student['rte']; ?> </b></td> -->
                                                    </tr>

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <!-- <small><button id="btn-kampuspay" type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#newKampusPayment">Make a payment using KampusPay</button></small> -->
                                    <small><button id="btn-kampuspay" type="button" class="btn btn-success btn-sm pull-right" onclick="ShowKampusPayment()">Make a payment using KampusPay</button></small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div style="background: #dadada; height: 1px; width: 100%; clear: both; margin-bottom: 10px; margin-top: 10px;"></div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <div class="download_label"><?php echo $this->lang->line('student_fees') . ": " . $student['firstname'] . " " . $student['lastname'] ?> </div>
                            <?php
                            if (empty($student_due_fee)) {
                            ?>
                                <div class="alert alert-danger">
                                    No fees Found.
                                </div>
                            <?php
                            } else {
                            ?>
                                <table class="table table-striped table-bordered table-hover  table-fixed-header">
                                    <thead>
                                        <tr>
                                            <th align="left"><?php echo $this->lang->line('fees_group'); ?></th>
                                            <th align="left"><?php echo "Payment Type"; ?></th>
                                            <th align="left" class="text text-center"><?php echo $this->lang->line('due_date'); ?></th>
                                            <th align="left" class="text text-left"><?php echo $this->lang->line('status'); ?></th>
                                            <th class="text text-right"><?php echo $this->lang->line('amount') ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                            <th class="text text-left"><?php echo $this->lang->line('payment_id'); ?></th>
                                            <th class="text text-left"><?php echo $this->lang->line('mode'); ?></th>
                                            <th class="text text-left"><?php echo $this->lang->line('date'); ?></th>
                                            <th class="text text-left">O.R.</th>
                                            <th class="text text-right"><?php echo $this->lang->line('discount'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                            <th class="text text-right"><?php echo $this->lang->line('fine'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                            <th class="text text-right"><?php echo $this->lang->line('paid'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                            <th class="text text-right"><?php echo $this->lang->line('balance'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_amount = "0";
                                        $total_deposite_amount = "0";
                                        $total_fine_amount = "0";
                                        $total_discount_amount = "0";
                                        $total_balance_amount = "0";

                                        foreach ($student_due_fee as $key => $fee) {

                                            foreach ($fee->fees as $fee_key => $fee_value) {


                                                $fee_paid = 0;
                                                $fee_discount = 0;
                                                $fee_fine = 0;
                                                $alot_fee_discount = 0;


                                                if (!empty($fee_value->amount_detail)) {
                                                    $fee_deposits = json_decode(($fee_value->amount_detail));

                                                    foreach ($fee_deposits as $fee_deposits_key => $fee_deposits_value) {
                                                        $fee_paid = $fee_paid + $fee_deposits_value->amount;
                                                        $fee_discount = $fee_discount + $fee_deposits_value->amount_discount;
                                                        $fee_fine = $fee_fine + $fee_deposits_value->amount_fine;
                                                    }
                                                }
                                                $total_amount = $total_amount + $fee_value->amount;
                                                $total_discount_amount = $total_discount_amount + $fee_discount;
                                                $total_deposite_amount = $total_deposite_amount + $fee_paid;
                                                $total_fine_amount = $total_fine_amount + $fee_fine;
                                                $feetype_balance = $fee_value->amount - ($fee_paid + $fee_discount);
                                                $total_balance_amount = $total_balance_amount + $feetype_balance;
                                        ?>
                                                <?php
                                                if ($feetype_balance > 0 && strtotime($fee_value->due_date) < strtotime(date('Y-m-d'))) {
                                                ?>
                                                    <tr class="danger font12">
                                                    <?php
                                                } else {
                                                    ?>
                                                    <tr class="dark-gray">
                                                    <?php
                                                }
                                                    ?>


                                                    <td align="left"><?php echo $fee_value->name; ?></td>
                                                    <td align="left"><?php echo $fee_value->type; ?></td>
                                                    <td align="left" class="text text-center">

                                                        <?php
                                                        if ($fee_value->due_date == "0000-00-00") {
                                                        } else {

                                                            echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($fee_value->due_date));
                                                        }
                                                        ?>
                                                    </td>
                                                    <td align="left" class="text text-left">
                                                        <?php
                                                        if ($feetype_balance == 0) {
                                                        ?><span class="label label-success"><?php echo $this->lang->line('paid'); ?></span><?php
                                                                                                                                        } else if (!empty($fee_value->amount_detail)) {
                                                                                                                                            ?><span class="label label-warning"><?php echo $this->lang->line('partial'); ?></span><?php
                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                    ?><span class="label label-danger"><?php echo $this->lang->line('unpaid'); ?></span><?php
                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                        ?>

                                                    </td>
                                                    <td class="text text-right"><?php echo $fee_value->amount; ?></td>

                                                    <td class="text text-left"></td>
                                                    <td class="text text-left"></td>
                                                    <td class="text text-left"></td>
                                                    <td class="text text-left"></td>
                                                    <td class="text text-right"><?php
                                                                                echo (number_format($fee_discount, 2, '.', ''));
                                                                                ?></td>
                                                    <td class="text text-right"><?php
                                                                                echo (number_format($fee_fine, 2, '.', ''));
                                                                                ?></td>
                                                    <td class="text text-right"><?php
                                                                                echo (number_format($fee_paid, 2, '.', ''));
                                                                                ?></td>
                                                    <td class="text text-right">
                                                        <?php
                                                        $display_none = "ss-none";
                                                        if ($feetype_balance > 0) {
                                                            $display_none = "";
                                                            echo (number_format($feetype_balance, 2, '.', ''));
                                                        }
                                                        ?>

                                                    </td>

                                                    <td>
                                                        <div class="btn-group pull-right">
                                                            <?php
                                                            if ($payment_method) {

                                                                if ($feetype_balance > 0) {
                                                            ?>
                                                                    <a href="<?php echo base_url() . 'parent/payment/pay/' . $fee->id . "/" . $fee_value->fee_groups_feetype_id . "/" . $student['id'] ?>" class="btn btn-xs btn-primary pull-right myCollectFeeBtn"><i class="fa fa-money"></i> Pay</a>
                                                            <?php
                                                                }
                                                            }
                                                            ?>

                                                        </div>
                                                    </td>


                                                    </tr>

                                                    <?php
                                                    if (!empty($fee_value->amount_detail)) {

                                                        $fee_deposits = json_decode(($fee_value->amount_detail));

                                                        foreach ($fee_deposits as $fee_deposits_key => $fee_deposits_value) {
                                                    ?>
                                                            <tr class="white-td">
                                                                <td align="left"></td>
                                                                <td align="left"></td>
                                                                <td align="left"></td>
                                                                <td align="left"></td>
                                                                <td class="text-right"><img src="<?php echo base_url(); ?>backend/images/table-arrow.png" alt="" /></td>
                                                                <td class="text text-left">
                                                                    <a href="#" data-toggle="popover" class="detail_popover"> <?php echo $fee_value->student_fees_deposite_id . "/" . $fee_deposits_value->inv_no; ?></a>
                                                                    <div class="fee_detail_popover" style="display: none">
                                                                        <?php
                                                                        if ($fee_deposits_value->description == "") {
                                                                        ?>
                                                                            <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <p class="text text-info"><?php echo $fee_deposits_value->description; ?></p>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </td>
                                                                <td class="text text-left"><?php echo $fee_deposits_value->payment_mode; ?></td>
                                                                <td class="text text-left"><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($fee_deposits_value->date)); ?></td>
                                                                <td class="text text-left"><?php echo $fee_deposits_value->or_number; ?></td>
                                                                <td class="text text-right"><?php echo (number_format($fee_deposits_value->amount_discount, 2, '.', '')); ?></td>
                                                                <td class="text text-right"><?php echo (number_format($fee_deposits_value->amount_fine, 2, '.', '')); ?></td>
                                                                <td class="text text-right"><?php echo (number_format($fee_deposits_value->amount, 2, '.', '')); ?></td>
                                                                <td></td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                            <?php
                                            }
                                        }
                                            ?>
                                            <?php
                                            if (!empty($student_discount_fee)) {

                                                foreach ($student_discount_fee as $discount_key => $discount_value) {
                                            ?>
                                                    <tr class="dark-light">
                                                        <td align="left"> <?php echo $this->lang->line('discount'); ?> </td>
                                                        <td align="left">
                                                            <?php echo $discount_value['code']; ?>
                                                        </td>
                                                        <td align="left"></td>
                                                        <td align="left" class="text text-left">
                                                            <?php
                                                            if ($discount_value['status'] == "applied") {
                                                            ?>
                                                                <a href="#" data-toggle="popover" class="detail_popover">

                                                                    <?php echo $this->lang->line('discount_of') . " " . $currency_symbol . $discount_value['amount'] . " " . $this->lang->line($discount_value['status']) . " : " . $discount_value['payment_id']; ?>

                                                                </a>
                                                                <div class="fee_detail_popover" style="display: none">
                                                                    <?php
                                                                    if ($discount_value['student_fees_discount_description'] == "") {
                                                                    ?>
                                                                        <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <p class="text text-danger"><?php echo $discount_value['student_fees_discount_description'] ?></p>
                                                                    <?php
                                                                    }
                                                                    ?>

                                                                </div>
                                                            <?php
                                                            } else {
                                                                echo '<p class="text text-danger">' . $this->lang->line('discount_of') . " " . $currency_symbol . $discount_value['amount'] . " " . $this->lang->line($discount_value['status']);
                                                            }
                                                            ?>

                                                        </td>
                                                        <td></td>
                                                        <td class="text text-left"></td>
                                                        <td class="text text-left"></td>
                                                        <td class="text text-left"></td>
                                                        <td class="text text-left"></td>
                                                        <td class="text text-right">
                                                            <?php
                                                            $alot_fee_discount = $alot_fee_discount;
                                                            ?>
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                            <tr class="box box-solid total-bg">
                                                <td align="left"></td>
                                                <td align="left"></td>
                                                <td align="left"></td>
                                                <td align="left" class="text text-left"><?php echo $this->lang->line('grand_total'); ?></td>
                                                <td class="text text-right"><?php
                                                                            echo ($currency_symbol . number_format($total_amount, 2, '.', ''));
                                                                            ?></td>
                                                <td class="text text-left"></td>
                                                <td class="text text-left"></td>
                                                <td class="text text-left"></td>
                                                <td class="text text-left"></td>

                                                <td class="text text-right"><?php
                                                                            echo ($currency_symbol . number_format($total_discount_amount + $alot_fee_discount, 2, '.', ''));
                                                                            ?></td>
                                                <td class="text text-right"><?php
                                                                            echo ($currency_symbol . number_format($total_fine_amount, 2, '.', ''));
                                                                            ?></td>
                                                <td class="text text-right"><?php
                                                                            echo ($currency_symbol . number_format($total_deposite_amount, 2, '.', ''));
                                                                            ?></td>
                                                <td class="text text-right"><?php
                                                                            echo ($currency_symbol . number_format($total_balance_amount - $alot_fee_discount, 2, '.', ''));
                                                                            ?></td>
                                                <td class="text text-right"></td>
                                            </tr>
                                    </tbody>
                                </table>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>


            </div>
            <!--/.col (left) -->

        </div>

    </section>

</div>

<div class="modal fade" tabindex="-1" role="dialog" id="newKampusPayment">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">KampusPay Payment</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="feetype">Fee Type</label>
                    <select class="form-control" id="feetype" name="feetype">
                        <option value="">Select Fee Type</option>
                        <?php foreach ($fee_types as $k => $v) : ?>
                            <option value="<?php echo $v['type'] ?>"><?php echo $v['type'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <!-- <input class="form-control" id="amount" name="amount" placeholder="Enter the amount" autocomplete="off"> -->
                    <input id="amount" class="form-control" placeholder="Enter the amount">
                </div>
                <div class="form-group">
                    <div>
                        <div id="instruction"></div>
                    </div>
                </div>
                <div class="form-group">
                    <!-- <label for="gender">Please scan this with your Banana Pay app to proceed with payment</label> -->
                    <div class="center_qrcode">
                        <div id="qrcodehere"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <div id="notyetlinked" class="pull-left">Account not yet linked to KampusPay? <a style="display: inline;" target="_blank" href="<?php echo $linking_page ?>">Click here.</a></div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="GetQRCode()">Get QR Code</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/js/jquery.qrcode.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        function setInputFilter(textbox, inputFilter) {
            ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
                textbox.addEventListener(event, function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                });
            });
        }

        setInputFilter(document.getElementById("amount"), function(value) {
            return /^-?\d*[.,]?\d*$/.test(value);
        });
    });

    function ShowKampusPayment() {
        $('#feetype').val('');
        $('#amount').val('')
        $('#qrcodehere').html('');
        $('#instruction').text('');

        $('#newKampusPayment').modal('show');
    }

    function GetQRCode() {
        var url = '<?php echo site_url("parent/parents/getKampusPayQRCode") ?>';
        var tname = $('#feetype').val() + '<?php echo ' for ' . $student['firstname'] . ' ' . $student['lastname'] . ' - ' . $student['class'] . ' (' . $student['section'] . ')' ?>';
        var tprice = $('#amount').val();

        if ($('#feetype').val() != '' && $('#amount').val() != '') {
            var prompt = $.dialog({
                title: 'KampusPay',
                content: 'Generating QR code please wait...',
            });

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    tname: tname,
                    tprice: tprice
                },
                dataType: 'json',
                success: function(resp) {
                    prompt.close();

                    if (resp.message == "success") {
                        // $('#qrcodehere').html('<img></img>')
                        $('#qrcodehere').html('');
                        $('#qrcodehere').qrcode({
                            width: 180,
                            height: 180,
                            text: resp.results.qrcode
                        });
                        $('#instruction').text('Please scan this QR with your Banana Pay app to proceed with your payment.');
                    }
                }
            });
        }
    }

    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    }
</script>