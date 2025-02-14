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
                        <input type="hidden" name="previous_question" id="previous_question">
                        <div id="middle-wizard">
                            <div class="step">
                                <div class="nine">
                                    <h1>Survey<span>Question</span></h1>
                                </div>
                                <div class="dash-div">
                                    <div class="main-box custom-box">
                                        <div class="step-1-form">
                                            <div id="question-container">
                                                <span id="name_error" class="error-message d-none text-danger">This
                                                    Answer field is required.</span>
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
                                                    <ul id="ul_li_SubCategories" style="width:100%;"
                                                        class="chargeCapturetable margin0">
                                                        @php
                                                            $selectedAnswers = request()->input(
                                                                'answer',
                                                                isset($currentAnswer)
                                                                    ? explode(',', $currentAnswer->answers)
                                                                    : [],
                                                            );
                                                        @endphp

                                                        @foreach (explode(',', $nextQuestion->answers) as $answer)
                                                            <li sequence="1" class="liEllipsis" value="9">
                                                                <div class="selectBox radio">
                                                                    <input type="checkbox" name="answer[]"
                                                                        class="upbutton" id="radio-{{ $answer }}"
                                                                        value="{{ $answer }}"
                                                                        {{ in_array($answer, (array) $selectedAnswers) ? 'checked' : '' }}
                                                                        required>
                                                                    <label
                                                                        for="radio-{{ $answer }}">{{ $answer }}</label>
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
                                                            <button type="button" id="prev-button"
                                                                class="btn btn-primary btn-q-1 w-100 mt-2">Back
                                                            </button>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <button type="submit" id="next-button"
                                                                class="btn btn-primary btn-q-1 w-100 mt-2">
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
    // $('#next-button').click(function(e) {
    //     e.preventDefault();
    //     var formData = $('#survey-form').serialize();
    //     var encodedData = btoa(unescape(encodeURIComponent(formData)));

    //     $.ajax({
    //         url: '{{ route('survey.storeAnswer') }}',
    //         method: 'POST',
    //         data: {
    //             _token: $('meta[name="csrf-token"]').attr('content'),
    //             encodedData: encodedData
    //         },
    //         success: function(response) {
    //             console.log(response, "res");

    //             if (response.encodedData) {
    //                 let decodedData = JSON.parse(atob(response.encodedData));
    //                 $('#question-id').val(decodedData.nextQuestionId);
    //                 $('#question-container').html(decodedData.nextQuestionHtml);

    //                 if (decodedData.remainingQuestionsCount == 1) {
    //                     $('#next-button').text('SUBMIT');
    //                 } else {
    //                     $('#next-button').text('NEXT');
    //                 }
    //             } else {
    //                 window.location.href = response.redirect_url;
    //             }
    //         },
    //         error: function(response) {
    //             if (response.status === 401) {
    //                 $('#name_error').removeClass('d-none');
    //             } else if (response.responseJSON && response.responseJSON.errors) {
    //                 let errors = response.responseJSON.errors;
    //                 $('#name_error').removeClass('d-none');
    //             }
    //         }
    //     });
    // });

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

    var questionHistory = [];

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
                if (response.encodedData) {
                    let decodedData = JSON.parse(atob(response.encodedData));

                    let currentQuestionId = $('#question-id').val();
                    questionHistory.push(currentQuestionId);

                    $('#question-id').val(decodedData.nextQuestionId);
                    $('#question-container').html(decodedData.nextQuestionHtml);

                    if (decodedData.remainingQuestionsCount == 1) {
                        $('#next-button').text('SUBMIT');
                    } else {
                        $('#next-button').text('NEXT');
                    }
                } else {
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

    $('#prev-button').click(function(e) {
        e.preventDefault();

        if (questionHistory.length > 0) {
            let previousQuestionId = questionHistory.pop();
            // console.log(previousQuestionId,"pre");

            $('#previous_question').val(previousQuestionId);

            var formData = $('#survey-form').serialize();
            var encodedData = btoa(unescape(encodeURIComponent(formData)));
            $.ajax({
                url: '{{ route('survey.getPreviousQuestion') }}',
                method: 'GET',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    // question_id: previousQuestionId,
                    encodedData: encodedData
                },
                success: function(response) {
                    $('#question-id').val(response.previousQuestionId);
                    $('#question-container').html(response.previousQuestionHtml);
                    $('#next-button').text('NEXT');
                }
            });
        } else {
            Toast.fire({
                icon: 'false',
                title: 'No previous question available'
            })
        }
    });
</script>