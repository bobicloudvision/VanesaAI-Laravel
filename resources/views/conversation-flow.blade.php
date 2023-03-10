<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conversation Flow | {{$intentTopic->name}}</title>
    <meta name="description" content="Simple library for flow programming. Drawflow allows you to create data flows easily and quickly.">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/jerosoler/Drawflow/dist/drawflow.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/jerosoler/Drawflow@0.0.48/dist/drawflow.min.css">
<link rel="stylesheet" type="text/css" href="{{asset('flow/beautiful.css')}}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<header>
    <h2>{{$intentTopic->name}}</h2>
    <div class="github-link"><a href="https://github.com/jerosoler/Drawflow" target="_blank"><i class="fab fa-github fa-3x"></i></a></div>
    <div class="them-edit-link"><a href="https://jerosoler.github.io/drawflow-theme-generator/" target="_blank">🎨</a></div>
</header>
<div class="wrapper">
    <div class="col">
        <div class="drag-drawflow" draggable="true" ondragstart="drag(event)" data-node="facebook">
            <i class="fab fa-facebook"></i><span> Facebook</span>
        </div>
        <div class="drag-drawflow" draggable="true" ondragstart="drag(event)" data-node="slack">
            <i class="fab fa-slack"></i><span> Slack recive message</span>
        </div>
        <div class="drag-drawflow" draggable="true" ondragstart="drag(event)" data-node="github">
            <i class="fab fa-github"></i><span> Github Star</span>
        </div>
        <div class="drag-drawflow" draggable="true" ondragstart="drag(event)" data-node="telegram">
            <i class="fab fa-telegram"></i><span> Telegram send message</span>
        </div>
        <div class="drag-drawflow" draggable="true" ondragstart="drag(event)" data-node="aws">
            <i class="fab fa-aws"></i><span> AWS</span>
        </div>
        <div class="drag-drawflow" draggable="true" ondragstart="drag(event)" data-node="log">
            <i class="fas fa-file-signature"></i><span> File Log</span>
        </div>
        <div class="drag-drawflow" draggable="true" ondragstart="drag(event)" data-node="google">
            <i class="fab fa-google-drive"></i><span> Google Drive save</span>
        </div>
        <div class="drag-drawflow" draggable="true" ondragstart="drag(event)" data-node="email">
            <i class="fas fa-at"></i><span> Email send</span>
        </div>
        <div class="drag-drawflow" draggable="true" ondragstart="drag(event)" data-node="template">
            <i class="fas fa-code"></i><span> Template</span>
        </div>
        <div class="drag-drawflow" draggable="true" ondragstart="drag(event)" data-node="multiple">
            <i class="fas fa-code-branch"></i><span> Multiple inputs/outputs</span>
        </div>
        <div class="drag-drawflow" draggable="true" ondragstart="drag(event)" data-node="personalized">
            <i class="fas fa-fill"></i><span> Personalized</span>
        </div>
        <div class="drag-drawflow" draggable="true" ondragstart="drag(event)" data-node="dbclick">
            <i class="fas fa-mouse"></i><span> DBClick!</span>
        </div>


    </div>
    <div class="col-right">
        <div class="menu">
            <ul>
                <li onclick="editor.changeModule('Home'); changeModule(event);" class="selected">Home</li>
                <li onclick="editor.changeModule('Other'); changeModule(event);">Other Module</li>
            </ul>
        </div>
        <div id="drawflow" ondrop="drop(event)" ondragover="allowDrop(event)">

            <div class="btn-export" onclick="Swal.fire({ title: 'Export',
        html: '<pre><code>'+JSON.stringify(editor.export(), null,4)+'</code></pre>'
        })">Export</div>
            <div class="btn-clear" onclick="editor.clearModuleSelected()">Clear</div>
            <div class="btn-lock">
                <i id="lock" class="fas fa-lock" onclick="editor.editor_mode='fixed'; changeMode('lock');"></i>
                <i id="unlock" class="fas fa-lock-open" onclick="editor.editor_mode='edit'; changeMode('unlock');" style="display:none;"></i>
            </div>
            <div class="bar-zoom">
                <i class="fas fa-search-minus" onclick="editor.zoom_out()"></i>
                <i class="fas fa-search" onclick="editor.zoom_reset()"></i>
                <i class="fas fa-search-plus" onclick="editor.zoom_in()"></i>
            </div>
        </div>
    </div>
</div>

<script>
    var id = document.getElementById("drawflow");
    const editor = new Drawflow(id);
    editor.reroute = true;
    @if(empty($intentTopic->flow_json))
    const dataToImport = {
        "drawflow": {
            "Home": {
                "data": {}
            },
            "Other": {
                "data": {}
            }
        }
    }
    @else
    const dataToImport = {!! $intentTopic->flow_json !!};
    @endif
    editor.start();
    editor.import(dataToImport);


    /*
      var welcome = `
      <div>
        <div class="title-box">👏 Welcome!!</div>
        <div class="box">
          <p>Simple flow library <b>demo</b>
          <a href="https://github.com/jerosoler/Drawflow" target="_blank">Drawflow</a> by <b>Jero Soler</b></p><br>

          <p>Multiple input / outputs<br>
             Data sync nodes<br>
             Import / export<br>
             Modules support<br>
             Simple use<br>
             Type: Fixed or Edit<br>
             Events: view console<br>
             Pure Javascript<br>
          </p>
          <br>
          <p><b><u>Shortkeys:</u></b></p>
          <p>🎹 <b>Delete</b> for remove selected<br>
          💠 Mouse Left Click == Move<br>
          ❌ Mouse Right == Delete Option<br>
          🔍 Ctrl + Wheel == Zoom<br>
          📱 Mobile support<br>
          ...</p>
        </div>
      </div>
      `;
  */


    //editor.addNode(name, inputs, outputs, posx, posy, class, data, html);
    /*editor.addNode('welcome', 0, 0, 50, 50, 'welcome', {}, welcome );
    editor.addModule('Other');
    */

    // Events!
    editor.on('nodeCreated', function(id) {
        console.log("Node created " + id);
    })

    editor.on('nodeRemoved', function(id) {
        console.log("Node removed " + id);
    })

    editor.on('nodeSelected', function(id) {
        console.log("Node selected " + id);
    })

    editor.on('moduleCreated', function(name) {
        console.log("Module Created " + name);
    })

    editor.on('moduleChanged', function(name) {
        console.log("Module Changed " + name);
    })

    editor.on('connectionCreated', function(connection) {
        console.log('Connection created');
        console.log(connection);
    })

    editor.on('connectionRemoved', function(connection) {
        console.log('Connection removed');
        console.log(connection);
    })

    editor.on('mouseMove', function(position) {
        console.log('Position mouse x:' + position.x + ' y:'+ position.y);
    })

    editor.on('nodeMoved', function(id) {
        console.log("Node moved " + id);

        $.ajax({
            type: "POST",
            url: "{{route('flow.save', $intentTopic->id)}}",
            data: {
                flowJson: JSON.stringify(editor.export(), null,4)
            },
        });
    })

    editor.on('zoom', function(zoom) {
        console.log('Zoom level ' + zoom);
    })

    editor.on('translate', function(position) {
        console.log('Translate x:' + position.x + ' y:'+ position.y);
    })

    editor.on('addReroute', function(id) {
        console.log("Reroute added " + id);
    })

    editor.on('removeReroute', function(id) {
        console.log("Reroute removed " + id);
    })

    /* DRAG EVENT */

    /* Mouse and Touch Actions */

    var elements = document.getElementsByClassName('drag-drawflow');
    for (var i = 0; i < elements.length; i++) {
        elements[i].addEventListener('touchend', drop, false);
        elements[i].addEventListener('touchmove', positionMobile, false);
        elements[i].addEventListener('touchstart', drag, false );
    }

    var mobile_item_selec = '';
    var mobile_last_move = null;
    function positionMobile(ev) {
        mobile_last_move = ev;
    }

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        if (ev.type === "touchstart") {
            mobile_item_selec = ev.target.closest(".drag-drawflow").getAttribute('data-node');
        } else {
            ev.dataTransfer.setData("node", ev.target.getAttribute('data-node'));
        }
    }

    function drop(ev) {
        if (ev.type === "touchend") {
            var parentdrawflow = document.elementFromPoint( mobile_last_move.touches[0].clientX, mobile_last_move.touches[0].clientY).closest("#drawflow");
            if(parentdrawflow != null) {
                addNodeToDrawFlow(mobile_item_selec, mobile_last_move.touches[0].clientX, mobile_last_move.touches[0].clientY);
            }
            mobile_item_selec = '';
        } else {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("node");
            addNodeToDrawFlow(data, ev.clientX, ev.clientY);
        }

    }

    function addNodeToDrawFlow(name, pos_x, pos_y) {
        if(editor.editor_mode === 'fixed') {
            return false;
        }
        pos_x = pos_x * ( editor.precanvas.clientWidth / (editor.precanvas.clientWidth * editor.zoom)) - (editor.precanvas.getBoundingClientRect().x * ( editor.precanvas.clientWidth / (editor.precanvas.clientWidth * editor.zoom)));
        pos_y = pos_y * ( editor.precanvas.clientHeight / (editor.precanvas.clientHeight * editor.zoom)) - (editor.precanvas.getBoundingClientRect().y * ( editor.precanvas.clientHeight / (editor.precanvas.clientHeight * editor.zoom)));


        switch (name) {
            case 'facebook':
                var facebook = `
        <div>
          <div class="title-box"><i class="fab fa-facebook"></i> Facebook Message</div>
        </div>
        `;
                editor.addNode('facebook', 0,  1, pos_x, pos_y, 'facebook', {}, facebook );
                break;
            case 'slack':
                var slackchat = `
          <div>
            <div class="title-box"><i class="fab fa-slack"></i> Slack chat message</div>
          </div>
          `
                editor.addNode('slack', 1, 0, pos_x, pos_y, 'slack', {}, slackchat );
                break;
            case 'github':
                var githubtemplate = `
          <div>
            <div class="title-box"><i class="fab fa-github "></i> Github Stars</div>
            <div class="box">
              <p>Enter repository url</p>
            <input type="text" df-name>
            </div>
          </div>
          `;
                editor.addNode('github', 0, 1, pos_x, pos_y, 'github', { "name": ''}, githubtemplate );
                break;
            case 'telegram':
                var telegrambot = `
          <div>
            <div class="title-box"><i class="fab fa-telegram-plane"></i> Telegram bot</div>
            <div class="box">
              <p>Send to telegram</p>
              <p>select channel</p>
              <select df-channel>
                <option value="channel_1">Channel 1</option>
                <option value="channel_2">Channel 2</option>
                <option value="channel_3">Channel 3</option>
                <option value="channel_4">Channel 4</option>
              </select>
            </div>
          </div>
          `;
                editor.addNode('telegram', 1, 0, pos_x, pos_y, 'telegram', { "channel": 'channel_3'}, telegrambot );
                break;
            case 'aws':
                var aws = `
          <div>
            <div class="title-box"><i class="fab fa-aws"></i> Aws Save </div>
            <div class="box">
              <p>Save in aws</p>
              <input type="text" df-db-dbname placeholder="DB name"><br><br>
              <input type="text" df-db-key placeholder="DB key">
              <p>Output Log</p>
            </div>
          </div>
          `;
                editor.addNode('aws', 1, 1, pos_x, pos_y, 'aws', { "db": { "dbname": '', "key": '' }}, aws );
                break;
            case 'log':
                var log = `
            <div>
              <div class="title-box"><i class="fas fa-file-signature"></i> Save log file </div>
            </div>
            `;
                editor.addNode('log', 1, 0, pos_x, pos_y, 'log', {}, log );
                break;
            case 'google':
                var google = `
            <div>
              <div class="title-box"><i class="fab fa-google-drive"></i> Google Drive save </div>
            </div>
            `;
                editor.addNode('google', 1, 0, pos_x, pos_y, 'google', {}, google );
                break;
            case 'email':
                var email = `
            <div>
              <div class="title-box"><i class="fas fa-at"></i> Send Email </div>
            </div>
            `;
                editor.addNode('email', 1, 0, pos_x, pos_y, 'email', {}, email );
                break;

            case 'template':
                var template = `
            <div>
              <div class="title-box"><i class="fas fa-code"></i> Template</div>
              <div class="box">
                Ger Vars
                <textarea df-template></textarea>
                Output template with vars
              </div>
            </div>
            `;
                editor.addNode('template', 1, 1, pos_x, pos_y, 'template', { "template": 'Write your template'}, template );
                break;
            case 'multiple':
                var multiple = `
            <div>
              <div class="box">
                Multiple!
              </div>
            </div>
            `;
                editor.addNode('multiple', 3, 4, pos_x, pos_y, 'multiple', {}, multiple );
                break;
            case 'personalized':
                var personalized = `
            <div>
              Personalized
            </div>
            `;
                editor.addNode('personalized', 1, 1, pos_x, pos_y, 'personalized', {}, personalized );
                break;
            case 'dbclick':
                var dbclick = `
            <div>
            <div class="title-box"><i class="fas fa-mouse"></i> Db Click</div>
              <div class="box dbclickbox" ondblclick="showpopup(event)">
                Db Click here
                <div class="modal" style="display:none">
                  <div class="modal-content">
                    <span class="close" onclick="closemodal(event)">&times;</span>
                    Change your variable {name} !
                    <input type="text" df-name>
                  </div>

                </div>
              </div>
            </div>
            `;
                editor.addNode('dbclick', 1, 1, pos_x, pos_y, 'dbclick', { name: ''}, dbclick );
                break;

            default:
        }
    }

    var transform = '';
    function showpopup(e) {
        e.target.closest(".drawflow-node").style.zIndex = "9999";
        e.target.children[0].style.display = "block";
        //document.getElementById("modalfix").style.display = "block";

        //e.target.children[0].style.transform = 'translate('+translate.x+'px, '+translate.y+'px)';
        transform = editor.precanvas.style.transform;
        editor.precanvas.style.transform = '';
        editor.precanvas.style.left = editor.canvas_x +'px';
        editor.precanvas.style.top = editor.canvas_y +'px';
        console.log(transform);

        //e.target.children[0].style.top  =  -editor.canvas_y - editor.container.offsetTop +'px';
        //e.target.children[0].style.left  =  -editor.canvas_x  - editor.container.offsetLeft +'px';
        editor.editor_mode = "fixed";

    }

    function closemodal(e) {
        e.target.closest(".drawflow-node").style.zIndex = "2";
        e.target.parentElement.parentElement.style.display  ="none";
        //document.getElementById("modalfix").style.display = "none";
        editor.precanvas.style.transform = transform;
        editor.precanvas.style.left = '0px';
        editor.precanvas.style.top = '0px';
        editor.editor_mode = "edit";
    }

    function changeModule(event) {
        var all = document.querySelectorAll(".menu ul li");
        for (var i = 0; i < all.length; i++) {
            all[i].classList.remove('selected');
        }
        event.target.classList.add('selected');
    }

    function changeMode(option) {

        //console.log(lock.id);
        if(option == 'lock') {
            lock.style.display = 'none';
            unlock.style.display = 'block';
        } else {
            lock.style.display = 'block';
            unlock.style.display = 'none';
        }

    }

</script>
</body>
</html>