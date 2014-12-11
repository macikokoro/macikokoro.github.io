$(function(){
    $(".add-more-code").click(function(e){
        e.preventDefault();
        var id = 'code-editor-' + $("#question-test-editor textarea").length;
        $(".remove-test-editor:last").after("<br /><input type=\"text\" name=\"test_class[filename][]\" placeholder=\"ClassName.java\" />"+
                "<div id='" + id + "'></div><br /><button class='btn small-btn btn-danger remove-test-editor'>Remove class</button>");
        initCodeEditor($("#question-test-editor div[id^=code-editor-]:last")[0]);
        $(".remove-test-editor:last").click(removeClassEditor);
        if($('.remove-test-editor').length == 1) {
            $('.remove-test-editor').addClass('hidden');
        } else {
            $('.remove-test-editor').removeClass('hidden');
        }
    });
    $(".add-more-solutions").click(function(e){
        e.preventDefault();
        var id = 'solutions-editor-' + $("#question-solutions-editor textarea").length;
        $(".remove-solution-editor:last").after("<br /><input type=\"text\" name=\"solutions_class[filename][]\" placeholder=\"ClassName.java\" />"+
                "<div id='" + id + "'></div><br /><button class='btn small-btn btn-danger remove-solution-editor'>Remove class</button>");
        initCodeEditor($("#question-solutions-editor div[id^=solutions-editor-]:last")[0]);
        $(".remove-solution-editor:last").click(removeClassEditor);
        if($('.remove-solution-editor').length == 1) {
            $('.remove-solution-editor').addClass('hidden');
        } else {
            $('.remove-solution-editor').removeClass('hidden');
        }
    });
    $(".add-more-hint").click(function(e){
        e.preventDefault();
        $('.remove-hint:last').after('<br /><textarea name=\'hint[]\' class=\'question-hints\'></textarea><br />' + 
                '<button class="btn small-btn btn-danger remove-hint">Remove hint</button>');
        $('.remove-hint:last').click(function(e){
            e.preventDefault();
            if($('.remove-hint').length > 1) {
                $(this).prev().remove();
                $(this).prev().remove();
                $(this).next().remove();
                $(this).remove();
                if($('.remove-hint').length == 1) {
                    $('.remove-hint').addClass('hidden');
                }
            }
        });
        if($('.remove-hint').length == 1) {
            $('.remove-hint').addClass('hidden');
        } else {
            $('.remove-hint').removeClass('hidden');
        }
    });
    $('.remove-hint').click(function(e){
        e.preventDefault();
        if($('.remove-hint').length > 1) {
            $(this).prev().remove();
            $(this).prev().remove();
            $(this).next().remove();
            $(this).remove();
            if($('.remove-hint').length == 1) {
                $('.remove-hint').addClass('hidden');
            }
        }
    });
    var removeClassEditor = function(e){
        e.preventDefault();
        var clName = $(this).hasClass('remove-test-editor') ? '.remove-test-editor' : '.remove-solution-editor';
        if($(clName).length > 1) {
            $(this).prev().remove();
            $(this).prev().remove();
            $(this).prev().remove();
            $(this).next().remove();
            $(this).remove();
            if($(clName).length == 1) {
                $(clName).addClass('hidden');
            }
        }
    };
    $('.remove-test-editor, .remove-solution-editor').click(removeClassEditor);
    if($('.remove-hint').length == 1) {
        $('.remove-hint').addClass('hidden');
    }
    if($('.remove-test-editor').length == 1) {
        $('.remove-test-editor').addClass('hidden');
    }
    if($('.remove-solution-editor').length == 1) {
        $('.remove-solution-editor').addClass('hidden');
    }
    if($("input:radio[name=code_input_type]:checked").length > 0) {
        switch($("input:radio[name=code_input_type]:checked").val()) {
            case 'git':
                $('[id^=question-test-]').addClass('hidden');
                $('#question-test-git').removeClass('hidden');
                break;
            case 'files':
                $('[id^=question-test-]').addClass('hidden');
                $('#question-test-file').removeClass('hidden');
                break;
            case 'editor':
                $('[id^=question-test-]').addClass('hidden');
                $('#question-test-editor').removeClass('hidden');
                break;
        }
    }
    if($("input:radio[name=solutions_input_type]:checked").length > 0) {
        switch($("input:radio[name=solutions_input_type]:checked").val()) {
            case 'git':
                $('[id^=question-solutions-]').addClass('hidden');
                $('#question-solutions-git').removeClass('hidden');
                break;
            case 'files':
                $('[id^=question-solutions-]').addClass('hidden');
                $('#question-solutions-file').removeClass('hidden');
                break;
            case 'editor':
                $('[id^=question-solutions-]').addClass('hidden');
                $('#question-solutions-editor').removeClass('hidden');
                break;
        }
    }
    
    $("input:radio[name=code_input_type]").change(function(){
        switch($(this).val()) {
            case 'git':
                $('[id^=question-test-]').addClass('hidden');
                $('#question-test-git').removeClass('hidden');
                break;
            case 'files':
                $('[id^=question-test-]').addClass('hidden');
                $('#question-test-file').removeClass('hidden');
                break;
            case 'editor':
                $('[id^=question-test-]').addClass('hidden');
                $('#question-test-editor').removeClass('hidden');
                break;
        }
    });
    
    $("input:radio[name=solutions_input_type]").change(function(){
        switch($(this).val()) {
            case 'git':
                $('[id^=question-solutions-]').addClass('hidden');
                $('#question-solutions-git').removeClass('hidden');
                break;
            case 'files':
                $('[id^=question-solutions-]').addClass('hidden');
                $('#question-solutions-file').removeClass('hidden');
                break;
            case 'editor':
                $('[id^=question-solutions-]').addClass('hidden');
                $('#question-solutions-editor').removeClass('hidden');
                break;
        }
    });
    
    var initCodeEditor = function(el) {
        // trigger extension
        ace.require("ace/ext/language_tools");
        var editor = ace.edit(el.id);
        editor.session.setMode("ace/mode/java");
        editor.setTheme("ace/theme/tomorrow");
        // enable autocompletion and snippets
        editor.setOptions({
            enableBasicAutocompletion: true,
            enableSnippets: true
        });  
    };
    
    // init code editor
    if($("div[id^=code-editor-]").length > 0) {
        $("div[id^=code-editor-]").each(function(){
            initCodeEditor(this);
        });
    }
    if($("div[id^=solutions-editor-]").length > 0) {
        $("div[id^=solutions-editor-]").each(function(){
            initCodeEditor(this);
        });
    }
    
    $("#add-question").submit(function(){
        $("div[id^=code-editor-]").each(function(){
            $("#add-question").append('<textarea name="test_class[code][]" class="test_class hidden"></textarea>');
            $("textarea.test_class:last").val(ace.edit(this.id).getSession().getValue());
        });
        $("div[id^=solutions-editor-]").each(function(){
            $("#add-question").append('<textarea name="solutions_class[code][]" class="solutions_class hidden"></textarea>');
            $("textarea.solutions_class:last").val(ace.edit(this.id).getSession().getValue());
        });
    });
    
    $("#push_solutions_to_git").change(function(){
        if(this.checked) {
            $("#solution-remote-git").removeClass('hidden');
            $("#solution-remote-git input").attr('required', 'required');
        } else {
            $("#solution-remote-git").addClass('hidden');
            $("#solution-remote-git input").removeAttr('required');
        }
    });
    $("#push_test_to_git").change(function(){
        if(this.checked) {
            $("#test-remote-git").removeClass('hidden');
            $("#test-remote-git input").attr('required', 'required');
        } else {
            $("#test-remote-git").addClass('hidden');
            $("#test-remote-git input").removeAttr('required');
        }
    });
});
