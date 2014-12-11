<div class="container">
    <div class="row-fluid">
        <div class="span6 offset3">
            <h1>Administrator panel</h1>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3">
            <?=$this->view()->render(array("element" => "admin-questions-left-menu"), array("controller" => 'questions'));?>
        </div>
        <div class="span9 panel">
            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Level</th>
                    <th>Action</th>
                </tr>
                <?php if(count($questions) > 0):?>
                    <?php foreach($questions as $q):?>
                    <tr>
                        <td><?=$q->id;?></td>
                        <td><?=$q->title;?>
                        <td><?=$q->level;?></td>
                        <td>
                            <a href="/admin-questions/edit/<?=$q->id;?>">edit</a>
                            <a href="/admin-questions/delete/<?=$q->id;?>" onlcick="return confirm('ARE YOU SURE?');">delete</a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                <?php else:?>
                <tr>
                    <td colspan="4" class="center">
                        There is no added question yet.
                    </td>
                </tr>
                <?php endif;?>
            </table>      
        </div>
    </div>

</div> <!-- /container -->
