<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Payment History</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Payment History</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Payment Channel</th>
                    <th>Reference</th>
                    <th>Amount</th>
                    <th>Name of Payer</th>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Payment Type</th>
                    <th>Date</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach($payment_history as $payments): ?>
                      <tr>
                        <td><?php echo ucfirst($payments->payment_channel) ?></td>
                        <td>#<?php echo $payments->reference_number ?></td>
                        <td>₱<?php echo $payments->amount ?></td>
                        <td><?php echo $payments->name ?></td>
                        <td>Student A. Name</td>
                        <td><?php echo $payments->email ?></td>
                        <td>Paid</td>
                        <td><?php echo ucfirst($payments->payment) ?></td>
                        <td><?php echo $payments->date_created ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Payment Channel</th>
                    <th>Reference</th>
                    <th>Amount</th>
                    <th>Name of Payer</th>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Payment Type</th>
                    <th>Date</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->