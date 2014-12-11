<form method="post" id="add-question" action="<?=$action;?>" enctype="multipart/form-data">
                <?php foreach($errors as $err):?>
                    <?php if(is_string($err)):?>
                        <div class="alert alert-danger"><?=$err;?></div>
                    <?php elseif(is_array($err)):?>
                        <?php foreach($err as $e):?>
                            <div class="alert alert-danger"><?=$e;?></div>
                        <?php endforeach;?>
                    <?php endif;?>
                <?php endforeach;?>
                <label>Title</label>
                <input type="text" name="title" required value="<?=!empty($question->title)?$question->title:(!empty($post['title'])?$post['title']:'');?>" />
                <label>Language</label>
                <select name="language">
                    <option value="java">Java</option>
                </select>
                <label>Level</label>
                <?=$this->form->select('level', ['' => '', 1 => '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'], ['value' => (!empty($question->level)?$question->level:(!empty($post['level'])?$post['level']:'')), 'required' => 'required']);?>
                <label>Categories</label>
                <div id="question-categories">
                    <?php $categories = []; $categoryString = ''; ?>
                    <?php if(!empty($question->id)):?>
                        <?php foreach($question->question_categories as $qCat):?>
                            <?php $categories[] = \app\models\Categories::find($qCat->category_id)->name;?>
                        <?php endforeach;?>
                        <?php $categoryString = implode(', ', $categories);?>
                    <?php elseif(!empty($post['categories'])):?>
                        <?php $categoryString = $post['categories'];?>
                    <?php endif;?>
                    
                    <input type="text" class="select-tag" name="categories" required value="<?=$categoryString;?>" />
                </div>
                <label>Description</label>
                <textarea style="height: 100px;" name="description" required><?=!empty($question->description)?$question->description:(!empty($post['description'])?$post['description']:'');?></textarea>
                <label>Tests</label>
                <label class="small"><input type="radio" name="code_input_type" value="git" /> Clone a Git repo</label>
                <label class="small"><input type="radio" name="code_input_type" value="files" /> Upload files</label>
                <label class="small"><input type="radio" name="code_input_type" value="editor" checked /> Use code editor</label>
                <div id="question-test-git" class="hidden">
                    <label>Git repo</label>
                    <input type="text" name="git_repo" placeholder="Repository URL..." /><br />
                    <input type="text" name="git_username" placeholder="Git username..." /><br />
                    <input type="password" name="git_password" placeholder="Git password..." />
                </div>
                <br />
                <div id="question-test-file" class="hidden">
                    <input type="file" multiple name="test_file[]" />
                </div>
                
                <div id="question-test-editor" class="hidden">
                    <?php $editor_num = 0;?>
                    <?php if(!empty($question->question_files)):?>
                    <?php foreach($question->question_files as $file):?>
                    <input type="text" name="test_class[filename][]" placeholder="ClassName.java" value="<?=$file->filename;?>" />
                    <div id="code-editor-<?=$editor_num++;?>"><?=file_get_contents($testDir.'/'.$file->filename);?></div><br />
                    <button class="btn small-btn btn-danger remove-test-editor">Remove class</button><br />
                    <?php endforeach;?>
                    <br />
                    <?php elseif(!empty($post['test_class']['filename'])):?>
                    <?php foreach($post['test_class']['filename'] as $k => $filename):?>
                    <input type="text" name="test_class[filename][]" placeholder="ClassName.java" value="<?=$filename;?>" />
                    <div id="code-editor-<?=$editor_num++;?>"><?=$post['test_class']['code'][$k];?></div><br />
                    <button class="btn small-btn btn-danger remove-test-editor">Remove class</button><br />
                    <?php endforeach;?>
                    <br />
                    <?php endif;?>
                    <?php if($editor_num == 0):?>
                    <input type="text" name="test_class[filename][]" placeholder="ClassName.java" />
                    <div id="code-editor-<?=$editor_num++;?>"></div><br />
                    <button class="btn small-btn btn-danger remove-test-editor">Remove class</button><br /><br />
                    <?php endif;?>
                    <button class="btn small-btn add-more-code">Add class</button><br />
                </div>
                
                <hr />
                
                <label>Solutions</label>
                <label class="small"><input type="radio" name="solutions_input_type" value="git" /> Clone a Git repo</label>
                <label class="small"><input type="radio" name="solutions_input_type" value="files" /> Upload files</label>
                <label class="small"><input type="radio" name="solutions_input_type" value="editor" checked /> Use code editor</label>
                <div id="question-solutions-git" class="hidden">
                    <label>Git repo</label>
                    <input type="text" name="git_solutions_repo" placeholder="Repository URL..." /><br />
                    <input type="text" name="git_solutions_username" placeholder="Git username..." /><br />
                    <input type="password" name="git_solutions_password" placeholder="Git password..." />
                </div>
                <br />
                <div id="question-solutions-file" class="hidden">
                    <input type="file" multiple name="solutions_file[]" />
                </div>
                
                <div id="question-solutions-editor" class="hidden">
                    <?php $editor_num = 0;?>
                    <?php if(!empty($question->question_solutions)):?>
                    <?php foreach($question->question_solutions as $file):?>
                    <input type="text" name="solutions_class[filename][]" placeholder="ClassName.java" value="<?=$file->filename;?>" />
                    <div id="solutions-editor-<?=$editor_num++;?>"><?=file_get_contents($solutionDir.'/'.$file->filename);?></div><br />
                    <button class="btn small-btn btn-danger remove-solution-editor">Remove class</button><br />
                    <?php endforeach;?>
                    <br />
                    <?php elseif(!empty($post['solutions_class']['filename'])):?>
                    <?php foreach($post['solutions_class']['filename'] as $k => $filename):?>
                    <input type="text" name="solutions_class[filename][]" placeholder="ClassName.java" value="<?=$filename;?>" />
                    <div id="solutions-editor-<?=$editor_num++;?>"><?=$post['solutions_class']['code'][$k];?></div><br />
                    <button class="btn small-btn btn-danger remove-solution-editor">Remove class</button><br />
                    <?php endforeach;?>
                    <br />
                    <?php endif;?>
                    <?php if($editor_num == 0):?>
                    <input type="text" name="solutions_class[filename][]" placeholder="ClassName.java" />
                    <div id="solutions-editor-<?=$editor_num++;?>"></div><br />
                    <button class="btn small-btn btn-danger remove-solution-editor">Remove class</button><br /><br />
                    <?php endif;?>
                    <button class="btn small-btn add-more-solutions">Add class</button><br />
                </div>
                <hr />
                <label>Hints</label>
                <?php $hintCount = 0;?>
                <?php if(!empty($question->question_hints) && count($question->question_hints) > 0):?>
                <?php foreach($question->question_hints as $hint):?>
                <?php $hintCount++;?>
                <textarea class="question-hints" name="hint[]"><?=htmlspecialchars($hint->hint);?></textarea><br />
                <button class="btn small-btn btn-danger remove-hint">Remove hint</button><br />
                <?php endforeach;?>
                <?php elseif(!empty($post['hint'])):?>
                <?php foreach($post['hint'] as $hint):?>
                <?php if(strlen(trim($hint)) == 0) continue;?>
                <?php $hintCount++;?>
                <textarea class="question-hints" name="hint[]"><?=htmlspecialchars($hint);?></textarea><br />
                <button class="btn small-btn btn-danger remove-hint">Remove hint</button><br />
                <?php endforeach;?>
                <?php endif;?>
                <?php if($hintCount == 0):?>
                <textarea class="question-hints" name="hint[]"></textarea><br />
                <button class="btn small-btn btn-danger remove-hint">Remove hint</button><br />
                <?php endif;?>
                <br />
                <button class="btn small-btn add-more-hint">Add hint</button>
                <hr />
                <input type="submit" value="Save" class="btn btn-success" />
            </form>
