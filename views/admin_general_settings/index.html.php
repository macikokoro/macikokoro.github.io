<style>
table th {
    font-size: 25px;
    text-align: center;
    line-height: 30px;
    padding: 20px 0;
}
table td {
    padding-left: 15px;
    padding-right: 15px;
}
table td.center {
    text-align: center;
}
table td label {
    
    font-size: 15px;
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
            <?=$this->view()->render(array("element" => "admin-left-menu"), array('controller' => $controller));?>
        </div>
        <div class="span9 panel">
            <form action="/admin-general-settings/save" method="post">
                <table class="">
                    <tr>
                        <th colspan="2">Global git settings</th>
                    </tr>
                    <tr>
                        <td><label>USER.NAME</label></td>
                        <td>
                            <input required type="text" name="git_user_name" value="<?=!empty($general_settings['git_user_name'])?
                                            $general_settings['git_user_name']:'';?>" />
                        </td>
                    </tr>
                    <tr>
                        <td><label>USER.EMAIL</label></td>
                        <td>
                            <input required type="text" name="git_user_email" value="<?=!empty($general_settings['git_user_email'])?
                                            $general_settings['git_user_email']:'';?>" />
                        </td>
                    </tr>
                    <tr>
                        <th colspan="2">Git repository for testing files</th>
                    </tr>
                    <tr>
                        <td><label>REPO URL</label></td>
                        <td>
                            <input required type="text" name="git_test_repo_url" value="<?=!empty($general_settings['git_test_repo_url'])?
                                            $general_settings['git_test_repo_url']:'';?>" />
                        </td>
                    </tr>
                    <tr>
                        <td><label>REPO USERNAME</label></td>
                        <td>
                            <input required type="text" name="git_test_repo_username" value="<?=!empty($general_settings['git_test_repo_username'])?
                                            $general_settings['git_test_repo_username']:'';?>" />
                        </td>
                    </tr>
                    <tr>
                        <td><label>REPO PASSWORD</label></td>
                        <td>
                            <input required type="text" name="git_test_repo_password" value="<?=!empty($general_settings['git_test_repo_password'])?
                                            $general_settings['git_test_repo_password']:'';?>" />
                        </td>
                    </tr>
                    <tr>
                        <th colspan="2">Git repository for solution files</th>
                    </tr>
                    <tr>
                        <td><label>REPO URL</label></td>
                        <td>
                            <input required type="text" name="git_solution_repo_url" value="<?=!empty($general_settings['git_solution_repo_url'])?
                                            $general_settings['git_solution_repo_url']:'';?>" />
                        </td>
                    </tr>
                    <tr>
                        <td><label>REPO USERNAME</label></td>
                        <td>
                            <input required type="text" name="git_solution_repo_username" value="<?=!empty($general_settings['git_solution_repo_username'])?
                                            $general_settings['git_solution_repo_username']:'';?>" />
                        </td>
                    </tr>
                    <tr>
                        <td><label>REPO PASSWORD</label></td>
                        <td>
                            <input required type="text" name="git_solution_repo_password" value="<?=!empty($general_settings['git_solution_repo_password'])?
                                            $general_settings['git_solution_repo_password']:'';?>" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr /></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="center"><input type="submit" value="Save" class="btn btn-success" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

</div> <!-- /container -->
