<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Payment</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Payment</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          
          <div class="col-lg-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Please fill out the form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="<?php echo base_url('payment/payment/process')?>" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Payer Name</label>
                    <input type="text" name="name" required class="form-control" id="name" placeholder="First Name and Last Name" value="<?php echo $user_info['name']?>">
                  </div>
                  <div class="form-group">
                    <label for="student_id">Student Name</label>
                    <select class="form-control" name="student_id" required="">
                      <option value="">--Select Student--</option>
                      <?php foreach($children as $child): ?>
                        <option value="<?php echo $child->id?>"><?php echo $child->firstname;?> <?php echo $child->lastname; ?></option>
                      <?php endforeach;?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Payment</label>
                    <select class="form-control" name="payment" required="">
                      <option value="">--Select Payment--</option>
                      <option value="tuition">Tuition</option>
                      <option value="others">Others</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="payment_description">Payment Description</label>
                    <textarea name="payment_description" id="payment_description" class="form-control" rows="3" placeholder=""></textarea>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" required class="form-control" id="email" placeholder="Email Address">
                  </div>
                  <div class="form-group">
                    <label for="card_number">Card Number</label>
                    <input type="text" name="card_number" class="form-control" id="card_number" placeholder="Card Number">
                  </div>
                  <div class="form-group">
                    <label>Expiration Month</label>
                    <select class="form-control" name="exp_month" required="">
                      <option value=''>--Select Month--</option>
                      <option value='1'>January</option>
                      <option value='2'>February</option>
                      <option value='3'>March</option>
                      <option value='4'>April</option>
                      <option value='5'>May</option>
                      <option value='6'>June</option>
                      <option value='7'>July</option>
                      <option value='8'>August</option>
                      <option value='9'>September</option>
                      <option value='10'>October</option>
                      <option value='11'>November</option>
                      <option value='12'>December</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Expiration Year</label>
                    <select class="form-control" name="exp_year" required="">
                      <option value="">--Select Year--</option>
                      <option value="2020">2020</option>
                      <option value="2021">2021</option>
                      <option value="2022">2022</option>
                      <option value="2023">2023</option>
                      <option value="2024">2024</option>
                      <option value="2025">2025</option>
                      <option value="2026">2026</option>
                      <option value="2027">2027</option>
                      <option value="2028">2028</option>
                      <option value="2029">2029</option>
                      <option value="2030">2030</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="cvc">CVC</label>
                    <input type="text" name="cvc" pattern="\d*" maxlength="3" minlength="3" class="form-control" id="cvc" placeholder="CVC" required="">
                  </div>
                  <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="text" name="amount" pattern="\d*" class="form-control" id="amount" placeholder="Amount" required="">
                  </div>
                  <div class="form-group">
                    <label>Purpose</label>
                    <textarea name="purpose" id="purpose" class="form-control" rows="3" placeholder=""></textarea>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

            
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
