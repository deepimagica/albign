{{-- <div class="dash-div" >
    <div class="main-box custom-box"> --}}
        <span id="name_error" class="error-message d-none text-danger">This Answer field is required.</span>
        <div class="step-1-form">
            <h2 class="question"><b>{{ $nextQuestion->question }}</b></h2>
            <?php if ($nextQuestion->type == 1 && !empty($nextQuestion->answers)) { ?>
            <div class="selectBoxGroup">
                {{-- @dd($nextQuestion->answers); --}}
                <?php foreach (explode(",", $nextQuestion->answers) as $answer) { ?>
                {{-- <div class="selectBox radio">
                    <input type="radio" name="answer" id="radio-<?php echo $answer; ?>"
                        value="<?php echo $answer; ?>" <?php if (isset($currentAnswer) && $answer == $currentAnswer->answers) {
                            echo 'checked';
                        } ?>>
                    <label for="radio-<?php echo $answer; ?>"><?php echo $answer; ?></label>
                </div> --}}

                <div class="selectBox radio">
                    <input type="radio" name="answer" id="radio-{{ $answer }}" value="{{ $answer }}"
                        {{ isset($currentAnswer) && $answer == $currentAnswer->answers ? 'checked' : '' }}>
                    <label for="radio-{{ $answer }}">{{ $answer }}</label>
                </div>
                
                <?php } ?>
            </div>
            <?php } else if ($nextQuestion->type == 2 && !empty($nextQuestion->answers)) { ?>
            <div class="selectBoxGroup">
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
                    <label for="radio-<?php echo $answer; ?>"><?php echo $answer; ?></label>
                </div>
                <?php } ?>
            </div>
            <?php } else if ($nextQuestion->type == 5 && !empty($nextQuestion->answers)) {
            $isOther = true; ?>
            <?php if ($nextQuestion->id == 0) { ?>
            <div class="selectBoxGroup">
                <?php foreach (explode(",", $nextQuestion->answers) as $answer) { ?>
                <div class="selectBox radio">
                    <input type="radio" name="answer" id="radio-<?php echo $answer; ?>"
                        value="<?php echo $answer; ?>" <?php if (isset($currentAnswer) && (($answer == 'Yes' && $currentAnswer->answers != 'Yes' && $currentAnswer->answers != 'No') || ($answer == 'No' && $currentAnswer->answers == 'No'))) {
                            echo 'checked';
                        } ?>>
                    <label for="radio-<?php echo $answer; ?>"><?php echo $answer; ?></label>
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
                        <input type="text" name="other_answer" class="form-control"
                            id="extras" placeholder="Type here..."
                            value="<?php if (isset($currentAnswer) && $currentAnswer->answers != 'Yes' && $currentAnswer->answers != 'No') {
                                echo $currentAnswer->answers;
                            } ?>">
                    </div>
                </div>
                <?php } ?>
                <?php } ?>
            </div>
            <?php }
            if ($nextQuestion->id == 0) {
                if (isset($currentAnswer) && isset($currentAnswer->answers)) {
                    $answers = explode(",", $nextQuestion->answers);
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
                    <label for="radio-<?php echo $answer; ?>"><?php echo $answer; ?></label>
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
                <?php foreach (explode(",", $nextQuestion->answers) as $answer) { ?>
                <div class="selectBox radio">
                    <input type="radio" name="answer"
                        id="radio-<?php echo $answer; ?>" value="<?php echo $answer; ?>"
                        <?php if (isset($currentAnswer) && $answer == $currentAnswer->answers) {
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
                <label for="range-<?php echo $answer; ?>"><?php echo $answer; ?></label>
                <div class="text-center slidecontainer"
                    style="width: 50%;margin: 0 auto;">
                    <input required type="range" value="<?php if (isset($carange[$key])) {
                        echo $carange[$key];
                    } else {
                        echo '0';
                    } ?>"
                        min="0" max="10" step="1" name="answer[]"
                        class="form-control slider" id="range-<?php echo $answer; ?>"
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
                <label for="range-<?php echo $answer; ?>"><?php echo $answer; ?></label>
                <div class="text-center" style="width: 50%;margin: 0 auto;">
                    <?php if ($answer == 'Months') { ?>
                    <input id="months" required type="number"
                        value="<?php if (isset($carange[$key])) {
                            echo $carange[$key];
                        } else {
                            echo '0';
                        } ?>" min="0" step="1"
                        max="12" name="answer[]" class="form-control"
                        id="range-<?php echo $answer; ?>"
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
    {{-- </div>
</div> --}}
