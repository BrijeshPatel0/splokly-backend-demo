@extends('panel.layouts.admin_layout')
@section('content')  
<div class="content-body"><!-- Sales stats -->
    <section id="configuration">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <!--<h4 class="card-title">Customers List - (<b id="customerTotalRecords">0</b>)</h4>-->
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard">
                            <table id="customer-lists-datatable-for-teacher" class="table table-striped table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>#SR.No</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Verification Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($customersData as $customersDat): ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $customersDat->first_name ?></td>
                                            <td><?= $customersDat->last_name ?></td>
                                            <td><?= $customersDat->email ?></td>
                                            <td><?= $customersDat->mobile ?></td>
                                            <td><?= $customersDat->is_active ?></td>
                                            <td><?= $customersDat->is_verified ?></td>
                                            <td><?= $customersDat->created_at ?></td>
                                            <td>
                                                <a href="<?= url('admin/coach/coachDetails/' . base64_encode($customersDat->id)); ?>" class="dropdown-item text-primary"><i class="ft-eye"></i>&nbsp;&nbsp; View Details</a>
                                                <a href="<?= url('admin/coach/availabilities/' . base64_encode($customersDat->id)); ?>" class="dropdown-item text-primary"><i class="ft-calendar"></i>&nbsp;&nbsp; Set availability</a>
                                                <a href="<?= url('admin/coach/edit/' . base64_encode($customersDat->id)); ?>" class="dropdown-item text-primary"><i class="ft-edit"></i>&nbsp;&nbsp; Edit</a>
                                                <a href="JavaScript:Void(0);" onclick="deleteTeacher('<?=  $customersDat->id; ?>')" class="dropdown-item text-primary"><i class="ft-trash"></i>&nbsp;&nbsp; Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@stop
