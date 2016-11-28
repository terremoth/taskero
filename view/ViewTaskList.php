<?php

class ViewTaskList extends MainView {

    public function __construct() {
        $aCSS = array(
            'bootstrap.min',
            'bootstrap-theme.min',
            'template',
            'jquery.dataTables.min',
        );
        
        $this->loadHead($aCSS);
        ?>

                <!-- Fixed navbar -->
                <nav class="navbar navbar-default navbar-fixed-top">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="#"><?php $this->loadImage('taskero.png', '200', null, null, 'margin-top:-10px'); ?></a>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="#">Home</a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li><button onclick="createNewTask();" style="margin-top: 5px" class="btn btn-success">Create Task</button></li>
                            </ul>
                        </div><!--/.nav-collapse -->
                    </div>
                </nav>

                <div class="container">

                    <div class="row">
                        <h1>Tasks To-Do</h1>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Task Name</th>
                                    <th>Task Date</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>dsf</td>
                                    <td>dsg</td>
                                    <td>gdhdf</td>
                                </tr>
                                <tr>
                                    <td>dasdas</td>
                                    <td>dasdas</td>
                                    <td>dasd</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div> <!-- /container -->
                <script>
                    function createNewTask(){
                        window.location.href = '<?php echo HOME_URI.'/CreateTaskList/'?>';
                    }
                </script>
        <?php
                
            $aScripts = array(
                'jquery-3.1.1.min',
                'bootstrap.min',
                'jquery.dataTables.min'
            );
            
          
            
            $this->loadPageEnd($aScripts);
    }

}
