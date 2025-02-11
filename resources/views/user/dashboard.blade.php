@extends('layout.app')
@section('content')
    <div id="app">
        <main class="py-4">
            <div class="container full-height">
                <div class="row row-height">
                    <div class="col-lg-12 content-right" id="start">
                        <div id="wizard_container">
                            <div id="middle-wizard">
                                <div class="step">
                                    <div class="table_main">
                                        <div class="login">
                                            <div class="filter">
                                                <div class="row mx-auto">
                                                    <div class="nine">
                                                        <h1>Survey<span>Dashboard</span></h1>
                                                    </div>
                                                    <div class="col-md-12 text-center" style="margin-bottom: 25px;">
                                                        <div class="btn-switch-container">
                                                            <a class="btn-switch {{ request('dashboard', 0) == 0 ? 'active' : '' }}"
                                                                href="{{ route('dashboard') }}">
                                                                Survey
                                                            </a>
                                                            <a class="btn-switch {{ request('dashboard', 0) == 1 ? 'active' : '' }}"
                                                                href="{{ route('dashboard', ['dashboard' => 1]) }}">
                                                                Non-Survey
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" id="myInput" onkeyup="search()"
                                                            class="form-control" placeholder="Search for names..">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-control" name="survey"
                                                            onchange="reloadSurvey(this);">
                                                            <option value="">Select Topic</option>
                                                            @foreach ($surveyList as $survey)
                                                                <option value="{{ $survey->survey_id }}">{{ $survey->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" table-form form-off dash-div">
                                                <table class="table text-center table-bordered" id="edoc_datatable">
                                                    <thead class="main_text">
                                                        <tr>
                                                            <th class="name">Doctor Name</th>
                                                            <th class="title">Topic</th>
                                                            <th class="survey">Survey</th>
                                                            <th class="send">Invite by Link</th>
                                                            <th class="pdf">Agreement</th>
                                                            <th class="Status">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (count($doctors) > 0) { ?>
                                                            <?php foreach ($doctors as $key =>   $doctor) {
                                                            // @dd($doctor);
                                                        $class = ($key % 2 == 0) ? 'titleodd' : 'titleeven'; ?>
                                                        <tr class="survey_id<?php echo $doctor->survey_title; ?>">
                                                            <td class="name-of-dr">
                                                                <?php echo $doctor->name; ?>
                                                            </td>
                                                            <td class="name-of-dr">
                                                                <div class="<?= $class ?>"><?php echo $doctor->survey_title; ?></div>
                                                            </td>
                                                            <td class="agree agree-three">
                                                                <?php if ($doctor->is_accept == 0 && $doctor->otp_verified == 0) { ?>
                                                                    <?php if ($doctor->is_survey_completed) { ?>
                                                                    <a href="{{ url('/') }}/User/previoussurvey?doctor_id={{ base64_encode($doctor->id) }}&question_id=0&is_next=1"
                                                                        title="Click to get survey">
                                                                        <img src="{{ asset('assets/img/accept.svg') }}"
                                                                            class="icon_logo">
                                                                    </a>
                                                                    <?php } else if ($doctor->is_agreement_verified) { ?>
                                                                    {{-- <a href="{{ route('get.survey',['doctor_id'=> $doctor->encrypted_id])}}" --}}
                                                                    <a href="{{ url('/') }}/user/survey/{{ $doctor->encrypted_id  }}?is_check=1"
                                                                        title="Click to get survey">
                                                                        <img src="{{ asset('assets/img/progress.svg') }}"
                                                                            class="icon_logo">
                                                                    </a>
                                                                    {{-- <a href="{{ route('confirmation',['doctor_id'=>$doctor->encrypted_id])}}"
                                                                        title="Click to get survey">
                                                                        <img src="{{ asset('assets/img/progress.svg') }}"
                                                                            class="icon_logo">
                                                                    </a> --}}
                                                                    <?php } else { ?>
                                                                        <a href="{{ route('agreement', ['doctor_id' => $doctor->encrypted_id]) . '?is_check=1' }}"
                                                                            title="Sign an agreement">
                                                                            <img src="{{ asset('assets/img/pending.svg') }}" class="icon_logo">
                                                                        </a>
                                                                <?php } ?>
                                                                <?php } else { ?>
                                                                <?php if ($doctor->is_agreement_verified) { ?>
                                                                    <img src="{{ asset('assets/img/accept.svg') }}" class="icon_logo"  title="Survey has been completed and locked for editing.">
                                                                <?php } else { ?>
                                                                    <img src="{{ asset('assets/img/pending.svg') }}" class="icon_logo"  title="Survey has been completed and locked for editing.">
                                                                <?php } ?>
                                                                <?php } ?>
                                                            </td>
                                                            <td class="agree agree-three">
                                                                @if ($doctor->is_accept == 0 && $doctor->is_document_received == 0)
                                                                    @php
                                                                        $url = url('User/remote?doctor_id=' .
                                                                                $doctor->encrypted_id .
                                                                                '&send_code=' .
                                                                                base64_encode($uniqueNumber),
                                                                        );
                                                                    @endphp
                                                                    <textarea class="textarehid" id="doct{{ $doctor->id }}">
                                                                        Dear {{ $doctor->name }} Alembic invites you to sign the agreement for educational services provided by you. 
                                                                        Click the link below to view and sign. {{ $url }} 
                                                                        Thank you, Regards {{ $doctor->name }}
                                                                    </textarea>
                                                                    <img src="{{ asset('assets/img/link_1.svg') }}"
                                                                        class="icon_logo" onclick="myFunction(this.id)"
                                                                        id="{{ $doctor->id }}">
                                                                @else
                                                                    <img src="{{ asset('assets/img/link_1.svg') }}"
                                                                        class="icon_logo opacity-50">
                                                                @endif
                                                            </td>
                                                            <td class="agree agree-three">
                                                                <a target="_blank"
                                                                    href="{{ url('admin/doctor/pdf/' . $doctor->encrypted_id) }}"
                                                                    title="click to get pdf">
                                                                    <img src="{{ asset('assets/img/pdf.svg') }}"
                                                                        class="icon_logo">
                                                                </a>
                                                            </td>
                                                            <td>

                                                                <?php if ($doctor->is_accept == 0 && $doctor->is_reject == 0 && ($doctor->is_hold == 0 || $doctor->is_hold == 1)) { ?>

                                                                <?php // if (($doctor->employee_pos == 2 || $doctor->employee_pos == 3) && $doctor->is_document_received == 1) {
                                                                ?>
                                                                <?php if (($doctor->employee_pos == 2 || $doctor->employee_pos == 3) && $doctor->is_survey_completed == 1) { ?>
                                                                <?php if ($doctor->is_accept == 0) { ?>
                                                                <a class="accept" href="#"
                                                                    data-value="<?php echo $doctor->id; ?>"
                                                                    title="click to approve">
                                                                    <img src="{{ asset('assets/img/pending.svg') }}"
                                                                        class="icon_logo" style="width:30px!important">
                                                                    <div class="icon-text remarks-open">Pending Approval
                                                                    </div>

                                                                </a>
                                                                <?php } ?>

                                                                <?php // } else if (($doctor->employee_pos == 2 || $doctor->employee_pos == 3) && $doctor->is_document_received == 0) {
                                                                ?>
                                                                <?php } else { ?>
                                                                <img src="{{ asset('assets/img/pending.svg') }}"
                                                                    class="icon_logo">
                                                                <div class="icon-text">Pending</div>
                                                                <?php } ?>
                                                                <?php } else if ($doctor->is_hold == 1) { ?>
                                                                <?php if ($doctor->status == 1) { ?>
                                                                <img data-remarks="<?= $doctor->remarks ?>"
                                                                    class="remarks-open icon_logo"
                                                                    src="{{ asset('assets/img/hold.svg') }}">
                                                                <div data-remarks="<?= $doctor->remarks ?>"
                                                                    class="icon-text remarks-open">AM</div>
                                                                <?php } else if ($doctor->status == 2) { ?>
                                                                <img data-remarks="<?= $doctor->remarks ?>"
                                                                    class="remarks-open icon_logo"
                                                                    src="{{ asset('assets/img/hold.svg') }}">
                                                                <div data-remarks="<?= $doctor->remarks ?>"
                                                                    class="icon-text remarks-open">RM</div>
                                                                <?php } else if ($doctor->status == 3) { ?>
                                                                <img data-remarks="<?= $doctor->remarks ?>"
                                                                    class="remarks-open icon_logo"
                                                                    src="{{ asset('assets/img/hold.svg') }}">
                                                                <div data-remarks="<?= $doctor->remarks ?>"
                                                                    class="icon-text remarks-open">DM</div>
                                                                <?php } else if ($doctor->status == 4) { ?>
                                                                <img data-remarks="<?= $doctor->remarks ?>"
                                                                    class="remarks-open icon_logo"
                                                                    src="{{ asset('assets/img/hold.svg') }}">
                                                                <div data-remarks="<?= $doctor->remarks ?>"
                                                                    class="icon-text remarks-open">SM</div>
                                                                <?php } else if ($doctor->status == 5) { ?>
                                                                <img data-remarks="<?= $doctor->remarks ?>"
                                                                    class="remarks-open icon_logo"
                                                                    src="{{ asset('assets/img/hold.svg') }}">
                                                                <div data-remarks="<?= $doctor->remarks ?>"
                                                                    class="icon-text remarks-open">Marketing</div>
                                                                <?php } else if ($doctor->status == 6) { ?>
                                                                <img data-remarks="<?= $doctor->remarks ?>"
                                                                    class="remarks-open icon_logo"
                                                                    src="{{ asset('assets/img/hold.svg') }}">
                                                                <div data-remarks="<?= $doctor->remarks ?>"
                                                                    class="icon-text remarks-open">Medical</div>
                                                                <?php } else if ($doctor->status == 7) { ?>
                                                                <img data-remarks="<?= $doctor->remarks ?>"
                                                                    class="remarks-open icon_logo"
                                                                    src="{{ asset('assets/img/hold.svg') }}">
                                                                <div data-remarks="<?= $doctor->remarks ?>"
                                                                    class="icon-text remarks-open">Account</div>
                                                                <?php } else if ($doctor->status == 8) { ?>
                                                                <img data-remarks="<?= $doctor->remarks ?>"
                                                                    class="remarks-open icon_logo"
                                                                    src="{{ asset('assets/img/hold.svg') }}">
                                                                <div data-remarks="<?= $doctor->remarks ?>"
                                                                    class="icon-text remarks-open">Super Admin</div>
                                                                <?php } ?>
                                                                <?php } else if ($doctor->is_reject == 1) { ?>
                                                                <?php if ($doctor->status == 1) { ?>
                                                                <img data-remarks="<?= $doctor->remarks ?>"
                                                                    class="remarks-open icon_logo"
                                                                    src="{{ asset('assets/img/cancel.svg') }}">
                                                                <div data-remarks="<?= $doctor->remarks ?>"
                                                                    class="icon-text remarks-open">AM</div>
                                                                <?php } else if ($doctor->status == 2) { ?>
                                                                <img data-remarks="<?= $doctor->remarks ?>"
                                                                    class="remarks-open icon_logo"
                                                                    src="{{ asset('assets/img/cancel.svg') }}">
                                                                <div data-remarks="<?= $doctor->remarks ?>"
                                                                    class="icon-text remarks-open">RM</div>
                                                                <?php } else if ($doctor->status == 3) { ?>
                                                                <img data-remarks="<?= $doctor->remarks ?>"
                                                                    class="remarks-open icon_logo"
                                                                    src="{{ asset('assets/img/cancel.svg') }}">
                                                                <div data-remarks="<?= $doctor->remarks ?>"
                                                                    class="icon-text remarks-open">DM</div>
                                                                <?php } else if ($doctor->status == 4) { ?>
                                                                <img data-remarks="<?= $doctor->remarks ?>"
                                                                    class="remarks-open icon_logo"
                                                                    src="{{ asset('assets/img/cancel.svg') }}">
                                                                <div data-remarks="<?= $doctor->remarks ?>"
                                                                    class="icon-text remarks-open">SM</div>
                                                                <?php } else if ($doctor->status == 5) { ?>
                                                                <img data-remarks="<?= $doctor->remarks ?>"
                                                                    class="remarks-open icon_logo"
                                                                    src="{{ asset('assets/img/cancel.svg') }}">
                                                                <div data-remarks="<?= $doctor->remarks ?>"
                                                                    class="icon-text remarks-open">Marketing</div>
                                                                <?php } else if ($doctor->status == 6) { ?>
                                                                <img data-remarks="<?= $doctor->remarks ?>"
                                                                    class="remarks-open icon_logo"
                                                                    src="{{ asset('assets/img/cancel.svg') }}">
                                                                <div data-remarks="<?= $doctor->remarks ?>"
                                                                    class="icon-text remarks-open">Medical</div>
                                                                <?php } else if ($doctor->status == 7) { ?>
                                                                <img data-remarks="<?= $doctor->remarks ?>"
                                                                    class="remarks-open icon_logo"
                                                                    src="{{ asset('assets/img/cancel.svg') }}">
                                                                <div data-remarks="<?= $doctor->remarks ?>"
                                                                    class="icon-text remarks-open">Account</div>
                                                                <?php } else if ($doctor->status == 8) { ?>
                                                                <img data-remarks="<?= $doctor->remarks ?>"
                                                                    class="remarks-open icon_logo"
                                                                    src="{{ asset('assets/img/cancel.svg') }}">
                                                                <div data-remarks="<?= $doctor->remarks ?>"
                                                                    class="icon-text remarks-open">Super Admin</div>
                                                                <?php } ?>
                                                                <?php } else if ($doctor->is_accept == 1) { ?>
                                                                <?php if ($doctor->status == 1) { ?>
                                                                <img src="{{ asset('assets/img/accept.svg') }}"
                                                                    class="icon_logo">
                                                                <div class="icon-text">AM</div>
                                                                <?php } else if ($doctor->status == 2) { ?>
                                                                <img src="{{ asset('assets/img/accept.svg') }}"
                                                                    class="icon_logo">
                                                                <div class="icon-text">RM</div>
                                                                <?php } else if ($doctor->status == 3) { ?>


                                                                <img src="{{ asset('assets/img/accept.svg') }}"
                                                                    class="icon_logo">
                                                                <div class="icon-text">DM</div>
                                                                <?php } else if ($doctor->status == 4) { ?>
                                                                <img src="{{ asset('assets/img/accept.svg') }}"
                                                                    class="icon_logo">
                                                                <div class="icon-text">SM</div>
                                                                <?php } else if ($doctor->status == 5) { ?>
                                                                <img src="{{ asset('assets/img/accept.svg') }}"
                                                                    class="icon_logo">
                                                                <div class="icon-text">Marketing</div>
                                                                <?php } else if ($doctor->status == 6) { ?>
                                                                <img src="{{ asset('assets/img/accept.svg') }}"
                                                                    class="icon_logo">
                                                                <div class="icon-text">Medical</div>
                                                                <?php } else if ($doctor->status == 7) { ?>
                                                                <img src="{{ asset('assets/img/accept.svg') }}"
                                                                    data-cheque_number="<?= $doctor->RTGS_no ?>"
                                                                    data-courier_date="<?= $doctor->RTGS_date ?>"
                                                                    data-courier_number="<?= $doctor->courier_number ?>"
                                                                    data-party_name="<?= $doctor->party_name ?>"
                                                                    class="icon_logo courier-open">
                                                                <div class="icon-text">
                                                                    <?php if ($doctor->is_payment_received == 1) { ?>
                                                                    Payment Received
                                                                    <?php } else if ($doctor->is_payment_released == 1) { ?>
                                                                    Payment Released
                                                                    <?php } else { ?>
                                                                    Account
                                                                    <?php } ?>
                                                                </div>
                                                                <?php } else if ($doctor->status == 8) { ?>
                                                                <img src="{{ asset('assets/img/accept.svg') }}"
                                                                    class="icon_logo">
                                                                <div class="icon-text">Super Admin</div>
                                                                <?php } ?>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                        <?php } else { ?>
                                                        <tr>
                                                            <td colspan="7">No doctors available</td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        function myFunction(id) {
            var copyText = document.getElementById("doct" + id);
            copyText.select();
            copyText.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(copyText.value);

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 10000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: 'Copied Message Successfully'
            })
        }

        function search() {
            var input, filter, table, tr, tdone, tdtwo, i, txtValueOne, txtValueTwo;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("edoc_datatable");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                tdone = tr[i].getElementsByTagName("td")[0];
                tdtwo = tr[i].getElementsByTagName("td")[1];
                if (tdone && tdtwo) {
                    txtValueOne = tdone.textContent || tdone.innerText;
                    txtValueTwo = tdtwo.textContent || tdtwo.innerText;
                    if (txtValueOne.toUpperCase().indexOf(filter) > -1 || txtValueTwo.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        function reloadSurvey(ele) {
            var filter, table, tr, tdone, tdtwo, i, txtValueOne, txtValueTwo;
            filter = ele.value.toUpperCase();
            table = document.getElementById("edoc_datatable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                tdone = tr[i].getElementsByTagName("td")[0];
                tdtwo = tr[i].getElementsByTagName("td")[1];
                if (tdone && tdtwo) {
                    txtValueOne = tdone.textContent || tdone.innerText;
                    txtValueTwo = tdtwo.textContent || tdtwo.innerText;
                    if (txtValueOne.toUpperCase().indexOf(filter) > -1 || txtValueTwo.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
@endsection
