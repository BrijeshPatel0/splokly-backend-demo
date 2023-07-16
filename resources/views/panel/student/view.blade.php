@extends('panel.layouts.admin_layout')
@section('content')  
<div class="content-body"><!-- Sales stats -->
    <section id="configuration">
        <div class="row hidden">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <!--<h4 class="card-title">Customers List - (<b id="customerTotalRecords">0</b>)</h4>-->
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard">
                            <form class="form" id="filter_processing_for_cancel_membership_reason">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="projectinput3">Select Country</label><br>
                                            <select class="form-control select2 " id="select_filter_processing_for_cancel_membership_reason" style="height: calc(2.25rem + 10px);width:100%;" >
                                                <option <?php if($countryCode == ''): echo 'selected'; endif; ?> value="<?= env('APP_URL').'/students' ?>">ALL</option>
                                                <option <?php if($countryCode == '+972'): echo 'selected'; endif; ?> value="<?= env('APP_URL').'/students/+972' ?>">Israel</option>
                                                <option <?php if($countryCode == '+48'): echo 'selected'; endif; ?> value="<?= env('APP_URL').'/students/+48' ?>">Poland</option>
                                                <option <?php if($countryCode == '+34'): echo 'selected'; endif; ?> value="<?= env('APP_URL').'/students/+34' ?>">Spain</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="projectinput3">&nbsp;</label><br>
                                            <button type="submit" id="filter-processing-for-cancel-membership-reason" class="btn btn-primary">
                                                Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <!--<h4 class="card-title">Customers List - (<b id="customerTotalRecords">0</b>)</h4>-->
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    </div>
                    <input type="hidden" value="<?= $countryCode ?>" id="filter-by-country-code-customer-datatable">
                    <div class="card-content collapse show">
                        <button type="button" id="export-to-student-data-report-to-excel" class="btn btn-primary" style="margin-left:15px;">
                            Export to Excel
                        </button>
                        <div class="card-body card-dashboard">
                            <table id="customer-lists-datatable" class="table table-striped table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>#SR.No</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
{{--                                        TODO: Addmin type check--}}
{{--                                        <?php if (getCurrentAdminUserData()->admin_type == 'ADMIN'): ?>--}}
{{--                                            <th>Email</th>--}}
{{--                                            <th>Phone</th>--}}
{{--                                        <?php endif; ?>--}}
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Max</td>
                                    <td>Nehamkin</td>
                                    <td>nehamkin007@gmail.com</td>
                                    <td>+9720547206386</td>
                                    <th><span class="badge badge badge-success">Active</span></th>
                                    <th>2023-01-26 09:37:58</th>
                                    <th><a href="https://phpstack-807538-3473988.cloudwaysapps.com/admin/customers/edit/NDU4NDg=" class="dropdown-item text-primary"><i class="ft-eye"></i>&nbsp;&nbsp; View Details</a>
                                        <a href="JavaScript:Void(0)" onclick="deleteCustomer(&quot;45848&quot;)" class="dropdown-item text-primary"><i class="ft-trash-2"></i> Delete</a></th>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Ester</td>
                                    <td>Shlang</td>
                                    <td>stshlang@gmail.com</td>
                                    <td>+9720525009018</td>
                                    <th><span class="badge badge badge-success">Active</span></th>
                                    <th>2023-04-26 07:29:19</th>
                                    <th><a href="https://phpstack-807538-3473988.cloudwaysapps.com/admin/customers/edit/NDU4NDg=" class="dropdown-item text-primary"><i class="ft-eye"></i>&nbsp;&nbsp; View Details</a>
                                        <a href="JavaScript:Void(0)" onclick="deleteCustomer(&quot;45848&quot;)" class="dropdown-item text-primary"><i class="ft-trash-2"></i> Delete</a></th>
                                </tr>
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
