<style type="text/css" media="screen">
div[id^=code-editor-], div[id^=solutions-editor-] {
	border: 1px solid grey !important;
	min-width: 50% !important;
	height: 300px;
}

label {
    display: block;
    margin: 20px 0 10px;
    font-size: 20px;
    font-weight: bold;
}

label.small {
    margin: 10px 0 10px;
    font-size: 14px;
    font-weight: normal;
}

input[type="text"], input[type="email"], input[type="password"], input[type="number"], input[type="url"], input[type="search"], textarea, select {
    border: 1px solid #999;
    box-sizing: content-box;
    width: 500px;
}
.test_class {
    
}

.remove-hint, .remove-test-editor, .remove-solution-editor {
    margin-bottom: 10px;
}
</style>
<div class="container">
    <div class="row-fluid">
        <div class="span6 offset3">
            <h1>Administrator panel</h1>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3">
            <?php echo $this->view()->render(array("element" => "admin-questions-left-menu"), array("controller" => 'edit_question')); ?>
        </div>
        <div class="span9">
            <?php echo $this->view()->render(array('element' => 'admin-edit-question'), array(
                        'action' => $action,
                        'question' => $question,
                        'testDir' => $testDir,
                        'solutionDir' => $solutionDir,
                        'errors' => $errors
                    )); ?>
        </div>
    </div>

</div> <!-- /container -->

<script src="/codelab/code/src-min-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="/codelab/code/src-min-noconflict/ext-language_tools.js"></script>

