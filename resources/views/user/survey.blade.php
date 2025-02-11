@include('layout.app')
<main class="py-4">
    <div class="container full-height">
        <div class="row row-height">
            <div class="col-lg-12 content-right" id="start">
                <div id="wizard_container">
                    <form {{-- action="{{ route('post.survey', ['doctor_id' => $doc_id]) }}" --}} action="{{ route('survey.storeAnswer') }}" method="POST" id="survey-form">
                        @csrf
                        <input type="hidden" name="question" id="question-id" value="{{ $encryptedQuestionId }}">
                        <input type="hidden" name="is_last" value="{{ $isLast }}">
                        <input type="hidden" name="doc_id" value="{{ $decryptedDoctorId }}">
                        <input type="hidden" name="doctor_id" value="{{ $doc_id }}">
                        
                        <div id="middle-wizard">
                            <div class="step">
                                <div class="nine">
                                    <h1>Survey<span>Question</span></h1>
                                </div>
                                <div class="dash-div">
                                    <div class="main-box custom-box">
                                        <div class="step-1-form">
                                            <div id="question-container">
                                                <span id="name_error" class="error-message d-none text-danger">This Answer field is required.</span>
                                                <h2 class="question"><b>{{ $nextQuestion->question }}</b></h2>
                                                <?php if ($nextQuestion->type == 1 && !empty($nextQuestion->answers)) { ?>
                                                <div class="selectBoxGroup">
                                                    <?php foreach (explode(",", $nextQuestion->answers) as $answer) { ?>
                                                    <div class="selectBox radio">
                                                        <input type="radio" name="answer"
                                                            id="radio-<?php echo $answer; ?>" value="<?php echo $answer; ?>"
                                                            <?php if (isset($currentAnswer) && $answer == $currentAnswer->answers) {
                                                                echo 'checked';
                                                            } ?>>
                                                        <label
                                                            for="radio-<?php echo $answer; ?>"><?php echo $answer; ?></label>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                <?php } else if ($nextQuestion->type == 2 && !empty($nextQuestion->answers)) { ?>
                                                {{-- <div class="selectBoxGroup">
                                                    <ul id="ul_li_SubCategories" style="width:100%;"
                                                        class="chargeCapturetable margin0">
                                                        <?php if (isset($currentAnswer)) { ?>
                                                        <?php foreach (explode(",", $currentAnswer->answers) as $key => $answer) { ?>
                                                        <li sequence="1" class="liEllipsis" value="9">
                                                            <div class="selectBox radio">
                                                                <input type="checkbox" name="answer[]" class="upbutton"
                                                                    id="radio-<?php echo $answer; ?>"
                                                                    value="<?php echo $answer; ?>" checked required>
                                                                <label
                                                                    for="radio-<?php echo $answer; ?>"><?php echo $answer; ?></label>
                                                            </div>
                                                        </li>
                                                        <?php } ?>
                                                        <?php } else { ?>
                                                        <?php foreach (explode(",", $nextQuestion->answers) as $answer) { ?>
                                                        <li sequence="1" class="liEllipsis" value="9">
                                                            <div class="selectBox radio">
                                                                <input type="checkbox" name="answer[]" class="upbutton"
                                                                    id="radio-<?php echo $answer; ?>"
                                                                    value="<?php echo $answer; ?>" required>
                                                                <label
                                                                    for="radio-<?php echo $answer; ?>"><?php echo $answer; ?></label>
                                                            </div>
                                                        </li>
                                                        <?php } ?>
                                                        <?php } ?>
                                                    </ul>
                                                </div> --}}
                                                    <div class="selectBoxGroup">
                                                        <ul id="ul_li_SubCategories" style="width:100%;" class="chargeCapturetable margin0">
                                                            @php
                                                                $selectedAnswers = request()->input('answer', isset($currentAnswer) ? explode(',', $currentAnswer->answers) : []);
                                                            @endphp
                                                
                                                            @foreach(explode(",", $nextQuestion->answers) as $answer)
                                                                <li sequence="1" class="liEllipsis" value="9">
                                                                    <div class="selectBox radio">
                                                                        <input type="checkbox" name="answer[]" class="upbutton"
                                                                            id="radio-{{ $answer }}" value="{{ $answer }}"
                                                                            {{ in_array($answer, (array) $selectedAnswers) ? 'checked' : '' }} required>
                                                                        <label for="radio-{{ $answer }}">{{ $answer }}</label>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                <?php } else if ($nextQuestion->type == 3) { ?>
                                                <div class="form-group text-center">
                                                    <textarea id="answer" rows="5" class="form-control" name="answer" required autocomplete="answer" autofocus
                                                        placeholder="Enter your answer here"><?php if (isset($currentAnswer)) {
                                                            echo $currentAnswer->answers;
                                                        } ?></textarea>
                                                </div>
                                                <?php } else if ($nextQuestion->type == 4 && !empty($nextQuestion->answers)) { ?>
                                                <div class="selectBoxGroup">
                                                    <?php foreach (explode(",", $nextQuestion->answers) as $answer) { ?>
                                                    <div class="selectBox radio">
                                                        <input type="checkbox" name="answer[]"
                                                            id="radio-<?php echo $answer; ?>" value="<?php echo $answer; ?>"
                                                            <?php if (isset($currentAnswer) && strpos($currentAnswer->answers, $answer) !== false) {
                                                                echo 'checked';
                                                            } ?>>
                                                        <label
                                                            for="radio-<?php echo $answer; ?>"><?php echo $answer; ?></label>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                <?php } else if ($nextQuestion->type == 5 && !empty($nextQuestion->answers)) {
                                                $isOther = true; ?>
                                                <?php if ($nextQuestion->id == 0) { ?>
                                                <div class="selectBoxGroup">
                                                    <?php foreach (explode(",", $nextQuestion->answers) as $answer) { ?>
                                                    <div class="selectBox radio">
                                                        <input type="radio" name="answer"
                                                            id="radio-<?php echo $answer; ?>" value="<?php echo $answer; ?>"
                                                            <?php if (isset($currentAnswer) && (($answer == 'Yes' && $currentAnswer->answers != 'Yes' && $currentAnswer->answers != 'No') || ($answer == 'No' && $currentAnswer->answers == 'No'))) {
                                                                echo 'checked';
                                                            } ?>>
                                                        <label
                                                            for="radio-<?php echo $answer; ?>"><?php echo $answer; ?></label>
                                                    </div>
                                                    <?php if ($answer == 'Yes') { ?>
                                                    <div id="extrasyes" class="form-group text-center"
                                                        style="width: 100%;<?php if (isset($currentAnswer) && $currentAnswer->answers != 'Yes' && $currentAnswer->answers != 'No') {
                                                            echo 'display: block;';
                                                        } else {
                                                            echo 'display: none;';
                                                        } ?>">
                                                        <label for="extras">If Yes, then why</label>
                                                        <div class="text-center" style="width: 50%;margin: 0 auto;">
                                                            <input type="text" name="other_answer"
                                                                class="form-control" id="extras"
                                                                placeholder="Type here..." value="<?php if (isset($currentAnswer) && $currentAnswer->answers != 'Yes' && $currentAnswer->answers != 'No') {
                                                                    echo $currentAnswer->answers;
                                                                } ?>">
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </div>
                                                <?php }
                                                if ($question->id == 0) {
                                                    if (isset($currentAnswer) && isset($currentAnswer->answers)) {
                                                        $answers = explode(",", $question->answers);
                                                        $givenanswers = explode(",", $currentAnswer->answers);
                                                        $results = array_diff($givenanswers, $answers);
                                                        if (count($results) > 0) {
                                                            foreach ($results as $key => $result) {
                                                                $other_answer = $result;
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <div class="selectBoxGroup">
                                                    <?php foreach (explode(",", $question->answers) as $answer) { ?>
                                                    <div class="selectBox radio">
                                                        <input type="checkbox" name="answer[]"
                                                            id="radio-<?php echo $answer; ?>" value="<?php echo $answer; ?>"
                                                            <?php if (isset($currentAnswer) && strpos($currentAnswer->answers, $answer) !== false) {
                                                                echo 'checked';
                                                            } ?>>
                                                        <label
                                                            for="radio-<?php echo $answer; ?>"><?php echo $answer; ?></label>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="form-group text-center mt-4">
                                                    <label for="extras">Any other – Please mention</label>
                                                    <div class="text-center" style="width: 50%;margin: 0 auto;">
                                                        <input type="text" name="other_answer"
                                                            class="form-control mt-2 custom-input" id="extras"
                                                            placeholder="Type here..." value="<?php if (isset($other_answer)) {
                                                                echo $other_answer;
                                                            } ?>"
                                                            onchange="SetDefault($(this).val());"
                                                            onkeyup="this.onchange();" onpaste="this.onchange();"
                                                            oninput="this.onchange();">
                                                    </div>
                                                </div>
                                                <?php } else { ?>
                                                <div class="selectBoxGroup">
                                                    <?php foreach (explode(",", $question->answers) as $answer) { ?>
                                                    <div class="selectBox radio">
                                                        <input type="radio" name="answer"
                                                            id="radio-<?php echo $answer; ?>"
                                                            value="<?php echo $answer; ?>" <?php if (isset($currentAnswer) && $answer == $currentAnswer->answers) {
                                                                $isOther = false;
                                                                echo 'checked';
                                                            } ?>>
                                                        <label
                                                            for="radio-<?php echo $answer; ?>"><?php echo $answer; ?></label>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="form-group text-center mt-4">
                                                    <label for="extras">Any other – Please mention</label>
                                                    <div class="text-center" style="width: 50%;margin: 0 auto;">
                                                        <input type="text" name="other_answer"
                                                            class="form-control mt-2 custom-input" id="extras"
                                                            placeholder="Type here..." value="<?php if (isset($currentAnswer) && $isOther == true) {
                                                                echo $currentAnswer->answers;
                                                            } ?>"
                                                            onchange="SetDefault($(this).val());"
                                                            onkeyup="this.onchange();" onpaste="this.onchange();"
                                                            oninput="this.onchange();">
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <?php } else if ($question->type == 6 && !empty($question->answers)) {
                                                if (isset($currentAnswer->answers)) {
                                                    $carange = explode(",", $currentAnswer->answers);
                                                } ?>
                                                <?php foreach (explode(",", $question->answers) as $key => $answer) { ?>
                                                <div class="form-group text-center">
                                                    <label
                                                        for="range-<?php echo $answer; ?>"><?php echo $answer; ?></label>
                                                    <div class="text-center slidecontainer"
                                                        style="width: 50%;margin: 0 auto;">
                                                        <input required type="range" value="<?php if (isset($carange[$key])) {
                                                            echo $carange[$key];
                                                        } else {
                                                            echo '0';
                                                        } ?>"
                                                            min="0" max="10" step="1"
                                                            name="answer[]" class="form-control slider"
                                                            id="range-<?php echo $answer; ?>"
                                                            oninput="rangeValue($(this));">
                                                        <output name="range-value"><?php if (isset($carange[$key])) {
                                                            echo $carange[$key];
                                                        } else {
                                                            echo '0';
                                                        } ?></output>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <?php } else if ($question->type == 7 && !empty($question->answers)) {
                                                if (isset($currentAnswer->answers)) {
                                                    $carange = explode(",", $currentAnswer->answers);
                                                } ?>
                                                <?php foreach (explode(",", $question->answers) as $key => $answer) { ?>
                                                <div class="form-group text-center">
                                                    <label
                                                        for="range-<?php echo $answer; ?>"><?php echo $answer; ?></label>
                                                    <div class="text-center" style="width: 50%;margin: 0 auto;">
                                                        <?php if ($answer == 'Months') { ?>
                                                        <input id="months" required type="number"
                                                            value="<?php if (isset($carange[$key])) {
                                                                echo $carange[$key];
                                                            } else {
                                                                echo '0';
                                                            } ?>" min="0"
                                                            step="1" max="12" name="answer[]"
                                                            class="form-control" id="range-<?php echo $answer; ?>"
                                                            oninput="this.value = Math.abs(this.value)">
                                                        <?php } else { ?>
                                                        <input required type="number" value="<?php if (isset($carange[$key])) {
                                                            echo $carange[$key];
                                                        } else {
                                                            echo '0';
                                                        } ?>"
                                                            min="0" step="1" name="answer[]"
                                                            class="form-control" id="range-<?php echo $answer; ?>"
                                                            oninput="this.value = Math.abs(this.value)">
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <?php } ?>
                                            </div>
                                            <div class="left-button-o">
                                                <div class="col-md-12">
                                                    <div class="row mx-auto justify-content-center">
                                                        <div class="col-md-4">
                                                            <a href="#"
                                                                class="btn btn-primary btn-q-2 w-100 mt-2">BACK</a>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <button type="submit" id="next-button" class="btn btn-primary btn-q-1 w-100 mt-2">
                                                                {{ $isLast == 1 ? 'SUBMIT' : 'NEXT' }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    // $(document).ready(function() {
    //     $('#next-button').click(function(e) {
    //         e.preventDefault();
    //         var currentQuestionId = $('#question-id').val();
    //         var formData = $('#survey-form').serialize();
    //         $.ajax({
    //             url: '{{ route('survey.storeAnswer') }}',
    //             method: 'POST',
    //             data: formData,
    //             success: function(response) {
    //                 if (response.success) {
    //                     // $('#question-id').val(response.nextQuestion.id);
    //                     // $('#question-container').html(response.nextQuestionHtml);

    //                     let decodedData = JSON.parse(atob(response.encodedData));

    //                     let nextQuestionId = decodedData.nextQuestionId;
    //                     let nextQuestionHtml = decodedData.nextQuestionHtml;
    //                     let remainingQuestionsCount = decodedData.remainingQuestionsCount;


    //                     $('#question-id').val(nextQuestionId);
    //                     $('#question-container').html(nextQuestionHtml);
    //                     if (response.remainingQuestionsCount === 1) {
    //                         $('#next-button').text('SUBMIT');
    //                     } else {
    //                         $('#next-button').text('NEXT');
    //                     }
    //                 } else {
    //                     window.location.href = response.redirect_url;
    //                 }
    //             }
    //         });
    //     });
    // });


    $('#next-button').click(function(e) {
        e.preventDefault();
        var formData = $('#survey-form').serialize();
        var encodedData = btoa(unescape(encodeURIComponent(formData)));

        $.ajax({
            url: '{{ route('survey.storeAnswer') }}',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                encodedData: encodedData
            },
            success: function(response) {
                console.log(response,"res");
                
                if(response.encodedData){
                    let decodedData = JSON.parse(atob(response.encodedData));
                    $('#question-id').val(decodedData.nextQuestionId);
                    $('#question-container').html(decodedData.nextQuestionHtml);

                    if (decodedData.remainingQuestionsCount == 1) {
                        $('#next-button').text('SUBMIT');
                    } else {
                        $('#next-button').text('NEXT');
                    }
                }else{
                    window.location.href = response.redirect_url;
                }
            },
            error: function(response) {
                if (response.status === 401) {
                    $('#name_error').removeClass('d-none');
                } else if (response.responseJSON && response.responseJSON.errors) {
                    let errors = response.responseJSON.errors;
                   $('#name_error').removeClass('d-none');
                }
            }
        });
    });
</script>



<?php if ($nextQuestion->type == 7 && !empty($nextQuestion->answers)) { ?>
<script type="text/javascript">
    $(document).on('submit', '#wrapped', function() {
        if ($('#months').val() < 0 || $('#months').val() > 12) {
            $('.login').append(
                '<div class="alert alert-danger alert-block" role="alert"><button class="close" data-dismiss="alert">x</button>Months can not be more than 12.</div>'
            );
            return false;
        }
    });
</script>
<?php } ?>
<?php if ($nextQuestion->type == 6 && !empty($nextQuestion->answers)) { ?>
<style type="text/css">
    .slidecontainer {
        width: 100%;
    }

    .slider {
        -webkit-appearance: none;
        width: 100%;
        height: 25px;
        background: #d3d3d3;
        outline: none;
        opacity: 0.7;
        -webkit-transition: .2s;
        transition: opacity .2s;
    }

    .slider:hover {
        opacity: 1;
    }

    .slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 25px;
        height: 25px;
        background: #4CAF50;
        cursor: pointer;
    }

    .slider::-moz-range-thumb {
        width: 25px;
        height: 25px;
        background: #4CAF50;
        cursor: pointer;
    }
</style>
<script type="text/javascript">
    function rangeValue(ele) {
        var range = $(ele).val();
        $(ele).parent().find('output').val(range);
    }

    $(document).on('submit', '#wrapped', function() {
        var breakOut = false;
        $('input[type=range]').each(function() {
            if ($(this).val() == 0) {
                $('.login').append(
                    '<div class="alert alert-danger alert-block" role="alert"><button class="close" data-dismiss="alert">x</button>You have to rate between 1 to 10.</div>'
                );
                breakOut = true;
                return false;
            }
        });
        if (breakOut) {
            breakOut = false;
            return false;
        }
    });
</script>
<?php } ?>
<?php if ($nextQuestion->type == 5 && !empty($nextQuestion->answers)) { ?>
<script type="text/javascript">
    $(document).ready(function() {
        $("input[type='radio").click(function() {
            <?php if ($nextQuestion->id == 0) { ?>
            var val = $("input[name='answer:checked").val();
            if (val == 'Yes') {
                $("#extrasyes").show();
            }
            if (val == 'No') {
                $("#extras").val('');
                $("#extrasyes").hide();
            }
            <?php } ?>
            if ($("input[name='answer:checked").val()) {
                // $("#extras").val('');
            }
        });
    });

    function SetDefault(Text) {
        $("input:radio[name='answer").each(function(i) {
            this.checked = false;
        });
    }
    <?php if ($nextQuestion->id == 0) { ?>
    $(document).on('submit', '#wrapped', function() {
        if ($('input[type="checkbox"]:checked').length == 0 && $('input[name="other_answer"]').val() == '') {
            $('.login').html('');
            $('.login').append(
                '<div class="alert alert-danger alert-block" role="alert"><button class="close" data-dismiss="alert">x</button>You have to select atleast one option or type your opinion.</div>'
            );
            return false;
        }
    });
    <?php } else { ?>
    $(document).on('submit', '#wrapped', function() {
        if (!$("input[name='answer").is(':checked') && $('input[name="other_answer"]').val() == '') {
            $('.login').html('');
            $('.login').append(
                '<div class="alert alert-danger alert-block" role="alert"><button class="close" data-dismiss="alert">x</button>You have to select atleast one option or type your opinion.</div>'
            );
            return false;
        }
        if ($("input[name='answer").is(':checked') && $("input[name='answer:checked").val() == 'Yes' && $(
                'input[name="other_answer"]').val() == '') {
            $('.login').html('');
            $('.login').append(
                '<div class="alert alert-danger alert-block" role="alert"><button class="close" data-dismiss="alert">x</button>You have to enter reason for your opinion.</div>'
            );
            return false;
        }
    });
    <?php } ?>
</script>
<?php } ?>
<?php if ($nextQuestion->type == 4 && !empty($nextQuestion->answers)) { ?>
<script type="text/javascript">
    $(document).on('submit', '#wrapped', function() {
        if ($('input[type="checkbox"]:checked').length < 1) {
            $('.login').html('');
            $('.login').append(
                '<div class="alert alert-danger alert-block" role="alert"><button class="close" data-dismiss="alert">x</button>You have to select atleast two option as per your opinion.</div>'
            );
            return false;
        }
    });
</script>
<?php } ?>

<?php if ($nextQuestion->type == 3) { ?>
<script type="text/javascript">
    $(document).on('submit', '#wrapped', function() {

        $('.login').html('');
        if ($('#answer').val() == '') {
            $('.login').append(
                '<div class="alert alert-danger alert-block" role="alert"><button class="close" data-dismiss="alert">x</button>You have to answer the question.</div>'
            );
            return false;
        }
    });
</script>
<?php } ?>
<?php if ($nextQuestion->type == 2 && !empty($nextQuestion->answers)) { ?>
<script type="text/javascript">
    $(document).on('submit', '#wrapped', function() {


        if ($('input[type="checkbox"]:checked').length != $('input[type="checkbox"]').length) {
            $('.login').html('');
            $('.login').append(
                '<div class="alert alert-danger alert-block" role="alert"><button class="close" data-dismiss="alert">x</button>You need to rank all these option.</div>'
            );
            return false;
        }
    });
</script>
<?php } ?>



<?php if ($nextQuestion->type == 1 && !empty($nextQuestion->answers)) { ?>
<script type="text/javascript">
    $(document).on('submit', '#wrapped', function() {
        if ($('input[type="radio"]:checked').length < 1) {
            $('.login').html('');
            $('.login').append(
                '<div class="alert alert-danger alert-block" role="alert"><button class="close" data-dismiss="alert">x</button>You have to select reason for your opinion.</div>'
            );
            return false;
        }
    });
</script>
<?php } ?>
